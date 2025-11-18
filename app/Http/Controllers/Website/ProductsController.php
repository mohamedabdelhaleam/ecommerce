<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Comment;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Get selected categories from request (slugs)
        $selectedCategories = $request->get('categories', []);
        if (is_string($selectedCategories)) {
            $selectedCategories = explode(',', $selectedCategories);
        }
        $selectedCategories = array_filter(array_map('trim', $selectedCategories));

        // If AJAX request, return JSON with products HTML
        if ($request->ajax() || $request->wantsJson()) {
            $productsHtml = view('website.products.partials.products-grid', [
                'products' => $products,
                'productsData' => $productsData,
            ])->render();

            return response()->json([
                'success' => true,
                'html' => $productsHtml,
                'currentPage' => $products->currentPage(),
                'lastPage' => $products->lastPage(),
                'total' => $products->total(),
            ]);
        }

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
        // Find product with all relationships
        $product = $this->productRepository->findOrFail($id);

        // Check if product is active
        if (!$product->is_active) {
            abort(404);
        }

        // Load relationships
        $product->load([
            'category',
            'images' => function ($query) {
                $query->orderBy('is_primary', 'desc')->orderBy('order');
            },
            'activeVariants' => function ($query) {
                $query->with(['size', 'color'])->orderBy('price');
            },
            'approvedComments' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            }
        ]);

        // Calculate review statistics
        $approvedComments = $product->approvedComments;
        $reviewsWithRating = $approvedComments->whereNotNull('rating');

        $reviewStats = [
            'average' => $reviewsWithRating->avg('rating') ?? 0,
            'total' => $reviewsWithRating->count(),
            'distribution' => [
                5 => $reviewsWithRating->where('rating', 5)->count(),
                4 => $reviewsWithRating->where('rating', 4)->count(),
                3 => $reviewsWithRating->where('rating', 3)->count(),
                2 => $reviewsWithRating->where('rating', 2)->count(),
                1 => $reviewsWithRating->where('rating', 1)->count(),
            ]
        ];

        // Calculate percentage for each rating
        foreach ($reviewStats['distribution'] as $rating => $count) {
            $reviewStats['percentages'][$rating] = $reviewStats['total'] > 0
                ? round(($count / $reviewStats['total']) * 100, 0)
                : 0;
        }

        // Get related products (same category, excluding current product)
        $relatedProductsQuery = $this->productRepository->all([
            'category_id' => $product->category_id,
            'is_active' => true,
            'paginate' => false,
            'per_page' => 10,
        ]);

        $relatedProducts = $relatedProductsQuery->filter(function ($p) use ($product) {
            return $p->id != $product->id;
        })->take(4);

        // Transform related products
        $relatedProductsData = ProductResource::collection($relatedProducts)->resolve();

        // Get unique sizes and colors from variants
        $availableSizes = $product->activeVariants()
            ->with('size')
            ->get()
            ->pluck('size')
            ->filter()
            ->unique('id')
            ->values();

        $availableColors = $product->activeVariants()
            ->with('color')
            ->get()
            ->pluck('color')
            ->filter()
            ->unique('id')
            ->values();

        // Prepare variants data for JavaScript (size_id, color_id, price)
        $variantsData = $product->activeVariants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'size_id' => $variant->size_id,
                'color_id' => $variant->color_id,
                'price' => $variant->price,
                'stock' => $variant->stock,
            ];
        })->toArray();

        // Prepare color-specific images data for JavaScript
        $colorImagesData = [];
        foreach ($availableColors as $color) {
            $colorImages = $product->getImagesByColor($color->id);
            $colorImagesData[$color->id] = $colorImages->map(function ($image) {
                $imagePath = $image->getRawOriginal('image');
                return [
                    'url' => $imagePath ? asset('storage/' . $imagePath) : 'https://placehold.co/400',
                    'is_primary' => $image->is_primary,
                    'order' => $image->order,
                ];
            })->toArray();
        }

        // Also get general images (no color assigned)
        $generalImages = $product->getImagesByColor(null);
        $colorImagesData['general'] = $generalImages->map(function ($image) {
            $imagePath = $image->getRawOriginal('image');
            return [
                'url' => $imagePath ? asset('storage/' . $imagePath) : 'https://placehold.co/400',
                'is_primary' => $image->is_primary,
                'order' => $image->order,
            ];
        })->toArray();

        return view('website.products.details', [
            'product' => $product,
            'reviewStats' => $reviewStats,
            'reviews' => $approvedComments->take(10), // Show latest 10 reviews
            'relatedProducts' => $relatedProductsData,
            'availableSizes' => $availableSizes,
            'availableColors' => $availableColors,
            'variantsData' => $variantsData,
            'colorImagesData' => $colorImagesData,
        ]);
    }

    public function storeReview($id, \App\Http\Requests\StoreReviewRequest $request)
    {
        $product = $this->productRepository->findOrFail($id);

        // Check if product is active
        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        // Get authenticated user if available
        $userId = Auth::check() ? Auth::id() : null;

        // Create comment/review
        $comment = Comment::create([
            'product_id' => $product->id,
            'user_id' => $userId,
            'name' => $request->name,
            'email' => $request->email,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'is_approved' => false, // Reviews need approval before being displayed
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Your review has been submitted successfully. It will be reviewed before being published.',
            'comment' => $comment
        ]);
    }
}
