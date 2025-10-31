@props(['image', 'title'])
<div class="flex h-full flex-1 flex-col gap-3 text-center rounded-lg min-w-40 pt-4 cursor-pointer group">
    <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full flex flex-col self-center w-full shadow-md group-hover:scale-105 transition-transform"
        data-alt="{{ $title }}" style="background-image: url('{{ e($image) }}');">
    </div>
    <p class="text-brand-charcoal dark:text-gray-300 text-base font-medium leading-normal">{{ $title }}
    </p>
</div>
