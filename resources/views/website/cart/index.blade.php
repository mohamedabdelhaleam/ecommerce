@extends('website.layout.app')

@section('title', 'Shopping Cart')
@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-5">
        <div class="layout-content-container mx-auto flex max-w-7xl flex-col flex-1">
            <h1 class="text-3xl font-bold mb-6">Shopping Cart</h1>

            @if (count($cartItems) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6">
                            <div class="space-y-4">
                                @foreach ($cartItems as $item)
                                    <div class="flex gap-4 pb-4 border-b border-border-light dark:border-border-dark last:border-0 cart-item"
                                        data-key="{{ $item['key'] }}">
                                        <!-- Product Image -->
                                        <div class="w-24 h-24 flex-shrink-0">
                                            @php
                                                $image = $item['product']->primaryImage ?? $item['product']->images->first();
                                                $imageUrl = $image
                                                    ? asset('storage/' . $image->getRawOriginal('image'))
                                                    : ($item['product']->image ?? 'https://placehold.co/400');
                                            @endphp
                                            <div class="w-full h-full bg-center bg-no-repeat bg-cover rounded-lg"
                                                style='background-image: url("{{ $imageUrl }}");'></div>
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 flex flex-col gap-2">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <h3 class="font-bold text-lg">
                                                        <a href="{{ route('products.show', $item['product']->id) }}"
                                                            class="hover:text-primary transition-colors">
                                                            {{ $item['product']->name }}
                                                        </a>
                                                    </h3>
                                                    @if ($item['variant'])
                                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                                            @if ($item['variant']->size)
                                                                Size: {{ $item['variant']->size->name }}
                                                            @endif
                                                            @if ($item['variant']->color)
                                                                @if ($item['variant']->size)
                                                                    ,
                                                                @endif
                                                                Color: {{ $item['variant']->color->name }}
                                                            @endif
                                                        </p>
                                                    @endif
                                                </div>
                                                <button type="button"
                                                    class="remove-item text-red-500 hover:text-red-700 transition-colors"
                                                    data-key="{{ $item['key'] }}">
                                                    <span class="material-symbols-outlined">close</span>
                                                </button>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <!-- Quantity Controls -->
                                                <div class="flex items-center gap-2">
                                                    <label class="text-sm font-medium text-text-light dark:text-text-dark">Qty:</label>
                                                    <div
                                                        class="flex items-center border border-border-light dark:border-border-dark rounded-lg overflow-hidden">
                                                        <button type="button"
                                                            class="quantity-decrease px-3 py-1 text-lg text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">-</button>
                                                        <input type="number" min="1"
                                                            class="cart-quantity w-16 text-center border-0 bg-transparent focus:ring-0 text-text-light dark:text-text-dark py-1"
                                                            value="{{ $item['quantity'] }}" data-key="{{ $item['key'] }}" />
                                                        <button type="button"
                                                            class="quantity-increase px-3 py-1 text-lg text-gray-500 dark:text-gray-400 hover:text-primary transition-colors">+</button>
                                                    </div>
                                                </div>

                                                <!-- Price -->
                                                <div class="text-right">
                                                    <p class="text-lg font-bold text-text-light dark:text-text-dark">
                                                        $<span class="item-total">{{ number_format($item['total'], 2) }}</span>
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        ${{ number_format($item['price'], 2) }} each
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 sticky top-24">
                            <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                            <div class="space-y-4">
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Subtotal</span>
                                    <span>$<span id="cart-subtotal">{{ number_format($subtotal, 2) }}</span></span>
                                </div>
                                <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                    <span>Shipping</span>
                                    <span>Free</span>
                                </div>
                                <div class="border-t border-border-light dark:border-border-dark pt-4">
                                    <div class="flex justify-between text-lg font-bold">
                                        <span>Total</span>
                                        <span>$<span id="cart-total">{{ number_format($total, 2) }}</span></span>
                                    </div>
                                </div>
                                <button type="button"
                                    class="block w-full text-center bg-primary text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                    Proceed to Checkout
                                </button>
                                <a href="{{ route('products') }}"
                                    class="block w-full text-center border border-border-light dark:border-border-dark py-3 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-12 text-center">
                    <span class="material-symbols-outlined text-6xl text-gray-400 mb-4">shopping_bag</span>
                    <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">Looks like you haven't added anything to your cart yet.</p>
                    <a href="{{ route('products') }}"
                        class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </main>

    @push('scripts')
        <script src="{{ asset('assets/js/cart.js') }}"></script>
    @endpush
@endsection

