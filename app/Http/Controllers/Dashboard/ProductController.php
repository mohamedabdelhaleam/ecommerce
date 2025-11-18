<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\products\StoreProductRequest;
use App\Http\Requests\Dashboard\products\UpdateProductRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;

        $this->middleware('permission:view products')->only(['index', 'show']);
        $this->middleware('permission:create products')->only(['create', 'store']);
        $this->middleware('permission:edit products')->only(['edit', 'update', 'updateVariantPrice', 'updateVariantStock', 'storeImage', 'updateImage']);
        $this->middleware('permission:delete products')->only(['destroy', 'deleteImage', 'deleteVariant']);
        $this->middleware('permission:toggle products status')->only(['toggleStatus', 'toggleVariantStatus']);
    }

    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $filters = $this->productRepository->buildFiltersFromRequest($request);
        $products = $this->productRepository->all($filters);
        $categories = Category::all();

        // If AJAX request, return JSON with table HTML
        if ($request->ajax() || $request->wantsJson()) {
            $tableHtml = view('dashboard.pages.products.partials.table', compact('products'))->render();
            $paginationHtml = '';

            if ($products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) {
                $paginationHtml = $this->productRepository->getPaginationHtml($products);
            }

            return response()->json([
                'success' => true,
                'table' => $tableHtml,
                'pagination' => $paginationHtml,
            ]);
        }

        return view('dashboard.pages.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all();
        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        return view('dashboard.pages.products.create', compact('categories', 'colors', 'sizes'));
    }

    /**
     * Store a newly created product in storage.
     *
     * @param StoreProductRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductRequest $request)
    {
        $product = $this->productRepository->create($request->validated());

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'product_id' => $product->id,
                'id' => $product->id,
            ]);
        }

        // Redirect to step 2 (variants) instead of index
        return redirect()
            ->route('dashboard.products.create.variants', $product)
            ->with('success', 'Product created. Now add variants.');
    }

    /**
     * Show step 2: Add variants (colors, sizes, stock, price)
     *
     * @param Product $product
     * @return View
     */
    public function createVariants(Product $product): View
    {
        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        $product->load('variants.color', 'variants.size');
        return view('dashboard.pages.products.create-variants', compact('product', 'colors', 'sizes'));
    }

    /**
     * Store variants for a product
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeVariants(Request $request, Product $product)
    {
        $validated = $request->validate([
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.size_id' => 'nullable|exists:sizes,id',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
        ]);

        // Get existing variant IDs to track which ones to delete
        $existingVariantIds = $product->variants()->pluck('id')->toArray();
        $submittedVariantIds = [];

        if (!empty($validated['variants'])) {
            foreach ($validated['variants'] as $variantData) {
                // Generate SKU
                $skuPrefix = strtoupper(substr($product->slug ?? 'PROD', 0, 4)) . '-' . str_pad($product->id, 3, '0', STR_PAD_LEFT);

                $sizeSlug = 'M';
                if ($variantData['size_id'] ?? null) {
                    $size = Size::find($variantData['size_id']);
                    $sizeSlug = $size ? ($size->slug ?? 'M') : 'M';
                }

                $colorSlug = 'DEF';
                if ($variantData['color_id'] ?? null) {
                    $color = Color::find($variantData['color_id']);
                    $colorSlug = $color ? ($color->slug ?? 'DEF') : 'DEF';
                }

                // Check if this is an update or create
                if (isset($variantData['id']) && $variantData['id']) {
                    // Update existing variant
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant && $variant->product_id == $product->id) {
                        $submittedVariantIds[] = $variant->id;

                        // Generate SKU if not exists
                        if (!$variant->sku) {
                            $variantCount = $product->variants()->count() + 1;
                            $sku = $skuPrefix . '-' . strtoupper($sizeSlug) . '-' . strtoupper($colorSlug) . '-' . str_pad($variantCount, 3, '0', STR_PAD_LEFT);
                        } else {
                            $sku = $variant->sku;
                        }

                        $variant->update([
                            'color_id' => $variantData['color_id'] ?? null,
                            'size_id' => $variantData['size_id'] ?? null,
                            'price' => $variantData['price'],
                            'stock' => $variantData['stock'],
                            'sku' => $sku,
                        ]);
                    }
                } else {
                    // Create new variant
                    $variantCount = $product->variants()->count() + 1;
                    $sku = $skuPrefix . '-' . strtoupper($sizeSlug) . '-' . strtoupper($colorSlug) . '-' . str_pad($variantCount, 3, '0', STR_PAD_LEFT);

                    ProductVariant::create([
                        'product_id' => $product->id,
                        'color_id' => $variantData['color_id'] ?? null,
                        'size_id' => $variantData['size_id'] ?? null,
                        'price' => $variantData['price'],
                        'stock' => $variantData['stock'],
                        'sku' => $sku,
                        'is_active' => true,
                    ]);
                }
            }
        }

        // Delete variants that were removed
        $variantsToDelete = array_diff($existingVariantIds, $submittedVariantIds);
        if (!empty($variantsToDelete)) {
            ProductVariant::whereIn('id', $variantsToDelete)
                ->where('product_id', $product->id)
                ->delete();
        }

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => empty($validated['variants']) ? 'Skipped variants. Now add images.' : 'Variants saved successfully.',
            ]);
        }

        return redirect()
            ->route('dashboard.products.create.images', $product)
            ->with('success', empty($validated['variants']) ? 'Skipped variants. Now add images.' : 'Variants added. Now add images.');
    }

    /**
     * Show step 3: Add images for colors
     *
     * @param Product $product
     * @return View
     */
    public function createImages(Product $product): View
    {
        $colors = Color::active()->get();
        $product->load('variants.color');
        $productColors = $product->variants->pluck('color')->filter()->unique('id')->values();
        return view('dashboard.pages.products.create-images', compact('product', 'colors', 'productColors'));
    }

    /**
     * Complete product creation
     *
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeCreation(Product $product)
    {
        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $product = $this->productRepository->findOrFail($product->id);
        $product->load([
            'category',
            'images',
            'variants.color',
            'variants.size',
            'comments' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            }
        ]);
        return view('dashboard.pages.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     *
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $product = $this->productRepository->findOrFail($product->id);
        $product->load(['images.color', 'variants.color', 'variants.size']);
        $categories = Category::all();
        $colors = Color::active()->get();
        $sizes = Size::active()->get();
        return view('dashboard.pages.products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->productRepository->findOrFail($product->id);

        $this->productRepository->update($product->id, $request->validated());

        // If AJAX request, return JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
            ]);
        }

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Toggle the status of the specified product.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $updatedProduct = $this->productRepository->toggleStatus(
                $product->id,
                $validated['is_active']
            );

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully.',
                'is_active' => $updatedProduct->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status. Please try again.',
            ], 500);
        }
    }

    /**
     * Toggle the status of the specified product variant.
     *
     * @param Request $request
     * @param ProductVariant $variant
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleVariantStatus(Request $request, ProductVariant $variant)
    {
        try {
            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $variant->update(['is_active' => $validated['is_active']]);

            return response()->json([
                'success' => true,
                'message' => 'Variant status updated successfully.',
                'is_active' => $variant->is_active,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update variant status. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the price of the specified product variant.
     *
     * @param Request $request
     * @param ProductVariant $variant
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVariantPrice(Request $request, ProductVariant $variant)
    {
        try {
            $validated = $request->validate([
                'price' => 'required|numeric|min:0',
            ]);

            $variant->update(['price' => $validated['price']]);

            return response()->json([
                'success' => true,
                'message' => 'Variant price updated successfully.',
                'price' => $variant->price,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update variant price. Please try again.',
            ], 500);
        }
    }

    /**
     * Update the stock of the specified product variant.
     *
     * @param Request $request
     * @param ProductVariant $variant
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVariantStock(Request $request, ProductVariant $variant)
    {
        try {
            $validated = $request->validate([
                'stock' => 'required|integer|min:0',
            ]);

            $variant->update(['stock' => $validated['stock']]);

            return response()->json([
                'success' => true,
                'message' => 'Variant stock updated successfully.',
                'stock' => $variant->stock,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update variant stock. Please try again.',
            ], 500);
        }
    }

    /**
     * Delete the specified product variant.
     *
     * @param ProductVariant $variant
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteVariant(ProductVariant $variant)
    {
        try {
            $variant->delete();

            return response()->json([
                'success' => true,
                'message' => 'Variant deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete variant: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * @param Product $product
     * @return RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function destroy(Product $product)
    {
        try {
            $this->productRepository->delete($product->id);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product deleted successfully.'
                ]);
            }

            return redirect()
                ->route('dashboard.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete product. Please try again.'
                ], 500);
            }

            return redirect()
                ->route('dashboard.products.index')
                ->with('error', 'Failed to delete product. Please try again.');
        }
    }

    /**
     * Store a new product image.
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeImage(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'color_id' => 'nullable|exists:colors,id',
                'is_primary' => 'boolean',
                'order' => 'integer|min:0',
                'alt' => 'nullable|string|max:255',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');

                // If this is set as primary, unset other primary images
                if ($validated['is_primary'] ?? false) {
                    ProductImage::where('product_id', $product->id)
                        ->update(['is_primary' => false]);
                }

                $image = ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'color_id' => $validated['color_id'] ?? null,
                    'is_primary' => $validated['is_primary'] ?? false,
                    'order' => $validated['order'] ?? 0,
                    'alt' => $validated['alt'] ?? null,
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Image uploaded successfully.',
                    'image' => [
                        'id' => $image->id,
                        'url' => asset('storage/' . $image->image),
                        'color_id' => $image->color_id,
                        'color_name' => $image->color ? $image->color->name : 'General',
                        'is_primary' => $image->is_primary,
                        'order' => $image->order,
                    ],
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No image file provided.',
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a product image.
     *
     * @param Request $request
     * @param ProductImage $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateImage(Request $request, ProductImage $image)
    {
        try {
            $validated = $request->validate([
                'color_id' => 'nullable|exists:colors,id',
                'is_primary' => 'boolean',
                'order' => 'integer|min:0',
                'alt' => 'nullable|string|max:255',
            ]);

            // If setting as primary, unset other primary images for this product
            if ($validated['is_primary'] ?? false) {
                ProductImage::where('product_id', $image->product_id)
                    ->where('id', '!=', $image->id)
                    ->update(['is_primary' => false]);
            }

            $image->update([
                'color_id' => $validated['color_id'] ?? $image->color_id,
                'is_primary' => $validated['is_primary'] ?? $image->is_primary,
                'order' => $validated['order'] ?? $image->order,
                'alt' => $validated['alt'] ?? $image->alt,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Image updated successfully.',
                'image' => [
                    'id' => $image->id,
                    'url' => asset('storage/' . $image->image),
                    'color_id' => $image->color_id,
                    'color_name' => $image->color ? $image->color->name : 'General',
                    'is_primary' => $image->is_primary,
                    'order' => $image->order,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update image: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a product image.
     *
     * @param ProductImage $image
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteImage(ProductImage $image)
    {
        try {
            $imagePath = $image->image;
            $productId = $image->product_id;

            // Delete the image file
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            // Delete the database record
            $image->delete();

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage(),
            ], 500);
        }
    }
}
