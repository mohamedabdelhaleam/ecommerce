<div class="review-item flex gap-4 border-b border-border-light dark:border-border-dark pb-6">
    <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary font-bold text-lg">
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
                        <span class="material-symbols-outlined text-base">star_outline</span>
                    @endif
                @endfor
            </div>
        @endif
        <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
    </div>
</div>
