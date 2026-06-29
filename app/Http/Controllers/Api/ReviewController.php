<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Get product reviews
     */
    public function index(Product $product)
    {
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }

    /**
     * Create review
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You already reviewed this product',
            ], 422);
        }

        // Check if user purchased this product
        $hasPurchased = $request->user()->orders()
            ->whereHas('items', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        $review = Review::create([
            'user_id' => $request->user()->id,
            'product_id' => $product->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'verified_purchase' => $hasPurchased,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted',
            'data' => $review->load('user'),
        ], 201);
    }

    /**
     * Update review
     */
    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10',
        ]);

        $review->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Review updated',
            'data' => $review,
        ]);
    }

    /**
     * Delete review
     */
    public function destroy(Request $request, Review $review)
    {
        if ($review->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review deleted',
        ]);
    }
}