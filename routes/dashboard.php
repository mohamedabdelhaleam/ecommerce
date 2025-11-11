<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\HomeController;

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
});
