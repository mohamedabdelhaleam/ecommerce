<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register permissions as gates
        try {
            Permission::where('guard_name', 'admin')->get()->map(function ($permission) {
                Gate::define($permission->name, function ($admin) use ($permission) {
                    return $admin->hasPermissionTo($permission, 'admin');
                });
            });
        } catch (\Exception $e) {
            // Permissions table might not exist yet
        }
    }
}
