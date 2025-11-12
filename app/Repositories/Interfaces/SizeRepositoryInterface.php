<?php

namespace App\Repositories\Interfaces;

use App\Models\Size;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SizeRepositoryInterface
{
    /**
     * Get all sizes
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a size by ID
     *
     * @param int $id
     * @return Size|null
     */
    public function find(int $id): ?Size;

    /**
     * Find a size by ID or fail
     *
     * @param int $id
     * @return Size
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Size;

    /**
     * Create a new size
     *
     * @param array $data
     * @return Size
     */
    public function create(array $data): Size;

    /**
     * Update a size
     *
     * @param int $id
     * @param array $data
     * @return Size
     */
    public function update(int $id, array $data): Size;

    /**
     * Delete a size
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get active sizes
     *
     * @return Collection
     */
    public function getActive(): Collection;

    /**
     * Toggle the status of a size
     *
     * @param int $id
     * @param bool $isActive
     * @return Size
     */
    public function toggleStatus(int $id, bool $isActive): Size;
}
