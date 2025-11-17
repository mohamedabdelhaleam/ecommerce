@extends('website.layout.app')

@section('title', 'Order Details')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-5xl flex-col flex-1">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold">Order Details</h1>
                <a href="{{ route('profile.orders') }}"
                    class="text-primary hover:opacity-80 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Orders
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Order Items</h2>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="flex gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                                    <div class="w-20 h-20 flex-shrink-0">
                                        @php
                                            $image = $item->product->primaryImage ?? $item->product->images->first();
                                            $imageUrl = $image
                                                ? asset('storage/' . $image->getRawOriginal('image'))
                                                : $item->product->image ?? 'https://placehold.co/400';
                                        @endphp
                                        <div class="w-full h-full bg-center bg-no-repeat bg-cover rounded-lg"
                                            style='background-image: url("{{ $imageUrl }}");'></div>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-brand-charcoal dark:text-white mb-1">
                                            {{ $item->product->name }}
                                        </h3>
                                        @if ($item->variant)
                                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-1">
                                                @if ($item->variant->size)
                                                    Size: {{ $item->variant->size->name }}
                                                @endif
                                                @if ($item->variant->color)
                                                    @if ($item->variant->size)
                                                        |
                                                    @endif
                                                    Color: {{ $item->variant->color->name }}
                                                @endif
                                            </p>
                                        @endif
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                                Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                            </span>
                                            <span class="font-semibold text-brand-charcoal dark:text-white">
                                                ${{ number_format($item->total, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-brand-charcoal dark:text-white">Total:</span>
                                <span class="text-xl font-bold text-primary">${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Order Information</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400">Order Number</label>
                                <p class="font-semibold text-brand-charcoal dark:text-white">{{ $order->order_number }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400">Order Date</label>
                                <p class="font-semibold text-brand-charcoal dark:text-white">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400">Payment Status</label>
                                <p>
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-medium {{ $order->is_paid ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' }}">
                                        {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500 dark:text-gray-400">Payment Method</label>
                                <p class="font-semibold text-brand-charcoal dark:text-white">
                                    {{ ucfirst($order->payment_method) }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-xl font-bold mb-4">Shipping Address</h2>
                        <div class="space-y-2 text-sm">
                            <p class="font-semibold text-brand-charcoal dark:text-white">{{ $order->shipping_name }}</p>
                            @if ($order->shipping_address)
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->shipping_address }}</p>
                            @endif
                            @if ($order->shipping_city || $order->shipping_state || $order->shipping_zip)
                                <p class="text-gray-600 dark:text-gray-400">
                                    @if ($order->shipping_city)
                                        {{ $order->shipping_city }}
                                    @endif
                                    @if ($order->shipping_state)
                                        , {{ $order->shipping_state }}
                                    @endif
                                    @if ($order->shipping_zip)
                                        {{ $order->shipping_zip }}
                                    @endif
                                </p>
                            @endif
                            @if ($order->shipping_country)
                                <p class="text-gray-600 dark:text-gray-400">{{ $order->shipping_country }}</p>
                            @endif
                            @if ($order->shipping_phone)
                                <p class="text-gray-600 dark:text-gray-400">Phone: {{ $order->shipping_phone }}</p>
                            @endif
                            <p class="text-gray-600 dark:text-gray-400">{{ $order->shipping_email }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
