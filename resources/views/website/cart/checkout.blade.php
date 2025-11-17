@extends('website.layout.app')

@section('title', 'Checkout')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-7xl flex-col flex-1">
            <h1 class="text-3xl font-bold mb-8">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Checkout Form -->
                <div class="lg:col-span-2">
                    @if (session('error'))
                        <div
                            class="mb-6 p-4 bg-red-100 dark:bg-red-900/30 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('cart.order.store') }}">
                        @csrf
                        <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
                            <h2 class="text-xl font-bold mb-4">Shipping Information</h2>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_name"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Full Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="shipping_name" name="shipping_name"
                                            value="{{ old('shipping_name', $user->name) }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                        @error('shipping_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="shipping_email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="shipping_email" name="shipping_email"
                                            value="{{ old('shipping_email', $user->email) }}" required
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                        @error('shipping_email')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="shipping_phone"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Phone Number
                                    </label>
                                    <input type="tel" id="shipping_phone" name="shipping_phone"
                                        value="{{ old('shipping_phone', $user->phone ?? '') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    @error('shipping_phone')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="shipping_address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Address
                                    </label>
                                    <input type="text" id="shipping_address" name="shipping_address"
                                        value="{{ old('shipping_address', $user->address ?? '') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    @error('shipping_address')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label for="shipping_city"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            City
                                        </label>
                                        <input type="text" id="shipping_city" name="shipping_city"
                                            value="{{ old('shipping_city', $user->city ?? '') }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                        @error('shipping_city')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="shipping_state"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            State
                                        </label>
                                        <input type="text" id="shipping_state" name="shipping_state"
                                            value="{{ old('shipping_state', $user->state ?? '') }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                        @error('shipping_state')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="shipping_zip"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            ZIP Code
                                        </label>
                                        <input type="text" id="shipping_zip" name="shipping_zip"
                                            value="{{ old('shipping_zip', $user->zip ?? '') }}"
                                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                        @error('shipping_zip')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div>
                                    <label for="shipping_country"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Country
                                    </label>
                                    <input type="text" id="shipping_country" name="shipping_country"
                                        value="{{ old('shipping_country', $user->country ?? '') }}"
                                        class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-700 dark:bg-background-dark focus:ring-2 focus:ring-primary focus:border-primary text-brand-charcoal dark:text-white">
                                    @error('shipping_country')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
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
                            @error('payment_method')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
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
                        <button type="submit"
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
            </form>
    </main>
@endsection
