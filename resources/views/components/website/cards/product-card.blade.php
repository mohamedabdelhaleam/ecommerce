@props(['product'])
@php
    // Handle both array and object formats
    if (is_array($product)) {
        $product = (object) $product;
        // Convert nested arrays to objects
        if (isset($product->category) && is_array($product->category)) {
            $product->category = (object) $product->category;
        }
        if (isset($product->price) && is_array($product->price)) {
            $product->price = (object) $product->price;
        }
    }
@endphp
<div
    class="group relative overflow-hidden rounded-xl bg-white dark:bg-background-dark/50 shadow-sm hover:shadow-xl transition-all duration-300 border border-stone-200 dark:border-stone-800">
    @if ($product->is_new ?? false)
        <div class="absolute top-3 left-3 z-10">
            <span class="inline-block bg-primary text-white text-xs font-bold px-2.5 py-1 rounded-full">NEW</span>
        </div>
    @endif
    <a class="block" href="{{ $product->url ?? '#' }}">
        <img class="w-full h-64 object-cover transition-transform duration-300 group-hover:scale-105"
            alt="{{ $product->name ?? 'Product' }}" src="{{ $product->image ?? 'https://placehold.co/400' }}" />
    </a>
    <div class="p-8">
        <p class="text-xs text-text-light/60 dark:text-text-dark/60">
            {{ $product->category->name ?? 'Uncategorized' }}</p>
        <h3 class="font-bold text-lg mt-1">
            <a href="{{ $product->url ?? '#' }}">{{ $product->name ?? 'Product Name' }}</a>
        </h3>
        <p class="font-bold text-primary mt-2">
            {{ $product->price->display ?? 'N/A' }}
        </p>
    </div>
    <div
        class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-white dark:from-background-dark/80 to-transparent opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
        <button type="button"
            class="add-to-cart-btn w-full bg-primary text-white font-bold py-2.5 rounded-lg text-sm transition-transform hover:scale-105"
            data-product-id="{{ $product->id ?? '' }}" data-product-url="{{ $product->url ?? '#' }}">
            Add to Cart
        </button>
    </div>
</div>
