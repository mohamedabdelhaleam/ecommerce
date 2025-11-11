<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CategoryRepositoryInterface
{
    /**
     * Get all categories
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a category by ID
     *
     * @param int $id
     * @return Category|null
     */
    public function find(int $id): ?Category;

    /**
     * Find a category by ID or fail
     *
     * @param int $id
     * @return Category
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Category;

    /**
     * Create a new category
     *
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * Update a category
     *
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function update(int $id, array $data): Category;

    /**
     * Delete a category
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get active categories
     *
     * @return Collection
     */
    public function getActive(): Collection;
}
