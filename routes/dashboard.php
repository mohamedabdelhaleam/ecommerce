<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;

// Guest routes (not authenticated)
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('dashboard.login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('dashboard.logout');
    Route::get('/', [HomeController::class, 'index'])->name('dashboard.home');
    Route::get('/home', [HomeController::class, 'index'])->name('dashboard.home.index');

    // Products CRUD routes
    Route::resource('products', ProductController::class)->names([
        'index' => 'dashboard.products.index',
        'create' => 'dashboard.products.create',
        'store' => 'dashboard.products.store',
        'show' => 'dashboard.products.show',
        'edit' => 'dashboard.products.edit',
        'update' => 'dashboard.products.update',
        'destroy' => 'dashboard.products.destroy',
    ]);

    // Product status toggle route
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
        ->name('dashboard.products.toggle-status');

    // Categories CRUD routes
    Route::resource('categories', CategoryController::class)->names([
        'index' => 'dashboard.categories.index',
        'create' => 'dashboard.categories.create',
        'store' => 'dashboard.categories.store',
        'show' => 'dashboard.categories.show',
        'edit' => 'dashboard.categories.edit',
        'update' => 'dashboard.categories.update',
        'destroy' => 'dashboard.categories.destroy',
    ]);
});
