<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of orders.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order.
     */
    public function create()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'products'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
            'status' => 'required|in:pending,processing,completed,cancelled',
            'shipping_address' => 'required|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'nullable|array',
            'items.*.product_id' => 'required_with:items|exists:products,id',
            'items.*.quantity' => 'required_with:items|integer|min:1',
            'items.*.price' => 'required_with:items|numeric|min:0'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Generate order number
            $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(uniqid());

            // Create order
            $order = Order::create([
                'user_id' => $request->user_id,
                'order_number' => $orderNumber,
                'total_amount' => $request->total_amount,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'shipping_cost' => $request->shipping_cost ?? 0,
                'status' => $request->status,
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'notes' => $request->notes
            ]);

            // If items provided, create order items
            if ($request->has('items') && is_array($request->items)) {
                foreach ($request->items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }
            }

            DB::commit();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order created successfully',
                    'data' => $order->load('items')
                ], 201);
            }

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order created successfully! Order #' . $orderNumber);

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create order: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to create order: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified order.
     */
    public function edit(Order $order)
    {
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];
        return view('admin.orders.edit', compact('order', 'statuses', 'paymentStatuses'));
    }

    /**
     * Update the specified order.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'sometimes|in:pending,processing,completed,cancelled',
            'payment_status' => 'sometimes|in:pending,paid,failed,refunded',
            'shipping_address' => 'sometimes|string|max:500',
            'billing_address' => 'nullable|string|max:500',
            'total_amount' => 'sometimes|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        try {
            $order->update($request->all());

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order updated successfully',
                    'data' => $order
                ]);
            }

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order updated successfully!');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update order: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to update order: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified order.
     */
    public function destroy(Request $request, Order $order)
    {
        try {
            // Delete order items first
            $order->items()->delete();
            $order->delete();

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Order deleted successfully'
                ]);
            }

            return redirect()->route('admin.orders.index')
                ->with('success', 'Order deleted successfully!');

        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete order: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Failed to delete order: ' . $e->getMessage());
        }
    }

    /**
     * Update order status.
     */
    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($data);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully',
                'data' => $order
            ]);
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order status updated successfully.');
    }

    /**
     * Cancel order.
     */
    public function cancel(Request $request, Order $order)
    {
        if ($order->status === 'completed') {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot cancel completed order'
                ], 400);
            }
            return back()->with('error', 'Cannot cancel completed order');
        }

        $order->status = 'cancelled';
        $order->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => $order
            ]);
        }

        return back()->with('success', 'Order cancelled successfully!');
    }

    /**
     * Refund order.
     */
    public function refund(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|max:' . $order->total_amount
        ]);

        if ($order->payment_status !== 'paid') {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot refund unpaid order'
                ], 400);
            }
            return back()->with('error', 'Cannot refund unpaid order');
        }

        $order->payment_status = 'refunded';
        $order->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Order refunded successfully',
                'data' => $order
            ]);
        }

        return back()->with('success', 'Order refunded successfully!');
    }

    /**
     * Generate invoice.
     */
    public function generateInvoice(Request $request, Order $order)
    {
        $order->load(['user', 'items.product']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $order
            ]);
        }

        return view('admin.orders.invoice', compact('order'));
    }

    /**
     * Send order email.
     */
    public function sendEmail(Request $request, Order $order)
    {
        // Send email logic here
        // Mail::to($order->user->email)->send(new OrderConfirmation($order));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Email sent successfully'
            ]);
        }

        return back()->with('success', 'Email sent successfully!');
    }

    /**
     * Export orders.
     */
    public function export(Request $request)
    {
        $orders = Order::with('user')->get();
        
        // Export logic here (CSV, Excel, etc.)
        
        return response()->json([
            'success' => true,
            'message' => 'Export functionality',
            'data' => $orders
        ]);
    }

    /**
     * Filter orders.
     */
    public function filter(Request $request)
    {
        $query = Order::with('user');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && $request->payment_status) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('min_amount') && $request->min_amount) {
            $query->where('total_amount', '>=', $request->min_amount);
        }

        if ($request->has('max_amount') && $request->max_amount) {
            $query->where('total_amount', '<=', $request->max_amount);
        }

        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }
}