<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Category::with('products');

        // Apply filters
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%")
                    ->orWhere('description_ar', 'like', "%{$search}%")
                    ->orWhere('description_en', 'like', "%{$search}%");
            });
        }

        // Order by
        $orderBy = $filters['order_by'] ?? 'created_at';
        $orderDirection = $filters['order_direction'] ?? 'desc';
        $query->orderBy($orderBy, $orderDirection);

        // Paginate or get all
        if (isset($filters['paginate']) && $filters['paginate']) {
            $perPage = $filters['per_page'] ?? 15;
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Find a category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function find(int $id): ?Category
    {
        return Category::with('products')->find($id);
    }

    /**
     * Find a category by ID or fail
     *
     * @param int $id
     * @return Category
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Category
    {
        return Category::with(['products.variants'])->findOrFail($id);
    }

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category
    {
        // Handle image upload
        if (isset($data['image']) && $data['image']->isValid()) {
            $data['image'] = $data['image']->store('categories', 'public');
        }

        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name_en'])) {
            $data['slug'] = Str::slug($data['name_en']);
        } elseif (empty($data['slug']) && !empty($data['name_ar'])) {
            $data['slug'] = Str::slug($data['name_ar']);
        }

        return Category::create($data);
    }

    /**
     * Update a category
     *
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function update(int $id, array $data): Category
    {
        $category = $this->findOrFail($id);

        // Handle image upload
        if (isset($data['image']) && $data['image']->isValid()) {
            // Delete old image if exists
            $oldImage = $category->getRawOriginal('image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $data['image'] = $data['image']->store('categories', 'public');
        }

        // Generate slug if not provided and name changed
        if (empty($data['slug'])) {
            if (isset($data['name_en']) && $data['name_en'] !== $category->name_en) {
                $data['slug'] = Str::slug($data['name_en']);
            } elseif (isset($data['name_ar']) && $data['name_ar'] !== $category->name_ar) {
                $data['slug'] = Str::slug($data['name_ar']);
            }
        }

        $category->update($data);

        return $category->fresh('products');
    }

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $category = $this->findOrFail($id);

        // Delete associated image
        $imagePath = $category->getRawOriginal('image');
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return $category->delete();
    }

    /**
     * Get active categories
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Category::active()
            ->with('products')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Toggle the status of a category
     *
     * @param int $id
     * @param bool $isActive
     * @return Category
     */
    public function toggleStatus(int $id, bool $isActive): Category
    {
        $category = $this->findOrFail($id);
        $category->update(['is_active' => $isActive]);
        return $category->fresh('products');
    }
}
