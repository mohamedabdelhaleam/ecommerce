<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\products\StoreProductRequest;
use App\Http\Requests\Dashboard\products\UpdateProductRequest;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the products.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $products = $this->productRepository->all();
        return view('dashboard.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('dashboard.pages.products.create', compact('categories'));
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

        return redirect()
            ->route('dashboard.products.index')
            ->with('success', 'Product created successfully.');
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
        $categories = Category::all();
        return view('dashboard.pages.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     *
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return RedirectResponse
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product = $this->productRepository->findOrFail($product->id);

        $this->productRepository->update($product->id, $request->validated());

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
            $product = $this->productRepository->findOrFail($product->id);

            $validated = $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $this->productRepository->update($product->id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully.',
                'is_active' => $validated['is_active'],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status. Please try again.',
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
}
