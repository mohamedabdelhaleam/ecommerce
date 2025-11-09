<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __invoke()
    {
        return view('website.products.index');
    }

    public function show($id)
    {
        return view('website.products.details');
    }
}
