<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\ColorController;
use App\Http\Controllers\Dashboard\SizeController;
use App\Http\Controllers\Dashboard\AdminController;

// Guest routes (not authenticated)
Route::middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Language switching route (available to all)
Route::get('/language/{locale}', [\App\Http\Controllers\Dashboard\LanguageController::class, 'switch'])
    ->name('language.switch')
    ->where('locale', 'en|ar');

// Authenticated routes
Route::middleware('auth:admin')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Products CRUD routes
    Route::resource('products', ProductController::class);

    // Product status toggle route
    Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])
        ->name('products.toggle-status');

    // Product variant status toggle route
    Route::patch('products/variants/{variant}/toggle-status', [ProductController::class, 'toggleVariantStatus'])
        ->name('products.variants.toggle-status');

    // Product variant price update route
    Route::patch('products/variants/{variant}/update-price', [ProductController::class, 'updateVariantPrice'])
        ->name('products.variants.update-price');

    // Product variant stock update route
    Route::patch('products/variants/{variant}/update-stock', [ProductController::class, 'updateVariantStock'])
        ->name('products.variants.update-stock');

    // Categories CRUD routes
    Route::resource('categories', CategoryController::class);

    // Category status toggle route
    Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])
        ->name('categories.toggle-status');

    // Colors CRUD routes
    Route::resource('colors', ColorController::class);

    // Color status toggle route
    Route::patch('colors/{color}/toggle-status', [ColorController::class, 'toggleStatus'])
        ->name('colors.toggle-status');

    // Sizes CRUD routes
    Route::resource('sizes', SizeController::class);

    // Size status toggle route
    Route::patch('sizes/{size}/toggle-status', [SizeController::class, 'toggleStatus'])
        ->name('sizes.toggle-status');

    // Admins CRUD routes
    Route::resource('admins', AdminController::class);

    // Admin status toggle route
    Route::patch('admins/{admin}/toggle-status', [AdminController::class, 'toggleStatus'])
        ->name('admins.toggle-status');
});
