<?php

namespace App\Repositories;

use App\Models\Coupon;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CouponRepository implements CouponRepositoryInterface
{
    /**
     * Get all coupons
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Coupon::query();

        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('name_ar', 'like', "%{$search}%")
                    ->orWhere('name_en', 'like', "%{$search}%");
            });
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['type'])) {
            $query->where('type', $filters['type']);
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
     * Find a coupon by ID
     *
     * @param int $id
     * @return Coupon|null
     */
    public function find(int $id): ?Coupon
    {
        return Coupon::find($id);
    }

    /**
     * Find a coupon by ID or fail
     *
     * @param int $id
     * @return Coupon
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Coupon
    {
        return Coupon::findOrFail($id);
    }

    /**
     * Find a coupon by code
     *
     * @param string $code
     * @return Coupon|null
     */
    public function findByCode(string $code): ?Coupon
    {
        return Coupon::where('code', $code)->first();
    }

    /**
     * Create a new coupon
     *
     * @param array $data
     * @return Coupon
     */
    public function create(array $data): Coupon
    {
        // Ensure code is uppercase
        if (isset($data['code'])) {
            $data['code'] = strtoupper($data['code']);
        }

        return Coupon::create($data);
    }

    /**
     * Update a coupon
     *
     * @param int $id
     * @param array $data
     * @return Coupon
     */
    public function update(int $id, array $data): Coupon
    {
        $coupon = $this->findOrFail($id);

        // Ensure code is uppercase
        if (isset($data['code'])) {
            $data['code'] = strtoupper($data['code']);
        }

        $coupon->update($data);

        return $coupon->fresh();
    }

    /**
     * Delete a coupon
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $coupon = $this->findOrFail($id);
        return $coupon->delete();
    }

    /**
     * Toggle coupon status
     *
     * @param int $id
     * @return Coupon
     */
    public function toggleStatus(int $id): Coupon
    {
        $coupon = $this->findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        return $coupon->fresh();
    }

    /**
     * Get active coupons
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Coupon::active()->get();
    }
}
