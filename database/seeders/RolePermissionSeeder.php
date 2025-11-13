<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // Dashboard
            'view dashboard',

            // Products
            'view products',
            'create products',
            'edit products',
            'delete products',
            'toggle products status',

            // Categories
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'toggle categories status',

            // Colors
            'view colors',
            'create colors',
            'edit colors',
            'delete colors',
            'toggle colors status',

            // Sizes
            'view sizes',
            'create sizes',
            'edit sizes',
            'delete sizes',
            'toggle sizes status',

            // Admins
            'view admins',
            'create admins',
            'edit admins',
            'delete admins',
            'toggle admins status',

            // Roles & Permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'assign roles',

            // Coupons
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',
            'toggle coupons status',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'admin'],
                ['name' => $permission, 'guard_name' => 'admin']
            );
        }

        // Create roles
        $superAdmin = Role::firstOrCreate(
            ['name' => 'Super Admin', 'guard_name' => 'admin'],
            ['name' => 'Super Admin', 'guard_name' => 'admin']
        );
        $admin = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'admin'],
            ['name' => 'Admin', 'guard_name' => 'admin']
        );
        $manager = Role::firstOrCreate(
            ['name' => 'Manager', 'guard_name' => 'admin'],
            ['name' => 'Manager', 'guard_name' => 'admin']
        );
        $editor = Role::firstOrCreate(
            ['name' => 'Editor', 'guard_name' => 'admin'],
            ['name' => 'Editor', 'guard_name' => 'admin']
        );

        // Assign all permissions to Super Admin
        $allPermissions = Permission::where('guard_name', 'admin')->get();
        $superAdmin->syncPermissions($allPermissions);

        // Assign permissions to Admin (all except roles management)
        $adminPermissions = [
            'view dashboard',
            'view products',
            'create products',
            'edit products',
            'delete products',
            'toggle products status',
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            'toggle categories status',
            'view colors',
            'create colors',
            'edit colors',
            'delete colors',
            'toggle colors status',
            'view sizes',
            'create sizes',
            'edit sizes',
            'delete sizes',
            'toggle sizes status',
            'view admins',
            'create admins',
            'edit admins',
            'delete admins',
            'toggle admins status',
            'view coupons',
            'create coupons',
            'edit coupons',
            'delete coupons',
            'toggle coupons status',
        ];
        $admin->syncPermissions($adminPermissions);

        // Assign permissions to Manager (view and edit, no delete)
        $managerPermissions = [
            'view dashboard',
            'view products',
            'edit products',
            'toggle products status',
            'view categories',
            'edit categories',
            'toggle categories status',
            'view colors',
            'edit colors',
            'toggle colors status',
            'view sizes',
            'edit sizes',
            'toggle sizes status',
            'view admins',
        ];
        $manager->syncPermissions($managerPermissions);

        // Assign permissions to Editor (view and create, limited edit)
        $editorPermissions = [
            'view dashboard',
            'view products',
            'create products',
            'edit products',
            'view categories',
            'create categories',
            'edit categories',
            'view colors',
            'create colors',
            'edit colors',
            'view sizes',
            'create sizes',
            'edit sizes',
        ];
        $editor->syncPermissions($editorPermissions);

        // Create a default super admin user if it doesn't exist
        $superAdminUser = Admin::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'phone' => '1234567890',
                'password' => Hash::make('password'),
                'is_active' => true,
            ]
        );

        if (!$superAdminUser->hasRole('Super Admin')) {
            $superAdminUser->assignRole('Super Admin');
        }
    }
}
