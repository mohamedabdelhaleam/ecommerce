<?php

namespace App\Repositories;

use Spatie\Permission\Models\Role;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * Get all roles
     *
     * @param array $filters
     * @return LengthAwarePaginator|Collection
     */
    public function all(array $filters = [])
    {
        $query = Role::where('guard_name', 'admin')->with(['permissions']);

        // Apply filters
        if (isset($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%");
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
     * Find a role by ID
     *
     * @param int $id
     * @return Role|null
     */
    public function find(int $id): ?Role
    {
        return Role::where('guard_name', 'admin')->find($id);
    }

    /**
     * Find a role by ID or fail
     *
     * @param int $id
     * @return Role
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail(int $id): Role
    {
        return Role::where('guard_name', 'admin')->findOrFail($id);
    }

    /**
     * Create a new role
     *
     * @param array $data
     * @return Role
     */
    public function create(array $data): Role
    {
        $data['guard_name'] = 'admin';
        $role = Role::create($data);

        // Assign permissions if provided
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role;
    }

    /**
     * Update a role
     *
     * @param int $id
     * @param array $data
     * @return Role
     */
    public function update(int $id, array $data): Role
    {
        $role = $this->findOrFail($id);

        // Don't allow changing guard_name
        unset($data['guard_name']);

        $role->update($data);

        // Sync permissions if provided
        if (isset($data['permissions']) && is_array($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }

        return $role->fresh();
    }

    /**
     * Delete a role
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $role = $this->findOrFail($id);
        return $role->delete();
    }

    /**
     * Get all roles for admin guard
     *
     * @return Collection
     */
    public function getAllForAdmin(): Collection
    {
        return Role::where('guard_name', 'admin')->orderBy('name', 'asc')->get();
    }
}
