<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->user()->cart()->with('product')->get();

        $total = $cart->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'items' => $cart,
            'total' => $total,
            'count' => $cart->count(),
            'total_items' => $cart->sum('quantity'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $existingItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $validated['product_id'])
            ->first();
        $newQuantity = $validated['quantity'] + ($existingItem?->quantity ?? 0);

        if ($product->stock_quantity < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available',
            ], 422);
        }

        if ($existingItem) {
            $existingItem->update(['quantity' => $newQuantity]);
            $cartItem = $existingItem;
        } else {
            $cartItem = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Added to cart',
            'data' => $cartItem,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $product = Product::findOrFail($cartItem->product_id);

        if ($product->stock_quantity < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available',
            ], 422);
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated',
            'data' => $cartItem,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }

    public function clear(Request $request)
    {
        $request->user()->cart()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}
