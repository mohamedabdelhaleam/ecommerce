<?php

use App\Http\Controllers\Website\AboutController;
use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', AboutController::class)->name('about');
