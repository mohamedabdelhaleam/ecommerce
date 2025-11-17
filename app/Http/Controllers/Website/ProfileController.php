<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the user profile page.
     */
    public function index()
    {
        $user = Auth::guard('web')->user();
        return view('website.profile.index', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::guard('web')->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip = $request->zip;
        $user->country = $request->country;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the user's orders.
     */
    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id', $user->id)
            ->with(['items.product', 'items.variant.size', 'items.variant.color'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('website.profile.orders', compact('orders'));
    }

    /**
     * Show a specific order.
     */
    public function showOrder(Order $order)
    {
        $user = Auth::guard('web')->user();

        // Ensure the order belongs to the authenticated user
        if ($order->user_id !== $user->id) {
            abort(403, 'Unauthorized access.');
        }

        $order->load(['items.product', 'items.variant.size', 'items.variant.color']);

        return view('website.profile.order-details', compact('order'));
    }
}
