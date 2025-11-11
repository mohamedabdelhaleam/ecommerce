<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
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
    public function all()
    {
        return Product::with(['category'=>function($query){
            $query->select('id', 'name_ar');
        }])
            ->latest()
            ->paginate(10);
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
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('products', 'public');
        }

        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name_en'])) {
            $data['slug'] = Str::slug($data['name_en']);
        } elseif (empty($data['slug']) && !empty($data['name_ar'])) {
            $data['slug'] = Str::slug($data['name_ar']);
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
        if (isset($data['image']) && $data['image']->isValid()) {
            // Delete old image if exists
            $oldImage = $product->getRawOriginal('image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $data['image'] = $data['image']->store('products', 'public');
        }

        // Generate slug if not provided and name changed
        if (empty($data['slug'])) {
            if (isset($data['name_en']) && $data['name_en'] !== $product->name_en) {
                $data['slug'] = Str::slug($data['name_en']);
            } elseif (isset($data['name_ar']) && $data['name_ar'] !== $product->name_ar) {
                $data['slug'] = Str::slug($data['name_ar']);
            }
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
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
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
}
