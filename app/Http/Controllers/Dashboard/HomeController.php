<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Traits\ChartDataTrait;
use App\Traits\StatisticsTrait;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use ChartDataTrait, StatisticsTrait;
    public function __construct()
    {
        $this->middleware('permission:view dashboard');
    }

    /**
     * Display the dashboard home page.
     */
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('dashboard.login');
        }

        // Calculate statistics
        $stats = $this->calculateStatistics();

        $productsMonth = $this->getRecentProducts();
        $usersMonth = $this->getRecentUsers();
        $topCustomers = $this->getTopCustomers();
        $topProducts = $this->getTopProducts();
        $productsChartData = $this->getChartData(Product::class, 6);
        $ordersChartData = $this->getChartData(Order::class, 6);

        return view('dashboard.pages.home.index', $stats + [
            'productsMonth' => $productsMonth,
            'usersMonth' => $usersMonth,
            'topCustomers' => $topCustomers,
            'topProducts' => $topProducts,
            'productsChartData' => $productsChartData,
            'ordersChartData' => $ordersChartData,
        ]);
    }

    /**
     * Calculate dashboard statistics
     */
    private function calculateStatistics(): array
    {
        // Total Products
        $productsStats = $this->getStatisticsWithPercentage(Product::class);

        // Total Orders
        $ordersStats = $this->getStatisticsWithPercentage(Order::class);

        // Total Customers (Users)
        $customersStats = $this->getStatisticsWithPercentage(User::class);

        // Total Revenue (with condition for paid orders)
        $now = now();
        $lastMonthEnd = $now->copy()->subMonth()->endOfMonth();
        $totalRevenue = Order::where('is_paid', true)->sum('total');
        $revenueLastMonth = Order::where('is_paid', true)
            ->where('created_at', '<=', $lastMonthEnd)
            ->sum('total');
        $revenuePercentage = $this->calculatePercentage($totalRevenue, $revenueLastMonth);

        return [
            'totalProducts' => $productsStats['total'],
            'productsPercentage' => $productsStats['percentage'],
            'totalOrders' => $ordersStats['total'],
            'ordersPercentage' => $ordersStats['percentage'],
            'totalCustomers' => $customersStats['total'],
            'customersPercentage' => $customersStats['percentage'],
            'totalRevenue' => $totalRevenue,
            'revenuePercentage' => $revenuePercentage,
        ];
    }

    /**
     * Get recent products for this month
     * Note: $product->name automatically uses getNameAttribute() accessor
     * which handles multi-language based on app()->getLocale()
     */
    private function getRecentProducts(int $limit = 5): \Illuminate\Support\Collection
    {
        $now = now();

        return Product::with(['primaryImage', 'images', 'activeVariants'])
            ->where('created_at', '>=', $now->copy()->startOfMonth())
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name, // Uses getNameAttribute() - handles multi-language
                    'image' => $product->image,
                    'price' => $product->min_price ? number_format($product->min_price, 2) : '0.00',
                ];
            });
    }

    /**
     * Get recent users for this month
     */
    private function getRecentUsers(int $limit = 5): \Illuminate\Support\Collection
    {
        $now = now();

        return User::where('created_at', '>=', $now->copy()->startOfMonth())
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'created_at' => $user->created_at,
                    'email' => $user->email,
                ];
            });
    }

    /**
     * Get top customers by order count
     */
    private function getTopCustomers(int $limit = 5): \Illuminate\Support\Collection
    {
        return User::withCount('orders')
            ->having('orders_count', '>', 0)
            ->orderBy('orders_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'created_at' => $user->created_at,
                    'email' => $user->email,
                    'orders_count' => $user->orders_count,
                ];
            });
    }

    /**
     * Get top products by order count
     * Note: $product->name automatically uses getNameAttribute() accessor
     * which handles multi-language based on app()->getLocale()
     */
    private function getTopProducts(int $limit = 5): \Illuminate\Support\Collection
    {
        return Product::withCount('orderItems')
            ->with(['primaryImage', 'images'])
            ->having('order_items_count', '>', 0)
            ->orderBy('order_items_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name, // Uses getNameAttribute() - handles multi-language
                    'image' => $product->image,
                    'orders_count' => $product->order_items_count ?? 0,
                ];
            });
    }
}
