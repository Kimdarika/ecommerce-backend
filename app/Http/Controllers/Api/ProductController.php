<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        switch ($request->get('sort', 'latest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->orderBy('views', 'desc');
                break;
            default:
                $query->latest();
        }

        return response()->json($query->paginate($request->get('per_page', 20)));
    }

    public function show(Product $product)
    {
        $product->load(['category', 'reviews.user']);
        $product->increment('views');
        $product->average_rating = $product->reviews()->avg('rating') ?? 0;
        $product->reviews_count = $product->reviews()->count();

        return response()->json($product);
    }

    public function categories()
    {
        return response()->json(Category::withCount('products')->get());
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        if (empty($query)) {
            return response()->json(['data' => []]);
        }

        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->with('category')
            ->limit(20)
            ->get();

        return response()->json($products);
    }
}
