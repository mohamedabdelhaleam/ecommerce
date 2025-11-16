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
