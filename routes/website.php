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

// Cart routes
Route::get('/cart', [\App\Http\Controllers\Website\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [\App\Http\Controllers\Website\CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{key}', [\App\Http\Controllers\Website\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{key}', [\App\Http\Controllers\Website\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [\App\Http\Controllers\Website\CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/count', [\App\Http\Controllers\Website\CartController::class, 'count'])->name('cart.count');
