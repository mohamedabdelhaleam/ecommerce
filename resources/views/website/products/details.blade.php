@extends('website.layout.app')

@section('title', $product->name . ' - Products')
@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-5">
        <div class="layout-content-container mx-auto flex max-w-7xl flex-col flex-1">
            <!-- Breadcrumbs Component -->
            <div class="flex flex-wrap gap-2 p-4">
                <a class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal"
                    href="{{ route('home') }}">Home</a>
                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">/</span>
                <a class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal"
                    href="{{ route('products') }}">Products</a>
                @if ($product->category)
                    <span class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">/</span>
                    <a class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal"
                        href="{{ route('products', ['categories' => $product->category->slug ?? $product->category->name]) }}">{{ $product->category->name }}</a>
                @endif
                <span class="text-gray-500 dark:text-gray-400 text-sm font-medium leading-normal">/</span>
                <span
                    class="text-text-light dark:text-text-dark text-sm font-medium leading-normal">{{ $product->name }}</span>
            </div>
            <!-- Main Product Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-16 mt-6">
                <!-- Left Column: Image Gallery -->
                <div class="flex flex-col gap-4">
                    @php
                        $primaryImage = $product->primaryImage ?? $product->images->first();
                        if ($primaryImage) {
                            $mainImagePath = $primaryImage->getRawOriginal('image');
                            $mainImage = $mainImagePath
                                ? asset('storage/' . $mainImagePath)
                                : 'https://placehold.co/400';
                        } else {
                            $mainImage = $product->image;
                        }
                        $allImages = $product->images->count() > 0 ? $product->images : collect();
                        if ($allImages->isEmpty() && $product->getRawOriginal('image')) {
                            $allImages = collect([
                                (object) ['image' => $product->getRawOriginal('image'), 'is_primary' => true],
                            ]);
                        }
                    @endphp
                    <!-- Large Image -->
                    <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl shadow-lg"
                        id="main-product-image" data-alt="{{ $product->name }}"
                        style='background-image: url("{{ $mainImage }}");'>
                    </div>
                    <!-- Thumbnail Grid -->
                    @if ($allImages->count() > 1)
                        <div class="grid grid-cols-4 gap-4">
                            @foreach ($allImages->take(4) as $index => $image)
                                @php
                                    if ($image instanceof \App\Models\ProductImage) {
                                        $imagePath = $image->getRawOriginal('image');
                                    } elseif (is_object($image) && isset($image->image)) {
                                        $imagePath = $image->image;
                                    } else {
                                        $imagePath = $product->getRawOriginal('image');
                                    }
                                    $imageUrl = $imagePath
                                        ? asset('storage/' . $imagePath)
                                        : 'https://placehold.co/400';
                                    $isPrimary =
                                        ($index === 0 && !$product->primaryImage) ||
                                        (isset($image->is_primary) && $image->is_primary);
                                @endphp
                                <div class="thumbnail-image w-full bg-center bg-no-repeat aspect-square bg-cover rounded-lg cursor-pointer transition-all {{ $isPrimary ? 'border-2 border-primary' : 'border border-gray-300 dark:border-gray-700' }}"
                                    data-alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                    data-image="{{ $imageUrl }}"
                                    style='background-image: url("{{ $imageUrl }}");'>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <!-- Right Column: Product Info -->
                <div class="flex flex-col gap-6 py-4">
                    <!-- Product Heading -->
                    <div class="flex flex-col gap-2">
                        @if ($product->category)
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $product->category->name }}
                            </p>
                        @endif
                        <h1
                            class="text-text-light dark:text-text-dark text-4xl font-black leading-tight tracking-[-0.033em]">
                            {{ $product->name }}
                        </h1>
                        @auth('web')
                            <div id="product-rating-display" class="{{ $reviewStats['total'] > 0 ? '' : 'hidden' }}">
                                <div class="flex items-center gap-2 mt-2">
                                    <div id="product-rating-stars" class="flex text-primary">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($reviewStats['average']))
                                                <span class="material-symbols-outlined">star</span>
                                            @elseif($i - 0.5 <= $reviewStats['average'])
                                                <span class="material-symbols-outlined">star_half</span>
                                            @else
                                                <span class="material-symbols-outlined">star_outline</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <p id="product-rating-text" class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ number_format($reviewStats['average'], 1) }} ({{ $reviewStats['total'] }}
                                        {{ $reviewStats['total'] == 1 ? 'Review' : 'Reviews' }})
                                    </p>
                                </div>
                            </div>
                        @endauth
                    </div>
                    <!-- Price -->
                    <p class="text-4xl font-bold text-text-light dark:text-text-dark" id="product-price">
                        @if ($product->min_price && $product->max_price)
                            @if ($product->min_price == $product->max_price)
                                ${{ number_format($product->min_price, 2) }}
                            @else
                                ${{ number_format($product->min_price, 2) }} -
                                ${{ number_format($product->max_price, 2) }}
                            @endif
                        @else
                            N/A
                        @endif
                    </p>
                    <!-- Options -->
                    <div class="flex flex-col gap-4">
                        @if ($availableSizes->count() > 0)
                            <div>
                                <label class="text-sm font-bold text-text-light dark:text-text-dark mb-2 block">Size</label>
                                <div class="flex gap-3 flex-wrap">
                                    @foreach ($availableSizes as $index => $size)
                                        <button
                                            class="size-option px-4 py-2 rounded-lg border {{ $index === 0 ? 'border-2 border-primary bg-primary/20 font-bold' : 'border-border-light dark:border-border-dark' }} bg-white dark:bg-background-dark text-sm hover:border-primary transition-colors"
                                            data-size-id="{{ $size->id }}">
                                            {{ $size->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if ($availableColors->count() > 0)
                            <div>
                                <label
                                    class="text-sm font-bold text-text-light dark:text-text-dark mb-2 block">Color</label>
                                <div class="flex gap-3 flex-wrap">
                                    @foreach ($availableColors as $index => $color)
                                        <button
                                            class="color-option px-4 py-2 rounded-lg border {{ $index === 0 ? 'border-2 border-primary bg-primary/20 font-bold' : 'border-border-light dark:border-border-dark' }} bg-white dark:bg-background-dark text-sm hover:border-primary transition-colors"
                                            data-color-id="{{ $color->id }}">
                                            {{ $color->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <div class="flex items-center gap-4">
                            <label class="text-sm font-bold text-text-light dark:text-text-dark">Quantity</label>
                            <div
                                class="flex items-center border border-border-light dark:border-border-dark rounded-lg overflow-hidden">
                                <button
                                    class="quantity-decrease px-3 py-2 text-lg text-gray-500 dark:text-gray-400 hover:text-primary transition-colors flex-shrink-0">-</button>
                                <input id="quantity-input"
                                    class="min-w-[3rem] w-16 max-w-[5rem] text-center border-0 bg-transparent focus:ring-0 text-text-light dark:text-text-dark py-2"
                                    type="number" value="1" min="1" />
                                <button
                                    class="quantity-increase px-3 py-2 text-lg text-gray-500 dark:text-gray-400 hover:text-primary transition-colors flex-shrink-0">+</button>
                            </div>
                        </div>
                    </div>
                    <!-- Action Buttons -->
                    <div class="flex items-center gap-4 mt-4">
                        <button type="button" id="add-to-cart-btn"
                            class="flex-1 text-white bg-primary hover:opacity-90 transition-opacity flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 gap-2 text-base font-bold leading-normal tracking-[0.015em] px-6">
                            Add to Cart
                        </button>
                        <button
                            class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-12 bg-gray-200 dark:bg-white/10 text-text-light dark:text-text-dark gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-4">
                            <span
                                class="material-symbols-outlined text-text-light dark:text-text-dark">favorite_border</span>
                        </button>
                    </div>
                    <!-- Safety Badges -->
                    <div class="flex items-center gap-4 border-t border-border-light dark:border-border-dark pt-6 mt-2">
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">health_and_safety</span>
                            <span>BPA-Free</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">spa</span>
                            <span>Non-Toxic Dyes</span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                            <span class="material-symbols-outlined text-green-500">eco</span>
                            <span>Organic Cotton</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Details Accordion Section -->
            <div class="mt-16">
                @if ($product->description_en || $product->description_ar)
                    <details class="border-b border-border-light dark:border-border-dark" open>
                        <summary class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer list-none">
                            <span>Description</span>
                            <span class="material-symbols-outlined transition-transform">expand_more</span>
                        </summary>
                        <div class="pb-6 text-gray-600 dark:text-gray-300 space-y-3">
                            <p>{{ app()->getLocale() == 'ar' ? $product->description_ar ?? $product->description_en : $product->description_en ?? $product->description_ar }}
                            </p>
                        </div>
                    </details>
                @endif
                <details class="border-b border-border-light dark:border-border-dark">
                    <summary
                        class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer list-none text-gray-500 dark:text-gray-400">
                        <span>Specifications</span>
                        <span class="material-symbols-outlined transition-transform">expand_more</span>
                    </summary>
                    <div class="pb-6 text-gray-600 dark:text-gray-300">
                        <div class="grid grid-cols-2 gap-4">
                            @if ($product->category)
                                <div>
                                    <span class="font-semibold">Category:</span> {{ $product->category->name }}
                                </div>
                            @endif
                            @if ($product->sku)
                                <div>
                                    <span class="font-semibold">SKU:</span> {{ $product->sku }}
                                </div>
                            @endif
                        </div>
                    </div>
                </details>
                <details class="border-b border-border-light dark:border-border-dark">
                    <summary
                        class="py-4 text-lg font-bold flex justify-between items-center cursor-pointer list-none text-gray-500 dark:text-gray-400">
                        <span>Shipping &amp; Returns</span>
                        <span class="material-symbols-outlined transition-transform">expand_more</span>
                    </summary>
                    <div class="pb-6 text-gray-600 dark:text-gray-300">
                        <p>Free shipping on orders over $50. Returns accepted within 30 days of purchase.</p>
                    </div>
                </details>
            </div>
            <!-- Customer Reviews Section -->
            @auth('web')
                <div class="mt-16">

                    <h2 class="text-3xl font-bold mb-6">Customer Reviews</h2>



                    <div id="review-stats-container" class="{{ $reviewStats['total'] > 0 ? '' : 'hidden' }}">
                        <div class="bg-white dark:bg-background-dark/50 rounded-xl p-8 shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <div
                                    class="flex flex-col items-center justify-center gap-2 border-r border-border-light dark:border-border-dark pr-8">
                                    <p id="review-average" class="text-5xl font-black text-primary">
                                        {{ number_format($reviewStats['average'], 1) }}
                                    </p>
                                    <div id="review-stars" class="flex text-primary">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= floor($reviewStats['average']))
                                                <span class="material-symbols-outlined">star</span>
                                            @elseif($i - 0.5 <= $reviewStats['average'])
                                                <span class="material-symbols-outlined">star_half</span>
                                            @else
                                                <span class="material-symbols-outlined">star_outline</span>
                                            @endif
                                        @endfor
                                    </div>
                                    <p id="review-total-text" class="text-sm text-gray-500 dark:text-gray-400">Based on
                                        {{ $reviewStats['total'] }}
                                        {{ $reviewStats['total'] == 1 ? 'review' : 'reviews' }}</p>
                                </div>
                                <div id="review-distribution" class="col-span-2 flex flex-col gap-2 text-sm">
                                    <!-- Rating bars -->
                                    @for ($rating = 5; $rating >= 1; $rating--)
                                        @php
                                            $count = $reviewStats['distribution'][$rating] ?? 0;
                                            $percentage = $reviewStats['percentages'][$rating] ?? 0;
                                        @endphp
                                        <div class="flex items-center gap-2" data-rating="{{ $rating }}">
                                            <span class="w-12">{{ $rating }} star</span>
                                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                                <div class="bg-primary h-2.5 rounded-full"
                                                    style="width: {{ $percentage }}%">
                                                </div>
                                            </div>
                                            <span class="rating-count">{{ $count }}</span>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Individual Reviews -->
                    <div id="reviews-list" class="mt-8 space-y-6 {{ $reviews->count() > 0 ? '' : 'hidden' }}">
                        @foreach ($reviews as $review)
                            <div class="review-item flex gap-4 border-b border-border-light dark:border-border-dark pb-6">
                                <div
                                    class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
                                    {{ strtoupper(substr($review->name ?? ($review->user->name ?? 'U'), 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <p class="font-bold">
                                            {{ $review->name ?? ($review->user->name ?? 'Anonymous') }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $review->created_at->diffForHumans() }}</p>
                                    </div>
                                    @if ($review->rating)
                                        <div class="flex text-primary my-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $review->rating)
                                                    <span class="material-symbols-outlined text-base">star</span>
                                                @else
                                                    <span class="material-symbols-outlined text-base">star_outline</span>
                                                @endif
                                            @endfor
                                        </div>
                                    @endif
                                    <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endauth
            <!-- Write a Review Form -->
            @auth('web')
                <div class="dark:bg-background-dark/50 shadow-lg rounded-xl mt-4 p-8 mb-8">
                    <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                    <form id="review-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Rating -->
                        <div>
                            <label class="block text-sm font-medium text-text-light dark:text-text-dark mb-2">Rating
                                *</label>
                            <div class="flex gap-2" id="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="rating-star text-3xl text-gray-300 dark:text-gray-600 hover:text-primary transition-colors"
                                        data-rating="{{ $i }}">
                                        <span class="material-symbols-outlined">star_outline</span>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" id="review-rating" name="rating" required>
                        </div>

                        <!-- Comment -->
                        <div>
                            <label for="review-comment"
                                class="block text-sm font-medium text-text-light dark:text-text-dark mb-2">Your Review
                                *</label>
                            <textarea id="review-comment" name="comment" rows="5" required maxlength="150"
                                class="w-full px-4 py-2 border border-border-light dark:border-border-dark rounded-lg bg-white dark:bg-background-dark text-text-light dark:text-text-dark focus:ring-2 focus:ring-primary focus:border-primary resize-none"
                                placeholder="Share your thoughts about this product..."></textarea>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">
                                <span id="review-char-count">0</span>/150 characters
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" id="submit-review-btn"
                                class="px-6 py-2 bg-primary text-white rounded-lg font-semibold hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="dark:bg-background-dark/50 shadow-lg rounded-xl mt-4 p-8 mb-8 text-center">
                    <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">Please <a href="{{ route('login') }}"
                            class="text-primary hover:underline">login</a> to write a review.</p>
                </div>
            @endauth
            <!-- You Might Also Like Section -->
            @if (count($relatedProducts) > 0)
                <div class="mt-24">
                    <h2 class="text-3xl font-bold mb-6 text-center">You Might Also Like</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            <x-website.cards.product-card :product="$relatedProduct" />
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    @push('scripts')
        <script>
            // Pass data to external JavaScript file
            window.productVariants = @json($variantsData);
            window.productMinPrice = {{ $product->min_price ?? 0 }};
            window.productMaxPrice = {{ $product->max_price ?? 0 }};
            window.reviewStoreUrl = '{{ route('products.review.store', $product->id) }}';
            window.addToCartUrl = '{{ route('cart.add') }}';
            window.cartCountUrl = '{{ route('cart.count') }}';
            window.productId = {{ $product->id }};
            window.primaryColor = '#42b6f0';
            window.currencySymbol = '$';
            window.colorImagesData = @json($colorImagesData ?? []);
        </script>
        <script src="{{ asset('assets/js/product-details.js') }}"></script>
    @endpush
@endsection
