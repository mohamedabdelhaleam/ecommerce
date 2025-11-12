<?php

namespace App\Repositories\Interfaces;

use App\Models\Admin;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AdminRepositoryInterface
{
    /**
     * Get all admins
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find an admin by ID
     *
     * @param int $id
     * @return Admin|null
     */
    public function find(int $id): ?Admin;

    /**
     * Find an admin by ID or fail
     *
     * @param int $id
     * @return Admin
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Admin;

    /**
     * Create a new admin
     *
     * @param array $data
     * @return Admin
     */
    public function create(array $data): Admin;

    /**
     * Update an admin
     *
     * @param int $id
     * @param array $data
     * @return Admin
     */
    public function update(int $id, array $data): Admin;

    /**
     * Delete an admin
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get active admins
     *
     * @return Collection
     */
    public function getActive(): Collection;

    /**
     * Toggle the status of an admin
     *
     * @param int $id
     * @param bool $isActive
     * @return Admin
     */
    public function toggleStatus(int $id, bool $isActive): Admin;
}
