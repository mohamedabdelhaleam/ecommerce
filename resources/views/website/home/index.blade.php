@extends('website.layout.app')

@section('title', 'Home')

@section('contents')
    <main class="flex flex-col gap-12 sm:gap-16 md:gap-20">
        {{-- Start Hero Section --}}
        <div class="@container mt-8">
            <div class="@[480px]:p-4">
                <div class="flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat @[480px]:gap-8 @[480px]:rounded-xl items-center justify-center p-4"
                    data-alt="Modern ecommerce store showcasing quality products."
                    style='background-image: linear-gradient(rgba(0, 0, 0, 0.1) 0%, rgba(0, 0, 0, 0.3) 100%), url("https://placehold.co/1920x900?text=Hello+World");'>
                    <div class="flex flex-col gap-3 text-center">
                        <h1
                            class="text-white text-4xl font-black leading-tight tracking-[-0.033em] @[480px]:text-5xl @[480px]:font-black @[480px]:leading-tight @[480px]:tracking-[-0.033em] text-shadow-lg">
                            Your One-Stop Shop for Quality Products
                        </h1>
                        <h2 class="text-white text-base font-normal leading-normal @[480px]:text-lg max-w-2xl mx-auto">
                            Discover our carefully selected collection of premium products at unbeatable prices.
                        </h2>
                    </div>
                    <div class="flex-wrap gap-4 flex justify-center">
                        <button
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-brand-peach text-brand-charcoal text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em] hover:opacity-90 transition-opacity">
                            <span class="truncate">Shop Now</span>
                        </button>
                        <button
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-10 px-4 @[480px]:h-12 @[480px]:px-5 bg-white/90 text-brand-charcoal text-sm font-bold leading-normal tracking-[0.015em] @[480px]:text-base @[480px]:font-bold @[480px]:leading-normal @[480px]:tracking-[0.015em] hover:bg-white transition-colors">
                            <span class="truncate">Explore Categories</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Hero Section --}}
        {{-- Start Filters Section --}}
        <div class="w-full" data-animate="fade-in">
            <section class="border-b border-gray-200 dark:border-gray-800 pb-6 mb-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <h2 class="text-brand-charcoal dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em]">
                        Filters</h2>
                    <div class="flex flex-wrap items-center gap-3">
                        <div class="relative">
                            <select
                                class="form-select appearance-none bg-white dark:bg-background-dark/50 border border-gray-300 dark:border-gray-700 rounded-lg py-2 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                <option>Sort By</option>
                                <option>Popularity</option>
                                <option>Newest</option>
                                <option>Price: Low to High</option>
                                <option>Price: High to Low</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">expand_more</span>
                        </div>
                        <div class="relative">
                            <select
                                class="form-select appearance-none bg-white dark:bg-background-dark/50 border border-gray-300 dark:border-gray-700 rounded-lg py-2 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary">
                                <option>Price Range</option>
                                <option>$0 - $25</option>
                                <option>$25 - $50</option>
                                <option>$50 - $100</option>
                                <option>$100+</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">expand_more</span>
                        </div>
                    </div>
                </div>
            </section>
            <section data-animate="slide-up">
                <h2
                    class="text-brand-charcoal dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Shop by Category</h2>
                <div
                    class="flex overflow-x-auto [-ms-scrollbar-style:none] [scrollbar-width:none] [&amp;::-webkit-scrollbar]:hidden pb-4">
                    <div class="flex items-stretch p-4 gap-6">
                        @foreach ($categories as $category)
                            <x-website.cards.category image="{{ $category->image }}" title="{{ $category->name_en }}" />
                        @endforeach
                    </div>
                </div>
            </section>
            <section class="mt-12" data-animate="stagger">
                <h2
                    class="text-brand-charcoal dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5">
                    Featured Products</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 px-4">
                    @foreach ($products as $product)
                        @php
                            $productData = new \App\Http\Resources\ProductResource($product);
                            $productArray = $productData->toArray(request());
                        @endphp
                        <x-website.cards.product-card :product="$productArray" />
                    @endforeach
                </div>
            </section>
        </div>
        {{-- End Filters Section --}}
        {{-- Start Our Story Section --}}
        <section
            class="bg-brand-mint/30 dark:bg-primary/10 rounded-xl p-8 sm:p-12 md:p-16 flex flex-col md:flex-row items-center gap-8 md:gap-12"
            data-animate="scale">
            <div class="w-full md:w-1/2">
                <img class="rounded-xl w-full h-auto object-cover aspect-video"
                    data-alt="Quality products displayed in a modern setting."
                    src="https://placehold.co/600x400?text=Hello+World" />
            </div>
            <div class="w-full md:w-1/2 text-center md:text-left">
                <h2 class="text-3xl font-bold text-brand-charcoal dark:text-white mb-4">Quality Products, Exceptional
                    Service
                </h2>
                <p class="text-brand-charcoal/80 dark:text-gray-300 mb-6">Our mission is to provide you with the best
                    products at competitive prices. We carefully curate our collection, ensuring every item meets our high
                    standards for quality and value. From premium materials to exceptional customer service, we're committed
                    to your satisfaction.</p>
                <button
                    class="bg-white dark:bg-background-dark/80 text-brand-charcoal dark:text-white font-bold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">Learn
                    More</button>
            </div>
        </section>
        {{-- End Our Story Section --}}
        {{-- Start Customer Reviews Section --}}
        <section data-animate="fade-in" class="relative">
            <h2
                class="text-brand-charcoal dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                What Our Customers Say</h2>
            <div class="relative overflow-hidden">
                <div class="reviews-slider-container px-4" id="reviews-slider-container">
                    <div class="reviews-slider flex gap-8 transition-transform duration-500 ease-in-out" id="reviews-slider"
                        style="will-change: transform;">
                        @forelse ($reviews as $review)
                            @php
                                // Generate avatar URL based on name
                                $avatarUrl =
                                    'https://ui-avatars.com/api/?name=' .
                                    urlencode($review->name) .
                                    '&background=random&color=fff&size=128';
                            @endphp
                            <div class="review-slide flex-shrink-0" style="width: calc((100% - 48px) / 1);">
                                <x-website.cards.review image="{{ $avatarUrl }}" name="{{ $review->name }}"
                                    rating="{{ $review->rating }}" review="{{ $review->comment }}" />
                            </div>
                        @empty
                            <div class="w-full text-center text-brand-charcoal/60 dark:text-gray-400 py-8">
                                <p>No reviews yet. Be the first to review!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
                @if ($reviews->count() > 3)
                    <button
                        class="reviews-slider-btn reviews-slider-prev absolute left-4 top-1/2 -translate-y-1/2 bg-white dark:bg-background-dark/80 rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10 opacity-50 pointer-events-none"
                        id="reviews-prev">
                        <span class="material-symbols-outlined text-brand-charcoal dark:text-white">chevron_left</span>
                    </button>
                    <button
                        class="reviews-slider-btn reviews-slider-next absolute right-4 top-1/2 -translate-y-1/2 bg-white dark:bg-background-dark/80 rounded-full p-3 shadow-lg hover:shadow-xl transition-shadow z-10"
                        id="reviews-next">
                        <span class="material-symbols-outlined text-brand-charcoal dark:text-white">chevron_right</span>
                    </button>
                @endif
            </div>
        </section>
        {{-- End Customer Reviews Section --}}
        {{-- Start Newsletter Section --}}
        <section class="bg-brand-blue/30 dark:bg-primary/10 rounded-xl p-8 sm:p-12 text-center" data-animate="fade-in">
            <h2 class="text-3xl font-bold text-brand-charcoal dark:text-white mb-2">Subscribe to Our Newsletter</h2>
            <p class="text-brand-charcoal/80 dark:text-gray-300 mb-6 max-w-lg mx-auto">Get exclusive offers, new product
                updates, and special promotions delivered to your inbox.</p>
            <form class="flex flex-col sm:flex-row items-center justify-center max-w-md mx-auto gap-3">
                <input
                    class="form-input w-full px-4 py-3 rounded-xl border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-primary focus:border-primary"
                    placeholder="Your email address" type="email" />
                <button
                    class="w-full sm:w-auto flex items-center justify-center gap-2 bg-brand-peach text-brand-charcoal font-bold py-3 px-6 rounded-xl hover:opacity-90 transition-opacity"
                    type="submit">
                    <span class="material-symbols-outlined">auto_awesome</span>
                    <span>Subscribe</span>
                </button>
            </form>
        </section>
        {{-- End Newsletter Section --}}
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Reviews Slider
            const reviewsSlider = document.getElementById('reviews-slider');
            const reviewsSliderContainer = document.getElementById('reviews-slider-container');
            const reviewsPrev = document.getElementById('reviews-prev');
            const reviewsNext = document.getElementById('reviews-next');

            if (reviewsSlider && reviewsSliderContainer) {
                let currentSlide = 0;
                const slides = reviewsSlider.querySelectorAll('.review-slide');
                const totalSlides = slides.length;
                let slidesPerView = 1;
                let autoSlideInterval = null;

                // Determine slides per view based on screen size
                function updateSlidesPerView() {
                    const width = window.innerWidth;
                    if (width >= 1024) {
                        slidesPerView = 3;
                    } else if (width >= 768) {
                        slidesPerView = 2;
                    } else {
                        slidesPerView = 1;
                    }

                    // Update slide widths
                    const containerWidth = reviewsSliderContainer.offsetWidth;
                    const gap = 32; // gap-8 = 2rem = 32px
                    const slideWidth = (containerWidth - (gap * (slidesPerView - 1))) / slidesPerView;

                    slides.forEach(slide => {
                        slide.style.width = `${slideWidth}px`;
                    });
                }

                function updateSlider() {
                    if (slides.length === 0) return;

                    const maxSlide = Math.max(0, totalSlides - slidesPerView);
                    currentSlide = Math.min(currentSlide, maxSlide);
                    currentSlide = Math.max(0, currentSlide);

                    // Calculate translateX based on slide width and gap
                    const containerWidth = reviewsSliderContainer.offsetWidth;
                    const gap = 32;
                    const slideWidth = (containerWidth - (gap * (slidesPerView - 1))) / slidesPerView;
                    const translateX = -(currentSlide * (slideWidth + gap));

                    reviewsSlider.style.transform = `translateX(${translateX}px)`;

                    // Update button states
                    if (reviewsPrev) {
                        const isDisabled = currentSlide === 0;
                        reviewsPrev.style.opacity = isDisabled ? '0.5' : '1';
                        reviewsPrev.style.pointerEvents = isDisabled ? 'none' : 'auto';
                        reviewsPrev.disabled = isDisabled;
                    }
                    if (reviewsNext) {
                        const isDisabled = currentSlide >= maxSlide;
                        reviewsNext.style.opacity = isDisabled ? '0.5' : '1';
                        reviewsNext.style.pointerEvents = isDisabled ? 'none' : 'auto';
                        reviewsNext.disabled = isDisabled;
                    }
                }

                function startAutoSlide() {
                    if (autoSlideInterval) {
                        clearInterval(autoSlideInterval);
                    }
                    autoSlideInterval = setInterval(function() {
                        const maxSlide = Math.max(0, totalSlides - slidesPerView);
                        if (currentSlide < maxSlide) {
                            currentSlide++;
                        } else {
                            currentSlide = 0;
                        }
                        updateSlider();
                    }, 5000);
                }

                // Initialize
                updateSlidesPerView();
                updateSlider();
                startAutoSlide();

                // Handle resize
                let resizeTimeout;
                window.addEventListener('resize', function() {
                    clearTimeout(resizeTimeout);
                    resizeTimeout = setTimeout(function() {
                        updateSlidesPerView();
                        updateSlider();
                    }, 250);
                });

                // Navigation buttons
                if (reviewsPrev) {
                    reviewsPrev.addEventListener('click', function() {
                        if (currentSlide > 0) {
                            currentSlide--;
                            updateSlider();
                            startAutoSlide();
                        }
                    });
                }

                if (reviewsNext) {
                    reviewsNext.addEventListener('click', function() {
                        const maxSlide = Math.max(0, totalSlides - slidesPerView);
                        if (currentSlide < maxSlide) {
                            currentSlide++;
                            updateSlider();
                            startAutoSlide();
                        }
                    });
                }

                // Pause on hover
                if (reviewsSliderContainer) {
                    reviewsSliderContainer.addEventListener('mouseenter', function() {
                        if (autoSlideInterval) {
                            clearInterval(autoSlideInterval);
                        }
                    });
                    reviewsSliderContainer.addEventListener('mouseleave', function() {
                        startAutoSlide();
                    });
                }
            }

            // Add to Cart functionality for home page products
            function initHomeAddToCart() {
                const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
                const addToCartUrl = '{{ route('cart.add') }}';
                const cartCountUrl = '{{ route('cart.count') }}';

                addToCartButtons.forEach((btn) => {
                    if (btn.hasAttribute("data-listener-attached")) {
                        return;
                    }
                    btn.setAttribute("data-listener-attached", "true");

                    btn.addEventListener("click", function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        const productId = this.getAttribute("data-product-id");
                        const variantId = this.getAttribute("data-variant-id");

                        if (!productId) {
                            console.error("Product ID not found");
                            return;
                        }

                        const originalText = this.textContent;
                        this.disabled = true;
                        this.textContent = "Adding...";

                        const formData = new FormData();
                        formData.append("product_id", productId);
                        formData.append("quantity", 1);
                        if (variantId) {
                            formData.append("variant_id", variantId);
                        }

                        fetch(addToCartUrl, {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                    "X-CSRF-TOKEN": document
                                        .querySelector('meta[name="csrf-token"]')
                                        ?.getAttribute("content") || "",
                                },
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                if (data.success) {
                                    showToast({
                                        icon: "success",
                                        title: "Added to Cart!",
                                        text: data.message ||
                                            "Product added to cart successfully.",
                                        timer: 2000,
                                    });
                                    updateCartCount();
                                } else {
                                    showToast({
                                        icon: "error",
                                        title: "Error",
                                        text: data.message ||
                                            "Failed to add product to cart.",
                                    });
                                }
                            })
                            .catch((error) => {
                                console.error("Error:", error);
                                showToast({
                                    icon: "error",
                                    title: "Error",
                                    text: "There was an error adding the product to cart.",
                                });
                            })
                            .finally(() => {
                                this.disabled = false;
                                this.textContent = originalText;
                            });
                    });
                });
            }

            function updateCartCount() {
                fetch('{{ route('cart.count') }}', {
                        method: "GET",
                        headers: {
                            "X-Requested-With": "XMLHttpRequest",
                        },
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        const cartCountEl = document.getElementById("cart-count");
                        if (cartCountEl) {
                            cartCountEl.textContent = data.count || 0;
                            cartCountEl.style.display = data.count > 0 ? "flex" : "none";
                        }
                    })
                    .catch((error) => console.error("Error updating cart count:", error));
            }

            // Initialize add to cart
            initHomeAddToCart();

            // Re-initialize when new product cards are added
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        initHomeAddToCart();
                    }
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        });
    </script>
@endpush
