@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<style>
    /* Skincare-inspired styling */
    .card {
        border-radius: 16px;
        border: none;
        background: linear-gradient(145deg, #ffffff 0%, #faf8f6 100%);
        box-shadow: linear-gradient(135deg, #fd79a8, #e17055);
    }
    
    .card-body {
        padding: 2rem;
    }
    
    .form-label {
        font-weight: 500;
        color: #4a3728;
        font-size: 0.875rem;
        letter-spacing: 0.3px;
        margin-bottom: 0.4rem;
    }
    
    .form-label::after {
        content: '';
        display: block;
        width: 20px;
        height: 2px;
        background: linear-gradient(90deg, #e8d5c4, transparent);
        margin-top: 4px;
        border-radius: 2px;
    }
    
    .form-control, .form-select {
        border: 2px solid #f0ebe6;
        border-radius: 12px;
        padding: 0.6rem 1rem;
        background: white;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #d4a574;
        box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.1);
        background: white;
    }
    
    .form-control:hover, .form-select:hover {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        background: #fdfcfa;
    }
    
    .form-control::placeholder {
        color: #c5b5a5;
        font-size: 0.9rem;
    }
    
    textarea.form-control {
        border-radius: 12px;
        resize: vertical;
    }
    
    /* Title styling */
    .page-title {
        font-family: 'Georgia', serif;
        color: #4a3728;
        font-size: 1.75rem;
        font-weight: 400;
        letter-spacing: 0.5px;
        position: relative;
        padding-bottom: 15px;
        margin-bottom: 25px !important;
    }
    
    .page-title::after {
        content: '✦';
        position: absolute;
        bottom: -8px;
        left: 0;
        color: #d4a574;
        font-size: 1.2rem;
    }
    
    .page-title small {
        font-size: 0.9rem;
        color: #b5a392;
        font-weight: 300;
        display: block;
        margin-top: 4px;
        font-family: 'Segoe UI', sans-serif;
    }
    
    .page-title small::before {
        content: '💧 ';
    }
    
    /* Alert styling */
    .alert-danger {
        background: #fdf6f3;
        border: 2px solid #f5e0d8;
        border-radius: 12px;
        color: #7a4a3a;
        padding: 1rem 1.5rem;
    }
    
    .alert-danger ul {
        list-style: none;
        padding-left: 0;
    }
    
    .alert-danger li::before {
        content: '• ';
        color: #d4a574;
        font-weight: bold;
    }
    
    /* Checkbox styling */
    .form-check {
        padding-left: 0;
    }
    
    .form-check-input {
        width: 1.2em;
        height: 1.2em;
        border: 2px solid #d4c5b8;
        border-radius: 4px;
        margin-right: 8px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .form-check-input:checked {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        border-color: #d4a574;
    }
    
    .form-check-input:focus {
        box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.2);
        border-color: #d4a574;
    }
    
    .form-check-label {
        color: #4a3728;
        font-weight: 500;
        cursor: pointer;
    }
    
    .form-check-label::before {
        content: '✨ ';
        color: #d4a574;
    }
    
    /* Buttons */
    .btn-primary {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        border: none;
        border-radius: 12px;
        padding: 0.7rem 2.5rem;
        color: #4a3728;
        font-weight: 600;
        transition: all 0.3s ease;
        letter-spacing: 0.5px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(212, 165, 116, 0.3);
        background: linear-gradient(135deg, #dcc4b0 0%, #c9966a 100%);
        color: #3a2a1a;
    }
    
    .btn-primary:active {
        transform: scale(0.98);
    }
    
    .btn-secondary {
        background: #f5f0eb;
        border: 2px solid #e8ddd5;
        border-radius: 12px;
        padding: 0.7rem 2rem;
        color: #7a6a5a;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-secondary:hover {
        background: #ede5dd;
        border-color: #d4c5b8;
        color: #4a3728;
        transform: translateY(-2px);
    }
    
    /* Small decorative elements */
    .field-icon {
        display: none;
    }
    
    /* Responsive touch */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
    }
    
    /* Select dropdown styling */
    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23d4a574' stroke-width='2' fill='none'/%3E%3C/svg%3E");
        background-size: 12px;
        background-position: right 1rem center;
        background-repeat: no-repeat;
        appearance: none;
        -webkit-appearance: none;
    }
    
    /* File input styling */
    input[type="file"] {
        padding: 0.5rem;
        background: #fdfcfa;
        border: 2px dashed #e8ddd5;
        border-radius: 12px;
        cursor: pointer;
    }
    
    input[type="file"]::file-selector-button {
        background: #f5f0eb;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 1.2rem;
        color: #4a3728;
        font-weight: 500;
        margin-right: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    input[type="file"]::file-selector-button:hover {
        background: #e8ddd5;
    }
    
    /* Number input arrows */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        opacity: 0.5;
        height: 30px;
    }
    
    /* Row spacing enhancement */
    .row.g-3 {
        --bs-gutter-y: 1.2rem;
    }
    
    /* Gap between buttons */
    .d-flex.gap-2 {
        gap: 1rem !important;
        margin-top: 0.5rem;
    }
</style>

<div class="card shadow-sm">
    <div class="card-body">
        <h1 class="page-title h3 mb-4">
            Add Product
            <small>Create a new skincare product</small>
        </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Product Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g., Hydrating Serum" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}" placeholder="e.g., SKU-001">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" min="0" name="price" class="form-control" value="{{ old('price') }}" placeholder="29.99" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Compare Price</label>
                    <input type="number" step="0.01" min="0" name="compare_price" class="form-control" value="{{ old('compare_price') }}" placeholder="39.99">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Stock</label>
                    <input type="number" min="0" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', 0) }}" placeholder="0" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="active" @selected(old('status', 'active') === 'active')>● Active</option>
                        <option value="inactive" @selected(old('status') === 'inactive')>○ Inactive</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="5" class="form-control" placeholder="Describe your product's benefits, ingredients, and usage...">{{ old('description') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Product Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
                <div class="col-md-6 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="featured" value="1" id="featured">
                        <label class="form-check-label" for="featured">Featured product</label>
                    </div>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">✦ Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection