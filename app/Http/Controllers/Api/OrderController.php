<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Get user's orders
     */
    public function index(Request $request)
    {
        $orders = $request->user()
            ->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    /**
     * Create order from cart
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'billing_address' => 'nullable|string',
            'payment_method' => 'required|string|in:cash,card,bank_transfer',
            'notes' => 'nullable|string',
        ]);

        $user = $request->user();

        $order = DB::transaction(function () use ($user, $validated) {
            $cartItems = $user->cart()->with('product')->get();

            if ($cartItems->isEmpty()) {
                abort(response()->json([
                    'success' => false,
                    'message' => 'Cart is empty',
                ], 422));
            }

            foreach ($cartItems as $item) {
                $productName = $item->product?->name ?? 'a product';

                if (! $item->product || $item->product->stock_quantity < $item->quantity) {
                    abort(response()->json([
                        'success' => false,
                        'message' => "Insufficient stock for {$productName}",
                    ], 422));
                }
            }

            // Calculate totals
            $subtotal = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });

            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;

            // Generate order number
            $orderNumber = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'total_amount' => $total,
                'discount' => 0,
                'tax' => $tax,
                'shipping_cost' => 0,
                'status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'] ?? $validated['shipping_address'],
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items and update stock
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock_quantity', $item->quantity);
            }

            // Clear cart
            $user->cart()->delete();

            return $order;
        });

        // Notify every admin that a new order has been placed
        $admins = User::where('role', 'admin')->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new NewOrderNotification($order->load('user', 'items.product')));
        }

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully',
            'order' => $order->load('items.product'),
        ], 201);
    }

    /**
     * Get order details
     */
    public function show(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('items.product')
            ->firstOrFail();

        return response()->json($order);
    }
}
