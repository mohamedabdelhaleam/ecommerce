<?php

namespace App\Repositories\Interfaces;

use App\Models\Coupon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CouponRepositoryInterface
{
    /**
     * Get all coupons
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a coupon by ID
     *
     * @param int $id
     * @return Coupon|null
     */
    public function find(int $id): ?Coupon;

    /**
     * Find a coupon by ID or fail
     *
     * @param int $id
     * @return Coupon
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Coupon;

    /**
     * Find a coupon by code
     *
     * @param string $code
     * @return Coupon|null
     */
    public function findByCode(string $code): ?Coupon;

    /**
     * Create a new coupon
     *
     * @param array $data
     * @return Coupon
     */
    public function create(array $data): Coupon;

    /**
     * Update a coupon
     *
     * @param int $id
     * @param array $data
     * @return Coupon
     */
    public function update(int $id, array $data): Coupon;

    /**
     * Delete a coupon
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Toggle coupon status
     *
     * @param int $id
     * @return Coupon
     */
    public function toggleStatus(int $id): Coupon;

    /**
     * Get active coupons
     *
     * @return Collection
     */
    public function getActive(): Collection;
}
