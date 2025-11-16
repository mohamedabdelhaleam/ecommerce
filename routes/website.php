<?php

use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\ProductsController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');

Route::get('/products', ProductsController::class)->name('products');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');
Route::post('/products/{id}/review', [ProductsController::class, 'storeReview'])->name('products.review.store');

// Cart routes - add to cart without authentication
Route::post('/cart/add', [\App\Http\Controllers\Website\CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [\App\Http\Controllers\Website\CartController::class, 'count'])->name('cart.count');

// Cart routes - require authentication for viewing and managing cart
Route::middleware('auth:web')->group(function () {
    Route::get('/cart', [\App\Http\Controllers\Website\CartController::class, 'index'])->name('cart.index');
    Route::put('/cart/update/{key}', [\App\Http\Controllers\Website\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{key}', [\App\Http\Controllers\Website\CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [\App\Http\Controllers\Website\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/checkout', [\App\Http\Controllers\Website\CartController::class, 'checkout'])->name('cart.checkout');
});

// Authentication routes
Route::middleware('guest:web')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Website\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Website\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\Website\AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Website\AuthController::class, 'register']);
});

// Authenticated user routes
Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Website\AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\Website\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Website\ProfileController::class, 'update'])->name('profile.update');
});
