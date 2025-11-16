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
                                                    type="checkbox" value="{{ $category->id }}"
                                                    {{ in_array($category->id, $selectedCategories) ? 'checked' : '' }} />
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
                <div class="w-full lg:w-3/4 xl:w-4/5">
                    @if ($products->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6" id="products-grid">
                            @foreach ($productsData as $product)
                                <x-website.cards.product-card :product="$product" />
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <p class="text-lg text-text-light/70 dark:text-text-dark/70">No products found matching your
                                filters.</p>
                            <button id="clear-filters-empty"
                                class="mt-4 text-sm font-semibold py-2 px-4 rounded bg-primary text-white hover:bg-primary/90 transition-colors">
                                Clear All Filters
                            </button>
                        </div>
                    @endif
                    <!-- Pagination -->

                    @if ($products->hasPages())
                        <nav class="flex items-center justify-center gap-2 mt-12">
                            {{-- Previous Page Link --}}
                            @if ($products->onFirstPage())
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 opacity-50 cursor-not-allowed">
                                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                                </span>
                            @else
                                <a class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                                    href="{{ $products->previousPageUrl() }}">
                                    <span class="material-symbols-outlined text-xl">chevron_left</span>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                @if ($page == $products->currentPage())
                                    <span
                                        class="flex h-10 w-10 items-center justify-center rounded-full bg-primary text-white font-bold text-sm">
                                        {{ $page }}
                                    </span>
                                @elseif ($page == 1 || $page == $products->lastPage() || abs($page - $products->currentPage()) <= 2)
                                    <a class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors font-bold text-sm"
                                        href="{{ $url }}">{{ $page }}</a>
                                @elseif (abs($page - $products->currentPage()) == 3)
                                    <span class="flex h-10 w-10 items-center justify-center font-bold text-sm">...</span>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($products->hasMorePages())
                                <a class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                                    href="{{ $products->nextPageUrl() }}">
                                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                                </a>
                            @else
                                <span
                                    class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 opacity-50 cursor-not-allowed">
                                    <span class="material-symbols-outlined text-xl">chevron_right</span>
                                </span>
                            @endif
                        </nav>
                    @endif
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sortSelect = document.getElementById('sort-by');
                const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
                const priceRange = document.getElementById('price-range');
                const priceDisplay = document.getElementById('price-display');
                const clearFiltersBtn = document.getElementById('clear-filters');
                const clearFiltersEmptyBtn = document.getElementById('clear-filters-empty');
                const minPrice = parseFloat(document.getElementById('min-price').value);
                const maxPrice = parseFloat(document.getElementById('max-price').value);

                // Update price display when slider changes
                if (priceRange && priceDisplay) {
                    priceRange.addEventListener('input', function() {
                        const value = parseFloat(this.value);
                        priceDisplay.textContent = '$' + value.toFixed(2) + '+';
                    });
                }

                // Function to build URL with current filters
                function buildFilterUrl() {
                    const url = new URL(window.location.href);
                    const baseUrl = url.origin + url.pathname;
                    const params = new URLSearchParams();

                    // Get sort value
                    if (sortSelect && sortSelect.value) {
                        params.set('sort', sortSelect.value);
                    }

                    // Get selected categories
                    const selectedCategories = Array.from(categoryCheckboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    if (selectedCategories.length > 0) {
                        params.set('categories', selectedCategories.join(','));
                    }

                    // Get price range
                    if (priceRange) {
                        const maxPriceValue = parseFloat(priceRange.value);
                        const minPriceValue = parseFloat(document.getElementById('min-price').value);

                        // Only set max_price if it's less than the maximum available price
                        if (maxPriceValue < maxPrice) {
                            params.set('max_price', maxPriceValue);
                        }
                        // Always set min_price from the range minimum
                        params.set('min_price', minPriceValue);
                    }

                    // Build final URL
                    const queryString = params.toString();
                    return queryString ? baseUrl + '?' + queryString : baseUrl;
                }

                // Function to apply filters
                function applyFilters() {
                    const url = buildFilterUrl();
                    window.location.href = url;
                }

                // Sort change handler
                if (sortSelect) {
                    sortSelect.addEventListener('change', function() {
                        applyFilters();
                    });
                }

                // Category checkbox change handler (with debounce)
                let categoryTimeout;
                categoryCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        clearTimeout(categoryTimeout);
                        categoryTimeout = setTimeout(() => {
                            applyFilters();
                        }, 300); // Wait 300ms after last change
                    });
                });

                // Price range change handler (with debounce)
                let priceTimeout;
                if (priceRange) {
                    priceRange.addEventListener('change', function() {
                        clearTimeout(priceTimeout);
                        priceTimeout = setTimeout(() => {
                            applyFilters();
                        }, 500); // Wait 500ms after slider stops
                    });
                }

                // Clear filters handler
                function clearFilters() {
                    window.location.href = window.location.origin + window.location.pathname;
                }

                if (clearFiltersBtn) {
                    clearFiltersBtn.addEventListener('click', clearFilters);
                }

                if (clearFiltersEmptyBtn) {
                    clearFiltersEmptyBtn.addEventListener('click', clearFilters);
                }
            });
        </script>
    @endpush
@endsection
