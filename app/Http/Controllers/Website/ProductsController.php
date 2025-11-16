<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function __invoke(Request $request)
    {
        // Get all active categories for filters
        $categories = $this->categoryRepository->getActive();

        // Build filters from request
        $filters = $this->productRepository->buildFiltersFromRequest($request);

        // Map sort option to order_by and order_direction
        $sortOption = $request->get('sort', 'newest');
        switch ($sortOption) {
            case 'popularity':
                $filters['order_by'] = 'popularity';
                $filters['order_direction'] = 'desc';
                break;
            case 'price_low':
                $filters['order_by'] = 'price';
                $filters['order_direction'] = 'asc';
                break;
            case 'price_high':
                $filters['order_by'] = 'price';
                $filters['order_direction'] = 'desc';
                break;
            case 'newest':
            default:
                $filters['order_by'] = 'created_at';
                $filters['order_direction'] = 'desc';
                break;
        }

        // Get products with filters
        $products = $this->productRepository->all($filters);

        // Append query parameters to pagination links
        $products->appends($request->query());

        // Transform products using ProductResource
        $productsData = ProductResource::collection($products->items())->resolve();

        // Get price range for filter
        $priceRange = $this->productRepository->getPriceRange();

        // Get selected categories from request
        $selectedCategories = $request->get('categories', []);
        if (is_string($selectedCategories)) {
            $selectedCategories = explode(',', $selectedCategories);
        }
        $selectedCategories = array_filter(array_map('intval', $selectedCategories));

        return view('website.products.index', [
            'products' => $products,
            'productsData' => $productsData, // Transformed product data
            'categories' => $categories,
            'priceRange' => $priceRange,
            'selectedCategories' => $selectedCategories,
            'currentSort' => $sortOption,
            'currentMinPrice' => $request->get('min_price', $priceRange['min']),
            'currentMaxPrice' => $request->get('max_price', $priceRange['max']),
        ]);
    }

    public function show($id)
    {
        return view('website.products.details');
    }
}
