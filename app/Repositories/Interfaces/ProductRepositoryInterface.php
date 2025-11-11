<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ProductRepositoryInterface
{
    /**
     * Get all products (paginated)
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = []);

    /**
     * Find a product by ID
     *
     * @param int $id
     * @return Product|null
     */
    public function find(int $id): ?Product;

    /**
     * Find a product by ID or fail
     *
     * @param int $id
     * @return Product
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Product;

    /**
     * Create a new product
     *
     * @param array $data
     * @return Product
     */
    public function create(array $data): Product;

    /**
     * Update a product
     *
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function update(int $id, array $data): Product;

    /**
     * Delete a product
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get products by category
     *
     * @param int $categoryId
     * @return Collection
     */
    public function getByCategory(int $categoryId): Collection;

    /**
     * Get active products
     *
     * @return Collection
     */
    public function getActive(): Collection;

    /**
     * Build filters array from request
     *
     * @param Request $request
     * @return array
     */
    public function buildFiltersFromRequest(Request $request): array;

    /**
     * Toggle product status
     *
     * @param int $id
     * @param bool $isActive
     * @return Product
     */
    public function toggleStatus(int $id, bool $isActive): Product;

    /**
     * Get pagination HTML for products
     *
     * @param LengthAwarePaginator $products
     * @param string $view
     * @return string
     */
    public function getPaginationHtml(LengthAwarePaginator $products, string $view = 'pagination::bootstrap-5'): string;
}
