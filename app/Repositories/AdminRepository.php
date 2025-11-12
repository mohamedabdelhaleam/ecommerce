<?php

namespace App\Repositories;

use App\Models\Admin;
use App\Repositories\Interfaces\AdminRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    /**
     * Get all admins
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Admin::query();

        // Apply filters
        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
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
     * Find an admin by ID
     *
     * @param int $id
     * @return Admin|null
     */
    public function find(int $id): ?Admin
    {
        return Admin::find($id);
    }

    /**
     * Find an admin by ID or fail
     *
     * @param int $id
     * @return Admin
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Admin
    {
        return Admin::findOrFail($id);
    }

    /**
     * Create a new admin
     *
     * @param array $data
     * @return Admin
     */
    public function create(array $data): Admin
    {
        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return Admin::create($data);
    }

    /**
     * Update an admin
     *
     * @param int $id
     * @param array $data
     * @return Admin
     */
    public function update(int $id, array $data): Admin
    {
        $admin = $this->findOrFail($id);

        // Hash password if provided
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Remove password from data if empty
            unset($data['password']);
        }

        $admin->update($data);

        return $admin->fresh();
    }

    /**
     * Delete an admin
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $admin = $this->findOrFail($id);
        return $admin->delete();
    }

    /**
     * Get active admins
     *
     * @return Collection
     */
    public function getActive(): Collection
    {
        return Admin::active()
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Toggle the status of an admin
     *
     * @param int $id
     * @param bool $isActive
     * @return Admin
     */
    public function toggleStatus(int $id, bool $isActive): Admin
    {
        $admin = $this->findOrFail($id);
        $admin->update(['is_active' => $isActive]);
        return $admin->fresh();
    }
}
