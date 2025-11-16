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
                        @if ($reviewStats['total'] > 0)
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex text-primary">
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ number_format($reviewStats['average'], 1) }} ({{ $reviewStats['total'] }}
                                    {{ $reviewStats['total'] == 1 ? 'Review' : 'Reviews' }})
                                </p>
                            </div>
                        @endif
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
                        <button
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
            <div class="mt-16">
                <h2 class="text-3xl font-bold mb-6">Customer Reviews</h2>

                <!-- Write a Review Form -->
                <div class="bg-white dark:bg-background-dark/50 rounded-xl p-8 shadow-sm mb-8">
                    <h3 class="text-xl font-bold mb-4">Write a Review</h3>
                    <form id="review-form" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <!-- Name and Email -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="review-name"
                                    class="block text-sm font-medium text-text-light dark:text-text-dark mb-2">Name
                                    *</label>
                                <input type="text" id="review-name" name="name" required
                                    class="w-full px-4 py-2 border border-border-light dark:border-border-dark rounded-lg bg-white dark:bg-background-dark text-text-light dark:text-text-dark focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="Your name">
                            </div>
                            <div>
                                <label for="review-email"
                                    class="block text-sm font-medium text-text-light dark:text-text-dark mb-2">Email
                                    *</label>
                                <input type="email" id="review-email" name="email" required
                                    class="w-full px-4 py-2 border border-border-light dark:border-border-dark rounded-lg bg-white dark:bg-background-dark text-text-light dark:text-text-dark focus:ring-2 focus:ring-primary focus:border-primary"
                                    placeholder="your.email@example.com">
                            </div>
                        </div>

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
                            <textarea id="review-comment" name="comment" rows="5" required
                                class="w-full px-4 py-2 border border-border-light dark:border-border-dark rounded-lg bg-white dark:bg-background-dark text-text-light dark:text-text-dark focus:ring-2 focus:ring-primary focus:border-primary resize-none"
                                placeholder="Share your thoughts about this product..."></textarea>
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

                @if ($reviewStats['total'] > 0)
                    <div class="bg-white dark:bg-background-dark/50 rounded-xl p-8 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div
                                class="flex flex-col items-center justify-center gap-2 border-r border-border-light dark:border-border-dark pr-8">
                                <p class="text-5xl font-black text-primary">
                                    {{ number_format($reviewStats['average'], 1) }}
                                </p>
                                <div class="flex text-primary">
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
                                <p class="text-sm text-gray-500 dark:text-gray-400">Based on {{ $reviewStats['total'] }}
                                    {{ $reviewStats['total'] == 1 ? 'review' : 'reviews' }}</p>
                            </div>
                            <div class="col-span-2 flex flex-col gap-2 text-sm">
                                <!-- Rating bars -->
                                @for ($rating = 5; $rating >= 1; $rating--)
                                    @php
                                        $count = $reviewStats['distribution'][$rating] ?? 0;
                                        $percentage = $reviewStats['percentages'][$rating] ?? 0;
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="w-12">{{ $rating }} star</span>
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                                            <div class="bg-primary h-2.5 rounded-full"
                                                style="width: {{ $percentage }}%">
                                            </div>
                                        </div>
                                        <span>{{ $count }}</span>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <!-- Individual Reviews -->
                    @if ($reviews->count() > 0)
                        <div class="mt-8 space-y-6">
                            @foreach ($reviews as $review)
                                <div class="flex gap-4 border-b border-border-light dark:border-border-dark pb-6">
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
                                                        <span
                                                            class="material-symbols-outlined text-base">star_outline</span>
                                                    @endif
                                                @endfor
                                            </div>
                                        @endif
                                        <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
            </div>
            @endif
            <!-- You Might Also Like Section -->
            @if (count($relatedProducts) > 0)
                <div class="mt-24">
                    <h2 class="text-3xl font-bold mb-6 text-center">You Might Also Like</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach ($relatedProducts as $relatedProduct)
                            @php
                                $relatedProduct = is_array($relatedProduct)
                                    ? (object) $relatedProduct
                                    : $relatedProduct;
                                if (is_array($relatedProduct->category ?? null)) {
                                    $relatedProduct->category = (object) $relatedProduct->category;
                                }
                                if (is_array($relatedProduct->price ?? null)) {
                                    $relatedProduct->price = (object) $relatedProduct->price;
                                }
                            @endphp
                            <a href="{{ $relatedProduct->url ?? '#' }}" class="flex flex-col gap-3 group">
                                <div class="w-full bg-center bg-no-repeat aspect-square bg-cover rounded-xl transition-transform group-hover:scale-105"
                                    data-alt="{{ $relatedProduct->name ?? 'Product' }}"
                                    style='background-image: url("{{ $relatedProduct->image ?? 'https://placehold.co/400' }}");'>
                                </div>
                                <div class="text-center">
                                    <h4 class="font-semibold">{{ $relatedProduct->name ?? 'Product Name' }}</h4>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        {{ $relatedProduct->price->display ?? 'N/A' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Variants data from server
                const variants = @json($variantsData);
                const priceElement = document.getElementById('product-price');
                const minPrice = {{ $product->min_price ?? 0 }};
                const maxPrice = {{ $product->max_price ?? 0 }};

                // Selected size and color
                let selectedSizeId = null;
                let selectedColorId = null;

                // Function to find matching variant
                function findVariant(sizeId, colorId) {
                    // Try exact match first
                    let variant = variants.find(v => {
                        const sizeMatch = sizeId ? v.size_id == sizeId : v.size_id === null;
                        const colorMatch = colorId ? v.color_id == colorId : v.color_id === null;
                        return sizeMatch && colorMatch;
                    });

                    // If no exact match, try with size only
                    if (!variant && sizeId) {
                        variant = variants.find(v => v.size_id == sizeId && v.color_id === null);
                    }

                    // If still no match, try with color only
                    if (!variant && colorId) {
                        variant = variants.find(v => v.size_id === null && v.color_id == colorId);
                    }

                    // If still no match, get first variant with price
                    if (!variant) {
                        variant = variants.find(v => v.price !== null);
                    }

                    return variant;
                }

                // Function to update price
                function updatePrice() {
                    if (!priceElement) return;

                    const variant = findVariant(selectedSizeId, selectedColorId);

                    if (variant && variant.price !== null) {
                        priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                    } else {
                        // Fallback to price range
                        if (minPrice && maxPrice) {
                            if (minPrice === maxPrice) {
                                priceElement.textContent = '$' + minPrice.toFixed(2);
                            } else {
                                priceElement.textContent = '$' + minPrice.toFixed(2) + ' - $' + maxPrice.toFixed(2);
                            }
                        } else {
                            priceElement.textContent = 'N/A';
                        }
                    }
                }

                // Image gallery functionality
                const mainImage = document.getElementById('main-product-image');
                const thumbnailImages = document.querySelectorAll('.thumbnail-image');

                thumbnailImages.forEach(thumbnail => {
                    thumbnail.addEventListener('click', function() {
                        const imageUrl = this.getAttribute('data-image');
                        if (mainImage && imageUrl) {
                            mainImage.style.backgroundImage = `url("${imageUrl}")`;

                            // Update active thumbnail
                            thumbnailImages.forEach(t => {
                                t.classList.remove('border-2', 'border-primary');
                                t.classList.add('border', 'border-gray-300',
                                    'dark:border-gray-700');
                            });
                            this.classList.remove('border', 'border-gray-300', 'dark:border-gray-700');
                            this.classList.add('border-2', 'border-primary');
                        }
                    });
                });

                // Quantity controls
                const quantityInput = document.getElementById('quantity-input');
                const decreaseBtn = document.querySelector('.quantity-decrease');
                const increaseBtn = document.querySelector('.quantity-increase');

                if (decreaseBtn && quantityInput) {
                    decreaseBtn.addEventListener('click', function() {
                        const currentValue = parseInt(quantityInput.value) || 1;
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        }
                    });
                }

                if (increaseBtn && quantityInput) {
                    increaseBtn.addEventListener('click', function() {
                        const currentValue = parseInt(quantityInput.value) || 1;
                        quantityInput.value = currentValue + 1;
                    });
                }

                // Size and Color selection
                const sizeOptions = document.querySelectorAll('.size-option');
                const colorOptions = document.querySelectorAll('.color-option');

                sizeOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        sizeOptions.forEach(opt => {
                            opt.classList.remove('border-2', 'border-primary', 'bg-primary/20',
                                'font-bold');
                            opt.classList.add('border', 'border-border-light',
                                'dark:border-border-dark');
                        });
                        this.classList.remove('border', 'border-border-light',
                            'dark:border-border-dark');
                        this.classList.add('border-2', 'border-primary', 'bg-primary/20', 'font-bold');

                        // Update selected size and price
                        selectedSizeId = parseInt(this.getAttribute('data-size-id'));
                        updatePrice();
                    });
                });

                colorOptions.forEach(option => {
                    option.addEventListener('click', function() {
                        colorOptions.forEach(opt => {
                            opt.classList.remove('border-2', 'border-primary', 'bg-primary/20',
                                'font-bold');
                            opt.classList.add('border', 'border-border-light',
                                'dark:border-border-dark');
                        });
                        this.classList.remove('border', 'border-border-light',
                            'dark:border-border-dark');
                        this.classList.add('border-2', 'border-primary', 'bg-primary/20', 'font-bold');

                        // Update selected color and price
                        selectedColorId = parseInt(this.getAttribute('data-color-id'));
                        updatePrice();
                    });
                });

                // Set initial selection if first option exists
                if (sizeOptions.length > 0) {
                    const firstSize = sizeOptions[0];
                    selectedSizeId = parseInt(firstSize.getAttribute('data-size-id'));
                }
                if (colorOptions.length > 0) {
                    const firstColor = colorOptions[0];
                    selectedColorId = parseInt(firstColor.getAttribute('data-color-id'));
                }

                // Update price on initial load if we have selections
                if (selectedSizeId || selectedColorId) {
                    updatePrice();
                }

                // Review Form Functionality
                const reviewForm = document.getElementById('review-form');
                const ratingStars = document.querySelectorAll('.rating-star');
                const ratingInput = document.getElementById('review-rating');
                let selectedRating = 0;

                // Rating stars interaction
                ratingStars.forEach((star, index) => {
                    star.addEventListener('click', function() {
                        selectedRating = parseInt(this.getAttribute('data-rating'));
                        ratingInput.value = selectedRating;

                        // Update star display
                        ratingStars.forEach((s, i) => {
                            const icon = s.querySelector('span');
                            if (i < selectedRating) {
                                icon.textContent = 'star';
                                s.classList.remove('text-gray-300', 'dark:text-gray-600');
                                s.classList.add('text-primary');
                            } else {
                                icon.textContent = 'star_outline';
                                s.classList.remove('text-primary');
                                s.classList.add('text-gray-300', 'dark:text-gray-600');
                            }
                        });
                    });

                    star.addEventListener('mouseenter', function() {
                        const hoverRating = parseInt(this.getAttribute('data-rating'));
                        ratingStars.forEach((s, i) => {
                            const icon = s.querySelector('span');
                            if (i < hoverRating) {
                                icon.textContent = 'star';
                                s.classList.add('text-primary');
                            } else {
                                icon.textContent = 'star_outline';
                            }
                        });
                    });
                });

                // Reset stars on mouse leave (if no rating selected)
                document.getElementById('rating-stars').addEventListener('mouseleave', function() {
                    if (selectedRating === 0) {
                        ratingStars.forEach((s) => {
                            const icon = s.querySelector('span');
                            icon.textContent = 'star_outline';
                            s.classList.remove('text-primary');
                            s.classList.add('text-gray-300', 'dark:text-gray-600');
                        });
                    } else {
                        // Restore selected rating
                        ratingStars.forEach((s, i) => {
                            const icon = s.querySelector('span');
                            if (i < selectedRating) {
                                icon.textContent = 'star';
                                s.classList.add('text-primary');
                            } else {
                                icon.textContent = 'star_outline';
                            }
                        });
                    }
                });

                // Form submission
                if (reviewForm) {
                    reviewForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const submitBtn = document.getElementById('submit-review-btn');
                        const formData = new FormData(this);

                        // Validate rating
                        if (!ratingInput.value || ratingInput.value === '0') {
                            Swal.fire({
                                icon: 'error',
                                title: 'Rating Required',
                                text: 'Please select a rating before submitting your review.',
                                confirmButtonColor: '#42b6f0'
                            });
                            return;
                        }

                        // Disable submit button
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Submitting...';

                        // Submit via AJAX
                        fetch('{{ route('products.review.store', $product->id) }}', {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Thank You!',
                                        text: data.message ||
                                            'Your review has been submitted successfully. It will be reviewed before being published.',
                                        confirmButtonColor: '#42b6f0'
                                    }).then(() => {
                                        // Reset form
                                        reviewForm.reset();
                                        selectedRating = 0;
                                        ratingInput.value = '';
                                        ratingStars.forEach((s) => {
                                            const icon = s.querySelector('span');
                                            icon.textContent = 'star_outline';
                                            s.classList.remove('text-primary');
                                            s.classList.add('text-gray-300',
                                                'dark:text-gray-600');
                                        });
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message ||
                                            'There was an error submitting your review. Please try again.',
                                        confirmButtonColor: '#42b6f0'
                                    });
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error submitting your review. Please try again.',
                                    confirmButtonColor: '#42b6f0'
                                });
                            })
                            .finally(() => {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Submit Review';
                            });
                    });
                }
            });
        </script>
    @endpush
@endsection
