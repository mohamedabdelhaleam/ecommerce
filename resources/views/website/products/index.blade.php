@extends('website.layout.app')

@section('title', 'Products')
@section('contents')
    <main class="px-4 sm:px-8 lg:px-16 py-8">
        <div class=" mx-auto">
            <!-- Breadcrumbs -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Home</a>
                <span class="text-sm font-medium">/</span>
                <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Toys</a>
                <span class="text-sm font-medium">/</span>
                <span class="text-sm font-medium text-text-light/70 dark:text-text-dark/70">Building Blocks</span>
            </div>
            <!-- PageHeading -->
            <div class="flex flex-wrap justify-between gap-3 mb-8">
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-tighter">All Our Magical Toys</h1>
            </div>
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                <!-- Sticky Filter & Sort Sidebar -->
                <aside class="lg:w-1/4 xl:w-1/5 lg:sticky top-28 h-fit">
                    <div class="flex flex-col">
                        <div class="flex flex-col mb-6">
                            <h2 class="text-xl font-bold">Filter &amp; Sort</h2>
                            <p class="text-sm text-text-light/70 dark:text-text-dark/70">Find the perfect gift</p>
                        </div>
                        <div class="flex flex-col space-y-4">
                            <!-- Sort Dropdown -->
                            <div>
                                <label class="block text-sm font-medium mb-2" for="sort-by">Sort by</label>
                                <select
                                    class="w-full rounded border-stone-300 dark:border-stone-700 bg-background-light dark:bg-background-dark focus:border-primary focus:ring-primary text-sm"
                                    id="sort-by" name="sort">
                                    <option value="popularity" {{ $currentSort === 'popularity' ? 'selected' : '' }}>
                                        Popularity</option>
                                    <option value="newest" {{ $currentSort === 'newest' ? 'selected' : '' }}>Newest</option>
                                    <option value="price_low" {{ $currentSort === 'price_low' ? 'selected' : '' }}>Price:
                                        Low to High</option>
                                    <option value="price_high" {{ $currentSort === 'price_high' ? 'selected' : '' }}>Price:
                                        High to Low</option>
                                </select>
                            </div>
                            <!-- Accordions for filters -->
                            <div class="flex flex-col">

                                <details class="flex flex-col border-t border-stone-200 dark:border-stone-800 py-2 group"
                                    open="">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Category</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="space-y-2 pt-2 text-sm">
                                        @forelse($categories as $category)
                                            <label class="flex items-center gap-2">
                                                <input
                                                    class="category-checkbox rounded border-stone-300 dark:border-stone-700 text-primary focus:ring-primary"
                                                    type="checkbox" value="{{ $category->slug ?? $category->name }}"
                                                    {{ in_array($category->slug ?? $category->name, $selectedCategories) ? 'checked' : '' }} />
                                                {{ $category->name }}
                                            </label>
                                        @empty
                                            <p class="text-sm text-text-light/60 dark:text-text-dark/60">No categories
                                                available</p>
                                        @endforelse
                                    </div>
                                </details>
                                <details
                                    class="flex flex-col border-t border-b border-stone-200 dark:border-stone-800 py-2 group">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-2">
                                        <p class="text-sm font-medium">Price Range</p>
                                        <span
                                            class="material-symbols-outlined text-xl transition-transform group-open:rotate-180">expand_more</span>
                                    </summary>
                                    <div class="pt-4 pb-2 text-sm">
                                        <input id="price-range"
                                            class="w-full h-2 bg-stone-200 rounded-lg appearance-none cursor-pointer dark:bg-stone-700 accent-primary"
                                            max="{{ $priceRange['max'] }}" min="{{ $priceRange['min'] }}" type="range"
                                            value="{{ $currentMaxPrice }}" />
                                        <div class="flex justify-between mt-2 text-xs">
                                            <span>${{ number_format($priceRange['min'], 2) }}</span>
                                            <span id="price-display">${{ number_format($currentMaxPrice, 2) }}+</span>
                                        </div>
                                        <input type="hidden" id="min-price" value="{{ $priceRange['min'] }}">
                                        <input type="hidden" id="max-price" value="{{ $priceRange['max'] }}">
                                    </div>
                                </details>
                            </div>
                            <!-- Clear All Button -->
                            <button id="clear-filters"
                                class="w-full text-sm font-semibold py-2.5 rounded bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors">Clear
                                All Filters</button>
                        </div>
                    </div>
                </aside>
                <!-- Product Grid -->
                <div class="w-full lg:w-3/4 xl:w-4/5" id="products-container">
                    @include('website.products.partials.products-grid')
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        // Pass data to external JavaScript file
        window.addToCartUrl = '{{ route('cart.add') }}';
        window.cartCountUrl = '{{ route('cart.count') }}';
        window.primaryColor = '#42b6f0';
    </script>
    <script src="{{ asset('assets/js/products-filter.js') }}"></script>
@endpush
