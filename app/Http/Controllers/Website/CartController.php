<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Get cart items
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            $product = Product::with(['category', 'images'])->find($item['product_id']);

            if (!$product || !$product->is_active) {
                continue;
            }

            $variant = null;
            if (isset($item['variant_id'])) {
                $variant = ProductVariant::with(['size', 'color'])->find($item['variant_id']);
            }

            $price = $variant && $variant->price ? $variant->price : ($product->min_price ?? 0);
            $quantity = $item['quantity'] ?? 1;
            $itemTotal = $price * $quantity;

            $cartItems[] = [
                'key' => $key,
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $itemTotal,
            ];

            $subtotal += $itemTotal;
        }

        $total = $subtotal; // Can add shipping, tax, etc. later

        return view('website.cart.index', compact('cartItems', 'subtotal', 'total'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available.'
            ], 400);
        }

        // Check variant if provided
        if ($request->variant_id) {
            $variant = ProductVariant::findOrFail($request->variant_id);
            if (!$variant->is_active || $variant->product_id != $product->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Selected variant is not available.'
                ], 400);
            }

            // Check stock
            if ($variant->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $variant->stock . ' available.'
                ], 400);
            }
        }

        $cart = Session::get('cart', []);
        $cartKey = $request->variant_id
            ? $request->product_id . '_' . $request->variant_id
            : $request->product_id;

        // Check if item already exists in cart
        if (isset($cart[$cartKey])) {
            $newQuantity = $cart[$cartKey]['quantity'] + $request->quantity;

            // Check stock if variant
            if ($request->variant_id && $variant->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $variant->stock . ' available.'
                ], 400);
            }

            $cart[$cartKey]['quantity'] = $newQuantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
            ];
        }

        Session::put('cart', $cart);

        $cartCount = count($cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully!',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $key)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('cart', []);

        if (!isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ], 404);
        }

        $item = $cart[$key];

        // Check stock if variant
        if (isset($item['variant_id'])) {
            $variant = ProductVariant::find($item['variant_id']);
            if ($variant && $variant->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Only ' . $variant->stock . ' available.'
                ], 400);
            }
        }

        $cart[$key]['quantity'] = $request->quantity;
        Session::put('cart', $cart);

        // Calculate item total
        $product = Product::find($item['product_id']);
        $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;
        $price = $variant && $variant->price ? $variant->price : ($product->min_price ?? 0);
        $itemTotal = $price * $request->quantity;

        // Calculate cart totals
        $subtotal = 0;
        foreach ($cart as $cartItem) {
            $cartProduct = Product::find($cartItem['product_id']);
            $cartVariant = isset($cartItem['variant_id']) ? ProductVariant::find($cartItem['variant_id']) : null;
            $cartPrice = $cartVariant && $cartVariant->price ? $cartVariant->price : ($cartProduct->min_price ?? 0);
            $subtotal += $cartPrice * $cartItem['quantity'];
        }

        return response()->json([
            'success' => true,
            'item_total' => number_format($itemTotal, 2),
            'subtotal' => number_format($subtotal, 2),
            'total' => number_format($subtotal, 2),
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($key)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$key])) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ], 404);
        }

        unset($cart[$key]);
        Session::put('cart', $cart);

        $cartCount = count($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cartCount,
        ]);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully.',
        ]);
    }

    /**
     * Get cart count (for AJAX)
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        $total = 0;

        foreach ($cart as $item) {
            $count += $item['quantity'] ?? 1;
            $product = Product::find($item['product_id']);
            $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;
            $price = $variant && $variant->price ? $variant->price : ($product->min_price ?? 0);
            $total += $price * ($item['quantity'] ?? 1);
        }

        return response()->json([
            'count' => $count,
            'items' => count($cart),
            'total' => number_format($total, 2),
        ]);
    }

    /**
     * Show checkout page
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $subtotal = 0;

        foreach ($cart as $key => $item) {
            $product = Product::with(['category', 'images'])->find($item['product_id']);

            if (!$product || !$product->is_active) {
                continue;
            }

            $variant = null;
            if (isset($item['variant_id'])) {
                $variant = ProductVariant::with(['size', 'color'])->find($item['variant_id']);
            }

            $price = $variant && $variant->price ? $variant->price : ($product->min_price ?? 0);
            $quantity = $item['quantity'] ?? 1;
            $itemTotal = $price * $quantity;

            $cartItems[] = [
                'key' => $key,
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $itemTotal,
            ];

            $subtotal += $itemTotal;
        }

        $total = $subtotal; // Can add shipping, tax, etc. later

        if (count($cartItems) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = auth()->guard('web')->user();

        return view('website.cart.checkout', compact('cartItems', 'subtotal', 'total', 'user'));
    }

    /**
     * Store order from checkout
     */
    public function storeOrder(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_email' => 'required|email|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string',
            'shipping_city' => 'nullable|string|max:100',
            'shipping_state' => 'nullable|string|max:100',
            'shipping_zip' => 'nullable|string|max:20',
            'shipping_country' => 'nullable|string|max:100',
            'payment_method' => 'required|in:cash,card',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);

            if (!$product || !$product->is_active) {
                continue;
            }

            $variant = null;
            if (isset($item['variant_id'])) {
                $variant = ProductVariant::find($item['variant_id']);
                if (!$variant || !$variant->is_active) {
                    continue;
                }
                // Check stock
                if ($variant->stock < ($item['quantity'] ?? 1)) {
                    return redirect()->route('cart.checkout')
                        ->with('error', 'Insufficient stock for ' . $product->name . '. Only ' . $variant->stock . ' available.');
                }
            }

            $price = $variant && $variant->price ? $variant->price : ($product->min_price ?? 0);
            $quantity = $item['quantity'] ?? 1;
            $itemTotal = $price * $quantity;

            $cartItems[] = [
                'product' => $product,
                'variant' => $variant,
                'quantity' => $quantity,
                'price' => $price,
                'total' => $itemTotal,
            ];

            $total += $itemTotal;
        }

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $user = auth()->guard('web')->user();

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => Order::generateOrderNumber(),
                'total' => $total,
                'is_paid' => $request->payment_method === 'card', // Assuming card payments are paid immediately
                'payment_method' => $request->payment_method,
                'shipping_name' => $request->shipping_name,
                'shipping_email' => $request->shipping_email,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_zip' => $request->shipping_zip,
                'shipping_country' => $request->shipping_country,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'product_variant_id' => $item['variant']?->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);

                // Update stock if variant exists
                if ($item['variant']) {
                    $item['variant']->decrement('stock', $item['quantity']);
                }
            }

            // Clear cart
            Session::forget('cart');

            DB::commit();

            return redirect()->route('home')
                ->with('success', 'Order placed successfully! Order Number: ' . $order->order_number);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.checkout')
                ->with('error', 'Failed to place order. Please try again.');
        }
    }
}
