@props(['image', 'name', 'rating', 'review'])
<div class="bg-white dark:bg-background-dark/50 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-800">
    <div class="flex items-center gap-4 mb-4">
        <div class="w-12 h-12 rounded-full bg-cover bg-center" data-alt="Avatar of a smiling young girl with pigtails."
            style="background-image: url('{{ e($image) }}');">
        </div>
        <div>
            <p class="font-bold text-brand-charcoal dark:text-white">{{ $name }}</p>
            <div class="flex items-center text-yellow-500">
                @for ($i = 0; $i < $rating; $i++)
                    <span class="material-symbols-outlined !text-base"
                        style="font-variation-settings: 'FILL' 1">star</span>
                @endfor
            </div>
        </div>
    </div>
    <p class="text-brand-charcoal/80 dark:text-gray-300 text-sm">"{{ $review }}"</p>
</div>
