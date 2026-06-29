@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="h3 mb-4">Edit Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Compare Price</label>
                    <input type="number" step="0.01" min="0" name="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock Quantity</label>
                    <input type="number" min="0" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="active" @selected(old('status', $product->status) === 'active')>Active</option>
                        <option value="inactive" @selected(old('status', $product->status) === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control">
                    @if($product->image)
                        <small class="text-muted d-block mt-2">Current image:</small>
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 100px; height: 100px; object-fit: cover;" class="mt-1 rounded">
                    @endif
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured" @checked(old('featured', $product->featured))>
                        <label class="form-check-label" for="featured">Featured product</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Update Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
