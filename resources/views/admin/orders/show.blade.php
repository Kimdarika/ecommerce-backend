@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="order-details-page">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <span class="section-tag">Order Management</span>
            <h2 class="section-title">
                <i class="fas fa-receipt section-title-icon"></i> Order Details
            </h2>
            <p class="section-subtitle">View complete order information</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <!-- Order Summary Cards -->
    <div class="order-summary-grid">
        <!-- Order Info -->
        <div class="summary-card">
            <div class="summary-card-header">
                <i class="fas fa-receipt text-primary"></i>
                <h5>Order Information</h5>
            </div>
            <div class="summary-card-body">
                <div class="summary-item">
                    <span class="summary-label">Order Number</span>
                    <span class="summary-value order-number-display">#{{ $order->order_number }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Order Date</span>
                    <span class="summary-value">{{ optional($order->created_at)->format('F d, Y h:i A') }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Total Amount</span>
                    <span class="summary-value total-amount">${{ number_format((float) $order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="summary-card">
            <div class="summary-card-header">
                <i class="fas fa-user text-info"></i>
                <h5>Customer Information</h5>
            </div>
            <div class="summary-card-body">
                <div class="summary-item">
                    <span class="summary-label">Customer Name</span>
                    <span class="summary-value">{{ $order->user?->name ?? 'Guest' }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Email</span>
                    <span class="summary-value">{{ $order->user?->email ?? 'No email' }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Phone</span>
                    <span class="summary-value">{{ $order->user?->phone ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Status & Payment -->
        <div class="summary-card">
            <div class="summary-card-header">
                <i class="fas fa-info-circle text-warning"></i>
                <h5>Status & Payment</h5>
            </div>
            <div class="summary-card-body">
                <div class="summary-item">
                    <span class="summary-label">Order Status</span>
                    <span class="summary-value">
                        @php
                            $statusColors = [
                                'pending' => 'status-pending',
                                'processing' => 'status-processing',
                                'completed' => 'status-completed',
                                'cancelled' => 'status-cancelled'
                            ];
                            $statusColor = $statusColors[$order->status] ?? 'status-pending';
                        @endphp
                        <span class="status-badge {{ $statusColor }}">
                            <span class="status-dot"></span>
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Payment Status</span>
                    <span class="summary-value">
                        @php
                            $paymentColors = [
                                'pending' => 'payment-pending',
                                'paid' => 'payment-paid',
                                'failed' => 'payment-failed',
                                'refunded' => 'payment-refunded'
                            ];
                            $paymentColor = $paymentColors[$order->payment_status] ?? 'payment-pending';
                        @endphp
                        <span class="payment-badge {{ $paymentColor }}">
                            {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                        </span>
                    </span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Payment Method</span>
                    <span class="summary-value">{{ ucfirst($order->payment_method ?? 'N/A') }}</span>
                </div>
            </div>
        </div>

        <!-- Shipping Info -->
        <div class="summary-card">
            <div class="summary-card-header">
                <i class="fas fa-truck text-success"></i>
                <h5>Shipping Information</h5>
            </div>
            <div class="summary-card-body">
                <div class="summary-item">
                    <span class="summary-label">Shipping Address</span>
                    <span class="summary-value">{{ $order->shipping_address ?? 'N/A' }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Shipping Cost</span>
                    <span class="summary-value">${{ number_format((float) ($order->shipping_cost ?? 0), 2) }}</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Discount</span>
                    <span class="summary-value">${{ number_format((float) ($order->discount ?? 0), 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-header-left">
                <span class="table-count">Order Items ({{ $order->items->count() }})</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td>
                            <span class="item-number">{{ $index + 1 }}</span>
                        </td>
                        <td>
                            <div class="product-info">
                                @if($item->product?->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="product-thumbnail">
                                @else
                                    <div class="product-thumbnail-placeholder">
                                        <i class="fas fa-box"></i>
                                    </div>
                                @endif
                                <span class="product-name">{{ $item->product?->name ?? 'Product Deleted' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="product-sku">{{ $item->product?->sku ?? 'N/A' }}</span>
                        </td>
                        <td>
                            <span class="quantity-badge">{{ $item->quantity }}</span>
                        </td>
                        <td>
                            <span class="unit-price">${{ number_format((float) $item->price, 2) }}</span>
                        </td>
                        <td>
                            <span class="subtotal-price">${{ number_format((float) ($item->quantity * $item->price), 2) }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end"><strong>Subtotal:</strong></td>
                        <td><strong>${{ number_format((float) $order->items->sum(function($item) { return $item->quantity * $item->price; }), 2) }}</strong></td>
                    </tr>
                    @if($order->discount > 0)
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end"><strong>Discount:</strong></td>
                        <td><strong class="text-danger">-${{ number_format((float) $order->discount, 2) }}</strong></td>
                    </tr>
                    @endif
                    @if($order->shipping_cost > 0)
                    <tr>
                        <td colspan="4"></td>
                        <td class="text-end"><strong>Shipping:</strong></td>
                        <td><strong>${{ number_format((float) $order->shipping_cost, 2) }}</strong></td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td colspan="4"></td>
                        <td class="text-end"><strong>Total:</strong></td>
                        <td><strong class="total-amount-large">${{ number_format((float) $order->total_amount, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Order Notes -->
    @if($order->notes)
    <div class="notes-card">
        <div class="notes-header">
            <i class="fas fa-sticky-note text-warning"></i>
            <h5>Order Notes</h5>
        </div>
        <div class="notes-body">
            <p>{{ $order->notes }}</p>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    /* ============================================
       ORDER DETAILS PAGE - PROFESSIONAL STYLE
       ============================================ */
    .order-details-page {
        padding: 0;
    }

    /* ============================================
       PAGE HEADER
       ============================================ */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-tag {
        display: inline-block;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        color: #fd79a8;
        background: rgba(253, 121, 168, 0.1);
        padding: 0.2rem 1rem;
        border-radius: 50px;
        margin-bottom: 0.5rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .section-title-icon {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-right: 8px;
    }

    .section-subtitle {
        color: #6c7a89;
        font-size: 0.95rem;
        margin: 0.25rem 0 0;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.5rem;
        background: white;
        color: #6c7a89;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-weight: 500;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        border-color: #fd79a8;
        color: #fd79a8;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(253, 121, 168, 0.08);
    }

    /* ============================================
       ORDER SUMMARY GRID
       ============================================ */
    .order-summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .summary-card-header {
        padding: 12px 16px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .summary-card-header i {
        font-size: 1.1rem;
    }

    .summary-card-header h5 {
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
        font-size: 14px;
    }

    .summary-card-body {
        padding: 14px 16px;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 6px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-size: 13px;
        color: #6c7a89;
        font-weight: 500;
    }

    .summary-value {
        font-size: 13px;
        color: #1a1a2e;
        font-weight: 500;
    }

    .order-number-display {
        font-weight: 700;
        color: #667eea;
        font-size: 14px;
    }

    .total-amount {
        font-weight: 700;
        color: #e17055;
        font-size: 15px;
    }

    /* Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-pending .status-dot {
        background: #f59e0b;
    }

    .status-processing {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-processing .status-dot {
        background: #3b82f6;
    }

    .status-completed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-completed .status-dot {
        background: #10b981;
    }

    .status-cancelled {
        background: #fee2e2;
        color: #991b1b;
    }

    .status-cancelled .status-dot {
        background: #ef4444;
    }

    /* Payment Badges */
    .payment-badge {
        display: inline-block;
        padding: 2px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .payment-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .payment-paid {
        background: #d1fae5;
        color: #065f46;
    }

    .payment-failed {
        background: #fee2e2;
        color: #991b1b;
    }

    .payment-refunded {
        background: #e0e7ff;
        color: #3730a3;
    }

    /* ============================================
       TABLE CONTAINER
       ============================================ */
    .table-container {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .table-header {
        padding: 16px 24px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
    }

    .table-header-left {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .table-count {
        font-size: 13px;
        color: #6c7a89;
        font-weight: 500;
    }

    /* ============================================
       CUSTOM TABLE
       ============================================ */
    .custom-table {
        width: 100%;
        margin: 0;
        font-size: 14px;
        border-collapse: collapse;
    }

    .custom-table thead th {
        background: #f8f9fa;
        font-weight: 600;
        color: #6c7a89;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-bottom: 2px solid #f0f0f0;
    }

    .custom-table tbody td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .custom-table tbody tr:hover {
        background: #fafbfc;
    }

    .custom-table tfoot td {
        padding: 12px 16px;
        border-top: 2px solid #f0f0f0;
    }

    .custom-table tfoot .total-row td {
        font-size: 16px;
        padding: 16px;
        background: #f8f9fa;
        border-top: 2px solid #e2e8f0;
    }

    /* Product Info */
    .product-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .product-thumbnail {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #f0f0f0;
    }

    .product-thumbnail-placeholder {
        width: 44px;
        height: 44px;
        border-radius: 8px;
        background: #f8f9fa;
        border: 2px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1rem;
    }

    .product-name {
        font-weight: 500;
        color: #1a1a2e;
    }

    .product-sku {
        font-size: 12px;
        color: #9aa5b5;
    }

    .item-number {
        font-weight: 600;
        color: #6c7a89;
        font-size: 13px;
    }

    .quantity-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        padding: 2px 10px;
        background: #f1f3f5;
        border-radius: 20px;
        font-weight: 600;
        color: #1a1a2e;
        font-size: 13px;
    }

    .unit-price {
        font-weight: 500;
        color: #1a1a2e;
    }

    .subtotal-price {
        font-weight: 600;
        color: #1a1a2e;
    }

    .total-amount-large {
        font-size: 18px;
        font-weight: 700;
        color: #e17055;
    }

    /* ============================================
       NOTES CARD
       ============================================ */
    .notes-card {
        background: white;
        border-radius: 12px;
        border: 1px solid rgba(0, 0, 0, 0.04);
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .notes-header {
        padding: 12px 16px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .notes-header h5 {
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
        font-size: 14px;
    }

    .notes-body {
        padding: 16px 20px;
    }

    .notes-body p {
        color: #1a1a2e;
        margin: 0;
        line-height: 1.6;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1200px) {
        .order-summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .order-summary-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .custom-table {
            font-size: 13px;
        }

        .custom-table thead th,
        .custom-table tbody td,
        .custom-table tfoot td {
            padding: 8px 12px;
        }

        .product-thumbnail {
            width: 36px;
            height: 36px;
        }

        .product-thumbnail-placeholder {
            width: 36px;
            height: 36px;
        }

        .summary-card-body {
            padding: 10px 12px;
        }

        .summary-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 2px;
        }

        .total-amount-large {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .section-title {
            font-size: 1.6rem;
        }

        .order-summary-grid {
            grid-template-columns: 1fr;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush
@endsection