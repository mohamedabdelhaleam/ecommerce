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

@if ($products->hasPages())
    <nav class="flex items-center justify-center gap-2 mt-12" id="products-pagination">
        {{-- Previous Page Link --}}
        @if ($products->onFirstPage())
            <span
                class="flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 opacity-50 cursor-not-allowed">
                <span class="material-symbols-outlined text-xl">chevron_left</span>
            </span>
        @else
            <a class="pagination-link flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                href="{{ $products->previousPageUrl() }}" data-page="{{ $products->currentPage() - 1 }}">
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
                <a class="pagination-link flex h-10 w-10 items-center justify-center rounded-full hover:bg-stone-200 dark:hover:bg-stone-800 transition-colors font-bold text-sm"
                    href="{{ $url }}" data-page="{{ $page }}">{{ $page }}</a>
            @elseif (abs($page - $products->currentPage()) == 3)
                <span class="flex h-10 w-10 items-center justify-center font-bold text-sm">...</span>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($products->hasMorePages())
            <a class="pagination-link flex h-10 w-10 items-center justify-center rounded-full bg-stone-200 dark:bg-stone-800 hover:bg-stone-300 dark:hover:bg-stone-700 transition-colors"
                href="{{ $products->nextPageUrl() }}" data-page="{{ $products->currentPage() + 1 }}">
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
