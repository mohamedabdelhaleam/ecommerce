<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * Get all products
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Product::with([
            'category' => function ($query) {
                $query->select('id', 'name_ar', 'name_en');
            },
            'variants' => function ($query) {
                $query->select('id', 'product_id', 'price', 'stock', 'is_active')
                    ->where('is_active', true);
            },
            'images' => function ($query) {
                $query->select('id', 'product_id', 'image', 'is_primary', 'order')
                    ->orderBy('is_primary', 'desc')
                    ->orderBy('order');
            }
        ]);

        // Search by name (Arabic or English)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        // Filter by category (slug or name)
        if (!empty($filters['categories'])) {
            $categories = is_array($filters['categories']) ? $filters['categories'] : [$filters['categories']];
            $query->whereHas('category', function ($q) use ($categories) {
                $q->where(function ($subQuery) use ($categories) {
                    $subQuery->whereIn('slug', $categories)
                        ->orWhereIn('name_en', $categories)
                        ->orWhereIn('name_ar', $categories);
                });
            });
        } elseif (!empty($filters['category_id'])) {
            // Fallback to ID for backward compatibility
            if (is_array($filters['category_id'])) {
                $query->whereIn('category_id', $filters['category_id']);
            } else {
                $query->where('category_id', $filters['category_id']);
            }
        }

        // Filter by price range
        if (!empty($filters['min_price']) || !empty($filters['max_price'])) {
            $query->whereHas('variants', function ($q) use ($filters) {
                if (!empty($filters['min_price'])) {
                    $q->where('price', '>=', $filters['min_price']);
                }
                if (!empty($filters['max_price'])) {
                    $q->where('price', '<=', $filters['max_price']);
                }
            });
        }

        // Filter by status
        if (isset($filters['is_active']) && $filters['is_active'] !== '') {
            $query->where('is_active', $filters['is_active']);
        } else {
            // Default to active products for website
            $query->where('is_active', true);
        }

        // Filter by date range
        if (!empty($filters['from_date'])) {
            $query->whereDate('created_at', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
            $query->whereDate('created_at', '<=', $filters['to_date']);
        }

        // Order by
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDirection = $filters['order_direction'] ?? 'desc';

        // Handle special sorting cases
        if ($orderBy === 'price') {
            // Sort by minimum variant price
            $query->withMin('variants', 'price')
                ->orderBy('variants_min_price', $orderDirection);
        } elseif ($orderBy === 'popularity') {
            // Sort by number of comments or created_at as fallback
            $query->withCount('comments')
                ->orderBy('comments_count', 'desc')
                ->orderBy('created_at', 'desc');
        } else {
            $query->orderBy($orderBy, $orderDirection);
        }

        // Pagination
        $perPage = $filters['per_page'] ?? 10;
        $paginate = $filters['paginate'] ?? true;

        if ($paginate) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Find a product by ID
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product
    {
        return Product::with(['category', 'images', 'variants'])->find($id);
    }

    /**
     * Find a product by ID or fail
     *
     * @param int $id
     * @return Product
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Product
    {
        return Product::with(['category', 'images', 'variants'])->findOrFail($id);
    }

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product
    {
        // Handle image upload
        if (isset($data['image'])) {
            $imagePath = $this->handleImageUpload($data['image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            } else {
                unset($data['image']);
            }
        }

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $slug = $this->generateSlug($data['name_en'] ?? null, $data['name_ar'] ?? null);
            $data['slug'] = $this->ensureUniqueSlug($slug);
        } else {
            // Ensure slug is unique
            $data['slug'] = $this->ensureUniqueSlug($data['slug']);
        }

        return Product::create($data);
    }

    /**
     * Update a product
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function update(int $id, array $data): Product
    {
        $product = $this->findOrFail($id);

        // Handle image upload
        if (isset($data['image'])) {
            // Delete old image if exists
            $oldImage = $product->getRawOriginal('image');
            if ($oldImage) {
                $this->deleteImage($oldImage);
            }

            $imagePath = $this->handleImageUpload($data['image']);
            if ($imagePath) {
                $data['image'] = $imagePath;
            } else {
                unset($data['image']);
            }
        }

        // Generate slug if not provided and name changed
        if (empty($data['slug'])) {
            $nameChanged = false;
            $newSlug = null;

            if (isset($data['name_en']) && $data['name_en'] !== $product->name_en) {
                $nameChanged = true;
                $newSlug = $this->generateSlug($data['name_en'], null);
            } elseif (isset($data['name_ar']) && $data['name_ar'] !== $product->name_ar) {
                $nameChanged = true;
                $newSlug = $this->generateSlug(null, $data['name_ar']);
            }

            if ($nameChanged && $newSlug) {
                $data['slug'] = $this->ensureUniqueSlug($newSlug, $id);
            }
        } else {
            // Ensure slug is unique (excluding current product)
            $data['slug'] = $this->ensureUniqueSlug($data['slug'], $id);
        }

        $product->update($data);

        return $product->fresh(['category', 'images', 'variants']);
    }

    /**
     * Delete a product
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $product = $this->findOrFail($id);

        // Delete associated image
        $imagePath = $product->getRawOriginal('image');
        if ($imagePath) {
            $this->deleteImage($imagePath);
        }

        return $product->delete();
    }

    /**
     * Get products by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection
    {
        return Product::where('category_id', $categoryId)
            ->with(['category', 'images', 'variants'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get active products
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Product::active()
            ->with(['category', 'images', 'variants'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Get min and max prices from active product variants
     *
     * @return array
     */
    public function getPriceRange(): array
    {
        $minPrice = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->where('products.is_active', true)
            ->where('product_variants.is_active', true)
            ->whereNotNull('product_variants.price')
            ->min('product_variants.price');

        $maxPrice = DB::table('product_variants')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->where('products.is_active', true)
            ->where('product_variants.is_active', true)
            ->whereNotNull('product_variants.price')
            ->max('product_variants.price');

        return [
            'min' => $minPrice ? (float) $minPrice : 0,
            'max' => $maxPrice ? (float) $maxPrice : 1000,
        ];
    }

    /**
     * Build filters array from request
     *
     * @param Request $request
     * @return array
     */
    public function buildFiltersFromRequest(Request $request): array
    {
        $categories = $request->get('categories', []);
        if (is_string($categories)) {
            $categories = explode(',', $categories);
        }
        $categories = array_filter(array_map('trim', $categories));

        return [
            'search' => $request->get('search'),
            'categories' => !empty($categories) ? $categories : null,
            'category_id' => $request->get('category_id'), // Keep for backward compatibility
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'is_active' => $request->get('is_active'),
            'from_date' => $request->get('from_date'),
            'to_date' => $request->get('to_date'),
            'paginate' => true,
            'per_page' => $request->get('per_page', 12),
            'order_by' => $request->get('order_by', 'created_at'),
            'order_direction' => $request->get('order_direction', 'desc'),
        ];
    }

    /**
     * Toggle product status
     *
     * @param int $id
     * @param bool $isActive
     * @return Product
     */
    public function toggleStatus(int $id, bool $isActive): Product
    {
        $product = $this->findOrFail($id);
        $product->update(['is_active' => $isActive]);
        return $product->fresh(['category', 'images', 'variants']);
    }

    /**
     * Get pagination HTML for products
     *
     * @param LengthAwarePaginator $products
     * @param string $view
     * @return string
     */
    public function getPaginationHtml(LengthAwarePaginator $products, string $view = 'pagination::bootstrap-5'): string
    {
        if (method_exists($products, 'links')) {
            try {
                $paginationView = call_user_func([$products, 'links'], $view);
                return $paginationView->render();
            } catch (\Exception $e) {
                return '';
            }
        }
        return '';
    }

    /**
     * Ensure unique slug
     *
     * @param string $slug
     * @param int|null $excludeId
     * @return string
     */
    public function ensureUniqueSlug(string $slug, ?int $excludeId = null): string
    {
        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)
            ->when($excludeId, function ($query) use ($excludeId) {
                return $query->where('id', '!=', $excludeId);
            })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate slug from name
     *
     * @param string|null $nameEn
     * @param string|null $nameAr
     * @return string
     */
    public function generateSlug(?string $nameEn = null, ?string $nameAr = null): string
    {
        if (!empty($nameEn)) {
            return Str::slug($nameEn);
        }

        if (!empty($nameAr)) {
            return Str::slug($nameAr);
        }

        return Str::random(10);
    }

    /**
     * Handle image upload
     *
     * @param \Illuminate\Http\UploadedFile|null $image
     * @param string $disk
     * @return string|null
     */
    public function handleImageUpload(?\Illuminate\Http\UploadedFile $image, string $disk = 'public'): ?string
    {
        if ($image && $image->isValid()) {
            return $image->store('products', $disk);
        }

        return null;
    }

    /**
     * Delete product image
     *
     * @param string $imagePath
     * @param string $disk
     * @return bool
     */
    public function deleteImage(string $imagePath, string $disk = 'public'): bool
    {
        if ($imagePath && Storage::disk($disk)->exists($imagePath)) {
            return Storage::disk($disk)->delete($imagePath);
        }

        return false;
    }
}
