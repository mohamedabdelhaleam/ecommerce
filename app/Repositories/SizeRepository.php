<?php

namespace App\Repositories;

use App\Models\Size;
use App\Repositories\Interfaces\SizeRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class SizeRepository implements SizeRepositoryInterface
{
    /**
     * Get all sizes
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Size::with('variants');

        // Apply filters
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        // Order by
        $orderBy = $filters['order_by'] ?? 'order';
        $orderDirection = $filters['order_direction'] ?? 'asc';
        $query->orderBy($orderBy, $orderDirection);

        // Paginate or get all
        if (isset($filters['paginate']) && $filters['paginate']) {
            $perPage = $filters['per_page'] ?? 15;
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Find a size by ID
     *
     * @param int $id
     * @return Size|null
     */
    public function find(int $id): ?Size
    {
        return Size::with('variants')->find($id);
    }

    /**
     * Find a size by ID or fail
     *
     * @param int $id
     * @return Size
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Size
    {
        return Size::with('variants')->findOrFail($id);
    }

    /**
     * Create a new size
     *
     * @param array $data
     * @return Size
     */
    public function create(array $data): Size
    {
        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name_en'])) {
            $data['slug'] = Str::slug($data['name_en']);
        } elseif (empty($data['slug']) && !empty($data['name_ar'])) {
            $data['slug'] = Str::slug($data['name_ar']);
        }

        return Size::create($data);
    }

    /**
     * Update a size
     *
     * @param int $id
     * @param array $data
     * @return Size
     */
    public function update(int $id, array $data): Size
    {
        $size = $this->findOrFail($id);

        // Generate slug if not provided and name changed
        if (empty($data['slug'])) {
            if (isset($data['name_en']) && $data['name_en'] !== $size->name_en) {
                $data['slug'] = Str::slug($data['name_en']);
            } elseif (isset($data['name_ar']) && $data['name_ar'] !== $size->name_ar) {
                $data['slug'] = Str::slug($data['name_ar']);
            }
        }

        $size->update($data);

        return $size->fresh('variants');
    }

    /**
     * Delete a size
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $size = $this->findOrFail($id);
        return $size->delete();
    }

    /**
     * Get active sizes
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Size::active()
            ->with('variants')
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Toggle the status of a size
     *
     * @param int $id
     * @param bool $isActive
     * @return Size
     */
    public function toggleStatus(int $id, bool $isActive): Size
    {
        $size = $this->findOrFail($id);
        $size->update(['is_active' => $isActive]);
        return $size->fresh('variants');
    }
}
