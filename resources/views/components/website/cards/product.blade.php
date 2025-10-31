@props(['image', 'title', 'price', 'rating'])
<div
    class="flex flex-col gap-2 rounded-xl bg-white dark:bg-background-dark/50 dark:border-gray-800 p-4 shadow-sm group overflow-hidden transition-shadow hover:shadow-lg">
    <div
        class="flex flex-col gap-2 rounded-xl bg-white dark:bg-background-dark/50  dark:border-gray-800 p-4 shadow-sm group overflow-hidden transition-shadow hover:shadow-lg">
        <div class="relative">
            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-lg"
                data-alt="A soft, plush teddy bear wearing a blue bow."
                style='background-image: url("{{ e($image) }}");'>
            </div>
        </div>
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
</div>
