<?php

namespace App\Repositories\Interfaces;

use App\Models\Color;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ColorRepositoryInterface
{
    /**
     * Get all colors
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a color by ID
     *
     * @param int $id
     * @return Color|null
     */
    public function find(int $id): ?Color;

    /**
     * Find a color by ID or fail
     *
     * @param int $id
     * @return Color
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Color;

    /**
     * Create a new color
     *
     * @param array $data
     * @return Color
     */
    public function create(array $data): Color;

    /**
     * Update a color
     *
     * @param int $id
     * @param array $data
     * @return Color
     */
    public function update(int $id, array $data): Color;

    /**
     * Delete a color
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get active colors
     *
     * @return Collection
     */
    public function getActive(): Collection;

    /**
     * Toggle the status of a color
     *
     * @param int $id
     * @param bool $isActive
     * @return Color
     */
    public function toggleStatus(int $id, bool $isActive): Color;
}
