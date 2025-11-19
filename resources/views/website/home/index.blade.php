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
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    {{-- <x-website.cards.product
                        image="https://lh3.googleusercontent.com/aida-public/AB6AXuC3XNpSQQDRk_p0dm0URGo7-6SR8BSD10AX0mRWVTY0mjcUmvkB0ina_fXUPzBSIfwWf2K7uThYOzZYhYlD3Sy7GVcxzBwIVMq1xZn9KYnx4_Z2HmRWEK_WeP40e8rCnDbVXSiWY0cR4lj8e0FrM3doraAWNR4eSnGr7CYy619v3s4JcJtfGTS8-GSplV8TvVKiX6-896zUm-Z1dHtXcELXRgi-AoEtdTVzBomi8lgXsykMpJ2KVLcpYvT75mXvAnNqEmsPiBlPjPU"
                        title="Plush Teddy Bear" price="19.99" rating="5" data-stagger-item /> --}}
                    @foreach ($products as $product)
                        <x-website.cards.product image="{{ $product->image }}" title="{{ $product->name_en }}"
                            price="19.99" rating="{{ rand(1, 5) }}" data-stagger-item />
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
        <section data-animate="fade-in">
            <h2
                class="text-brand-charcoal dark:text-white text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-5 pt-5 text-center">
                What Our Customers Say</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-4">
                @forelse ($reviews as $review)
                    @php
                        // Generate avatar URL based on name
                        $avatarUrl =
                            'https://ui-avatars.com/api/?name=' .
                            urlencode($review->name) .
                            '&background=random&color=fff&size=128';
                    @endphp
                    <x-website.cards.review image="{{ $avatarUrl }}" name="{{ $review->name }}"
                        rating="{{ $review->rating }}" review="{{ $review->comment }}" data-stagger-item />
                @empty
                    <div class="col-span-full text-center text-brand-charcoal/60 dark:text-gray-400 py-8">
                        <p>No reviews yet. Be the first to review!</p>
                    </div>
                @endforelse
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
