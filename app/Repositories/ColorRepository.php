<?php

namespace App\Repositories;

use App\Models\Color;
use App\Repositories\Interfaces\ColorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ColorRepository implements ColorRepositoryInterface
{
    /**
     * Get all colors
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Color::with('variants');

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
     * Find a color by ID
     *
     * @param int $id
     * @return Color|null
     */
    public function find(int $id): ?Color
    {
        return Color::with('variants')->find($id);
    }

    /**
     * Find a color by ID or fail
     *
     * @param int $id
     * @return Color
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Color
    {
        return Color::with('variants')->findOrFail($id);
    }

    /**
     * Create a new color
     *
     * @param array $data
     * @return Color
     */
    public function create(array $data): Color
    {
        // Generate slug if not provided
        if (empty($data['slug']) && !empty($data['name_en'])) {
            $data['slug'] = Str::slug($data['name_en']);
        } elseif (empty($data['slug']) && !empty($data['name_ar'])) {
            $data['slug'] = Str::slug($data['name_ar']);
        }

        return Color::create($data);
    }

    /**
     * Update a color
     *
     * @param int $id
     * @param array $data
     * @return Color
     */
    public function update(int $id, array $data): Color
    {
        $color = $this->findOrFail($id);

        // Generate slug if not provided and name changed
        if (empty($data['slug'])) {
            if (isset($data['name_en']) && $data['name_en'] !== $color->name_en) {
                $data['slug'] = Str::slug($data['name_en']);
            } elseif (isset($data['name_ar']) && $data['name_ar'] !== $color->name_ar) {
                $data['slug'] = Str::slug($data['name_ar']);
            }
        }

        $color->update($data);

        return $color->fresh('variants');
    }

    /**
     * Delete a color
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $color = $this->findOrFail($id);
        return $color->delete();
    }

    /**
     * Get active colors
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Color::active()
            ->with('variants')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Toggle the status of a color
     *
     * @param int $id
     * @param bool $isActive
     * @return Color
     */
    public function toggleStatus(int $id, bool $isActive): Color
    {
        $color = $this->findOrFail($id);
        $color->update(['is_active' => $isActive]);
        return $color->fresh('variants');
    }
}
