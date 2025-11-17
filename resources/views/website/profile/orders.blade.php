@extends('website.layout.app')

@section('title', 'My Orders')

@section('contents')
    <main class="px-4 sm:px-10 lg:px-20 py-12">
        <div class="layout-content-container mx-auto flex max-w-5xl flex-col flex-1">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold">My Orders</h1>
                <a href="{{ route('profile') }}"
                    class="text-primary hover:opacity-80 transition-opacity flex items-center gap-2">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Back to Profile
                </a>
            </div>

            @if (session('success'))
                <div
                    class="mb-6 p-4 bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if ($orders->count() > 0)
                <div class="space-y-4">
                    @foreach ($orders as $order)
                        <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-6">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-4 mb-2">
                                        <h3 class="text-lg font-semibold">Order #{{ $order->order_number }}</h3>
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-medium {{ $order->is_paid ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-300' }}">
                                            {{ $order->is_paid ? 'Paid' : 'Unpaid' }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        Placed on {{ $order->created_at->format('M d, Y h:i A') }}
                                    </p>
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                                        <span><strong>Items:</strong> {{ $order->items->sum('quantity') }}</span>
                                        <span><strong>Total:</strong> ${{ number_format($order->total, 2) }}</span>
                                        <span><strong>Payment:</strong> {{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('profile.orders.show', $order) }}"
                                        class="px-4 py-2 bg-primary text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>
                </div>
            @else
                <div class="bg-white dark:bg-background-dark/50 rounded-xl shadow-sm p-12 text-center">
                    <div class="mb-4">
                        <span class="material-symbols-outlined text-6xl text-gray-400 dark:text-gray-600">
                            shopping_bag
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-gray-700 dark:text-gray-300">No orders yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-6">You haven't placed any orders yet.</p>
                    <a href="{{ route('products') }}"
                        class="inline-block px-6 py-3 bg-primary text-white rounded-lg font-semibold hover:opacity-90 transition-opacity">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </main>
@endsection
