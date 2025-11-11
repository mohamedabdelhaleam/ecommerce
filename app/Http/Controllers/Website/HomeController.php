<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Product;

class HomeController extends Controller
{
    public function __invoke()
    {
        $categories = Category::active()->get();
        $products = Product::active()->latest()->take(4)->get();
        $reviews = Comment::approved()
            ->withRating()
            ->latest()
            ->take(3)
            ->get();
        return view('website.home.index', compact('categories', 'products', 'reviews'));
    }
}
