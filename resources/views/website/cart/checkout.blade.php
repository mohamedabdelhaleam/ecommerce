@extends('website.layout.app')

@section('title', 'Checkout')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-7xl flex-col flex-1">
            <h1 class="text-3xl font-bold mb-8">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                        <form id="checkout-form">
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name
                                        </label>
                                        <input type="text" value="{{ $user->name }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email
                                        </label>
                                        <input type="email" value="{{ $user->email }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="tel" value="{{ $user->phone ?? '' }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Address
                                    </label>
                                    <input type="text" value="{{ $user->address ?? '' }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            City
                                        </label>
                                        <input type="text" value="{{ $user->city ?? '' }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            State
                                        </label>
                                        <input type="text" value="{{ $user->state ?? '' }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            ZIP Code
                                        </label>
                                        <input type="text" value="{{ $user->zip ?? '' }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Country
                                    </label>
                                    <input type="text" value="{{ $user->country ?? '' }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6">
                        <h2 class="text-xl font-bold mb-4">Payment Method</h2>
                        <div class="space-y-3">
                            <label
                                class="flex items-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                <input type="radio" name="payment_method" value="cash" checked class="mr-3">
                                <span class="text-brand-charcoal dark:text-white">Cash on Delivery</span>
                            </label>
                            <label
                                class="flex items-center p-4 border border-gray-300 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800">
                                <input type="radio" name="payment_method" value="card" class="mr-3">
                                <span class="text-brand-charcoal dark:text-white">Credit/Debit Card</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 sticky top-24">
                        <h2 class="text-xl font-bold mb-4">Order Summary</h2>
                        <div class="space-y-4 mb-6">
                            @foreach ($cartItems as $item)
                                <div class="flex gap-3 pb-3 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                    <div class="w-16 h-16 flex-shrink-0">
                                        @php
                                            $image =
                                                $item['product']->primaryImage ?? $item['product']->images->first();
                                            $imageUrl = $image
                                                ? asset('storage/' . $image->getRawOriginal('image'))
                                                : $item['product']->image ?? 'https://placehold.co/400';
                                        @endphp
                                        <div class="w-full h-full bg-center bg-no-repeat bg-cover rounded-lg"
                                            style='background-image: url("{{ $imageUrl }}");'></div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-sm">{{ $item['product']->name }}</h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Qty: {{ $item['quantity'] }}
                                        </p>
                                        <p class="text-sm font-bold">${{ number_format($item['total'], 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Subtotal</span>
                                <span>${{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600 dark:text-gray-400">
                                <span>Shipping</span>
                                <span>Free</span>
                            </div>
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total</span>
                                    <span>${{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="place-order-btn"
                            class="mt-6 w-full bg-primary text-white py-3 rounded-lg font-semibold hover:opacity-90 transition-opacity">
                            Place Order
                        </button>
                        <a href="{{ route('cart.index') }}"
                            class="mt-3 block w-full text-center border border-gray-300 dark:border-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            Back to Cart
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.getElementById('place-order-btn').addEventListener('click', function() {
                // TODO: Implement order placement logic
                alert('Order placement functionality will be implemented here.');
            });
        </script>
    @endpush
@endsection
