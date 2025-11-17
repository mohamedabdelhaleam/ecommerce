<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view orders')->only(['index', 'show']);
        $this->middleware('permission:edit orders')->only(['togglePaidStatus']);
    }

    /**
     * Display a listing of the orders.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'items.product', 'items.variant']);

        // Filter by payment status
        if ($request->has('is_paid') && $request->is_paid !== '') {
            $query->where('is_paid', $request->is_paid === '1');
        }

        // Search by order number or user name/email
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('shipping_name', 'like', "%{$search}%")
                    ->orWhere('shipping_email', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('dashboard.pages.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order): View
    {
        $order->load(['user', 'items.product', 'items.variant.size', 'items.variant.color']);

        return view('dashboard.pages.orders.show', compact('order'));
    }

    /**
     * Toggle the paid status of an order.
     */
    public function togglePaidStatus(Order $order): RedirectResponse
    {
        $order->is_paid = !$order->is_paid;
        $order->save();

        $status = $order->is_paid ? 'marked as paid' : 'marked as unpaid';

        return redirect()->route('dashboard.orders.show', $order)
            ->with('success', "Order {$order->order_number} has been {$status}.");
    }
}
