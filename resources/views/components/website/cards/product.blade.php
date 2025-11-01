@props(['image', 'title', 'price', 'rating'])
<div
    class="flex flex-col gap-2 rounded-xl bg-white dark:bg-background-dark/50 dark:border-gray-800 p-4 shadow-sm group overflow-hidden transition-shadow hover:shadow-lg">
    <div class="relative">
        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg"
            data-alt="A soft, plush teddy bear wearing a blue bow." style='background-image: url("{{ e($image) }}");'>
        </div>
        <!-- Favorite Icon - Top Right -->
        <button type="button"
            class="absolute top-2 right-2 bg-white dark:bg-gray-800 rounded-full p-2 shadow-md hover:shadow-lg transition-shadow flex items-center justify-center w-10 h-10">
            <span
                class="material-symbols-outlined text-gray-600 dark:text-gray-300 hover:text-red-500 transition-colors">favorite</span>
        </button>
    </div>
    <div class="flex flex-col gap-1 pt-2">
        <h3 class="font-bold text-base text-brand-charcoal dark:text-white">{{ $title }}</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $price }}$</p>
        <div class="flex items-center gap-1 text-brand-yellow">
            @for ($i = 0; $i < $rating; $i++)
                <span class="material-symbols-outlined !text-base" style="font-variation-settings: 'FILL' 1">star</span>
            @endfor
        </div>
    </div>
    <!-- Add to Cart Button - Bottom (shows on hover) -->
    <button type="button"
        class="w-full mt-2 py-2 px-4 bg-brand-charcoal dark:bg-gray-700 text-white rounded-lg font-medium opacity-0 group-hover:opacity-100 transition-opacity hover:bg-brand-charcoal/90 dark:hover:bg-gray-600">
        Add to Cart
    </button>
</div>
