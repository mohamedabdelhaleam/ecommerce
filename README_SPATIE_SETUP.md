# Spatie Laravel Permission Setup Instructions

## Installation Steps

1. **Install the package:**

    ```bash
    composer require spatie/laravel-permission
    ```

2. **Publish the migration files:**

    ```bash
    php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
    ```

3. **Run the migrations:**

    ```bash
    php artisan migrate
    ```

4. **Run the seeder to create roles and permissions:**
    ```bash
    php artisan db:seed --class=RolePermissionSeeder
    ```

## Default Credentials

After running the seeder, you can login with:

-   **Email:** superadmin@example.com
-   **Password:** password

## Usage in Routes

You can protect routes using middleware:

```php
// Using permission middleware
Route::middleware(['auth:admin', 'permission:view products'])->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
});

// Using role middleware
Route::middleware(['auth:admin', 'role:Super Admin'])->group(function () {
    // Routes for Super Admin only
});

// Using role_or_permission middleware
Route::middleware(['auth:admin', 'role_or_permission:Super Admin|view products'])->group(function () {
    // Routes accessible by Super Admin role OR view products permission
});
```

## Usage in Controllers

```php
// Check permission
if (auth('admin')->user()->can('view products')) {
    // User has permission
}

// Check role
if (auth('admin')->user()->hasRole('Super Admin')) {
    // User has role
}
```

## Usage in Blade Views

```blade
@can('view products')
    <a href="{{ route('dashboard.products.index') }}">Products</a>
@endcan

@role('Super Admin')
    <a href="{{ route('dashboard.admins.index') }}">Admins</a>
@endrole
```

## Available Roles

-   **Super Admin** - Full access to everything
-   **Admin** - Access to all CRUD operations except roles management
-   **Manager** - View and edit access, no delete
-   **Editor** - View and create access, limited edit

## Available Permissions

-   `view dashboard`
-   `view products`, `create products`, `edit products`, `delete products`, `toggle products status`
-   `view categories`, `create categories`, `edit categories`, `delete categories`, `toggle categories status`
-   `view colors`, `create colors`, `edit colors`, `delete colors`, `toggle colors status`
-   `view sizes`, `create sizes`, `edit sizes`, `delete sizes`, `toggle sizes status`
-   `view admins`, `create admins`, `edit admins`, `delete admins`, `toggle admins status`
-   `view roles`, `create roles`, `edit roles`, `delete roles`, `assign roles`
