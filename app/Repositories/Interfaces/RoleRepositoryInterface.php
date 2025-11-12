<?php

namespace App\Repositories\Interfaces;

use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepositoryInterface
{
    /**
     * Get all roles
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a role by ID
     *
     * @param int $id
     * @return Role|null
     */
    public function find(int $id): ?Role;

    /**
     * Find a role by ID or fail
     *
     * @param int $id
     * @return Role
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Role;

    /**
     * Create a new role
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role;

    /**
     * Update a role
     *
     * @param int $id
     * @param array $data
     * @return Role
     */
    public function update(int $id, array $data): Role;

    /**
     * Delete a role
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get all roles for admin guard
     *
     * @return Collection
     */
    public function getAllForAdmin(): Collection;
}
