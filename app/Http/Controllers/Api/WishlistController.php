<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        $wishlist = $request->user()
            ->wishlist()
            ->with('product')
            ->get();

        return response()->json($wishlist);
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $wishlistItem = Wishlist::firstOrCreate([
            'user_id' => $request->user()->id,
            'product_id' => $validated['product_id'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Added to wishlist',
            'data' => $wishlistItem,
        ], 201);
    }

    /**
     * Remove from wishlist
     */
    public function destroy(Request $request, $product_id)
    {
        $wishlistItem = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $product_id)
            ->firstOrFail();

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Removed from wishlist',
        ]);
    }
}