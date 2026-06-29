@extends('layouts.admin')

@section('title', 'Product Detail')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start gap-3 mb-4">
            <div>
                <h1 class="h3 mb-2">{{ $product->name }}</h1>
                <p class="text-muted mb-0">Product details and inventory information.</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 280px;">
                        <span class="text-muted">No image</span>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <p><strong>Category:</strong> {{ $product->category?->name ?? 'Uncategorized' }}</p>
                <p><strong>SKU:</strong> {{ $product->sku ?? '-' }}</p>
                <p><strong>Price:</strong> ${{ number_format((float) $product->price, 2) }}</p>
                <p><strong>Compare Price:</strong> {{ $product->compare_price ? '$'.number_format((float) $product->compare_price, 2) : '-' }}</p>
                <p><strong>Stock Quantity:</strong> {{ $product->stock_quantity }}</p>
                <p><strong>Status:</strong> {{ ucfirst($product->status) }}</p>
                <p><strong>Featured:</strong> {{ $product->featured ? 'Yes' : 'No' }}</p>
                <p><strong>Views:</strong> {{ $product->views }}</p>
                <p class="mb-0"><strong>Description:</strong><br>{{ $product->description ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
