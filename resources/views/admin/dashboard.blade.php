@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-wrapper">
    <div class="bg-elements">
        <span class="bg-element">🌸</span>
        <span class="bg-element">💄</span>
        <span class="bg-element">✨</span>
        <span class="bg-element">🌺</span>
        <span class="bg-element">💫</span>
        <span class="bg-element">🦋</span>
        <span class="bg-element">🌹</span>
        <span class="bg-element">💖</span>
        <span class="bg-element">🌟</span>
        <span class="bg-element">🌷</span>
        <span class="bg-element">🌻</span>
        <span class="bg-element">💎</span>
        <span class="bg-element">🌈</span>
        <span class="bg-element">🪷</span>
        <span class="bg-element">🌿</span>
        <span class="bg-element">🌸</span>
        <span class="bg-element">💄</span>
        <span class="bg-element">✨</span>
        <span class="bg-element">🌺</span>
        <span class="bg-element">💫</span>
    </div>
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="welcome-content">
            <div>
                <h2 class="welcome-title">👋 Welcome back, {{ Auth::user()->name }}!</h2>
                <p class="welcome-subtitle">Here's what's happening with your store today</p>
            </div>
            <div class="welcome-date">
                <i class="fas fa-calendar-alt me-2"></i>
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-label">Total Products</span>
                <h3 class="stat-value">{{ $stats['products'] ?? 0 }}</h3>
                <span class="stat-trend stat-trend-up">
                    <i class="fas fa-arrow-up"></i> 12% this month
                </span>
            </div>
        </div>

        <div class="stat-card stat-card-success">
            <div class="stat-card-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-label">Total Orders</span>
                <h3 class="stat-value">{{ $stats['orders'] ?? 0 }}</h3>
                <span class="stat-trend stat-trend-up">
                    <i class="fas fa-arrow-up"></i> 8% this month
                </span>
            </div>
        </div>

        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-label">Total Revenue</span>
                <h3 class="stat-value">${{ number_format($stats['revenue'] ?? 0, 2) }}</h3>
                <span class="stat-trend stat-trend-up">
                    <i class="fas fa-arrow-up"></i> 23% this month
                </span>
            </div>
        </div>

        <div class="stat-card stat-card-info">
            <div class="stat-card-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-card-content">
                <span class="stat-label">Total Users</span>
                <h3 class="stat-value">{{ $stats['users'] ?? 0 }}</h3>
                <span class="stat-trend stat-trend-up">
                    <i class="fas fa-arrow-up"></i> 5% this month
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="dashboard-grid">
        <!-- Recent Orders Section -->
        <div class="dashboard-card recent-orders-card">
            <div class="card-header-custom">
                <div class="card-header-left">
                    <i class="fas fa-clock me-2 text-primary"></i>
                    <h5 class="card-title mb-0">Recent Orders</h5>
                    <span class="badge bg-primary ms-2">{{ count($recentOrders ?? []) }}</span>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary view-all-btn">
                    View All <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Order</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>
                                <span class="order-number">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="customer-info">
                                    <span class="customer-name">{{ $order->user->name ?? 'N/A' }}</span>
                                    <small class="customer-email">{{ $order->user->email ?? '' }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="order-amount">${{ number_format($order->total_amount ?? 0, 2) }}</span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusColor = $statusColors[$order->status ?? 'pending'] ?? 'secondary';
                                @endphp
                                <span class="status-badge status-{{ $statusColor }}">
                                    <span class="status-dot"></span>
                                    {{ ucfirst($order->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <div class="date-info">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <small class="date-time">{{ $order->created_at->format('h:i A') }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-icon btn-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
                                    <p class="text-muted mb-0">No orders found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions & Side Info -->
        <div class="dashboard-sidebar">
            <!-- Quick Actions -->
            <div class="dashboard-card quick-actions-card">
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <i class="fas fa-bolt me-2 text-warning"></i>
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                </div>
                <div class="quick-actions-grid">
                    <a href="{{ route('admin.products.create') }}" class="quick-action-btn">
                        <i class="fas fa-plus-circle text-primary"></i>
                        <span>Add Product</span>
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="quick-action-btn">
                        <i class="fas fa-plus-circle text-success"></i>
                        <span>Add Category</span>
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="quick-action-btn">
                        <i class="fas fa-list-ul text-info"></i>
                        <span>All Orders</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="quick-action-btn">
                        <i class="fas fa-users text-secondary"></i>
                        <span>Manage Users</span>
                    </a>
                </div>
            </div>

            <!-- Store Statistics -->
            <div class="dashboard-card store-stats-card">
                <div class="card-header-custom">
                    <div class="card-header-left">
                        <i class="fas fa-chart-pie me-2 text-success"></i>
                        <h5 class="card-title mb-0">Store Summary</h5>
                    </div>
                </div>
                <div class="store-stats-list">
                    <div class="stat-item">
                        <div class="stat-item-icon bg-primary-soft">
                            <i class="fas fa-box-open text-primary"></i>
                        </div>
                        <div class="stat-item-content">
                            <span class="stat-item-label">Products</span>
                            <span class="stat-item-value">{{ $stats['products'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-item-icon bg-success-soft">
                            <i class="fas fa-shopping-bag text-success"></i>
                        </div>
                        <div class="stat-item-content">
                            <span class="stat-item-label">Orders</span>
                            <span class="stat-item-value">{{ $stats['orders'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-item-icon bg-warning-soft">
                            <i class="fas fa-users text-warning"></i>
                        </div>
                        <div class="stat-item-content">
                            <span class="stat-item-label">Customers</span>
                            <span class="stat-item-value">{{ $stats['users'] ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-item-icon bg-danger-soft">
                            <i class="fas fa-dollar-sign text-danger"></i>
                        </div>
                        <div class="stat-item-content">
                            <span class="stat-item-label">Revenue</span>
                            <span class="stat-item-value">${{ number_format($stats['revenue'] ?? 0, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logout Button -->
            <div class="dashboard-card logout-card">
                <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt me-2"></i>
                        Sign Out
                        <span class="logout-hint">Secure logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Dashboard Wrapper */
.dashboard-wrapper {
    padding: 0;
}
.bg-elements {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
  z-index: 0;
  overflow: hidden;
}

.bg-element {
  position: absolute;
  font-size: 2rem;
  animation: floatBg 15s ease-in-out infinite;
  opacity: 0.06;
}

/* 20 Unique Positioned Elements */
.bg-element:nth-child(1) { 
  top: 3%; 
  left: 5%; 
  animation-delay: 0s; 
}

.bg-element:nth-child(2) { 
  top: 8%; 
  right: 8%; 
  animation-delay: 1.5s; 
  font-size: 3.5rem; 
}

.bg-element:nth-child(3) { 
  top: 15%; 
  left: 15%; 
  animation-delay: 3s; 
  font-size: 2.5rem; 
}

.bg-element:nth-child(4) { 
  top: 20%; 
  right: 20%; 
  animation-delay: 4.5s; 
  font-size: 4rem; 
}

.bg-element:nth-child(5) { 
  top: 30%; 
  left: 3%; 
  animation-delay: 6s; 
  font-size: 2.8rem; 
}

.bg-element:nth-child(6) { 
  top: 35%; 
  right: 3%; 
  animation-delay: 7.5s; 
  font-size: 3.2rem; 
}

.bg-element:nth-child(7) { 
  top: 45%; 
  left: 12%; 
  animation-delay: 9s; 
  font-size: 2.2rem; 
}

.bg-element:nth-child(8) { 
  top: 50%; 
  right: 12%; 
  animation-delay: 10.5s; 
  font-size: 3.8rem; 
}

.bg-element:nth-child(9) { 
  top: 58%; 
  left: 4%; 
  animation-delay: 12s; 
  font-size: 2.6rem; 
}

.bg-element:nth-child(10) { 
  top: 62%; 
  right: 4%; 
  animation-delay: 13.5s; 
  font-size: 3rem; 
}

.bg-element:nth-child(11) { 
  top: 70%; 
  left: 18%; 
  animation-delay: 1s; 
  font-size: 2.4rem; 
}

.bg-element:nth-child(12) { 
  top: 75%; 
  right: 18%; 
  animation-delay: 2.5s; 
  font-size: 3.6rem; 
}

.bg-element:nth-child(13) { 
  top: 82%; 
  left: 6%; 
  animation-delay: 4s; 
  font-size: 2.9rem; 
}

.bg-element:nth-child(14) { 
  top: 88%; 
  right: 6%; 
  animation-delay: 5.5s; 
  font-size: 3.3rem; 
}

.bg-element:nth-child(15) { 
  top: 93%; 
  left: 14%; 
  animation-delay: 7s; 
  font-size: 2.7rem; 
}

.bg-element:nth-child(16) { 
  top: 5%; 
  left: 50%; 
  animation-delay: 8.5s; 
  font-size: 2.1rem; 
}

.bg-element:nth-child(17) { 
  top: 25%; 
  right: 50%; 
  animation-delay: 10s; 
  font-size: 3.4rem; 
}

.bg-element:nth-child(18) { 
  top: 48%; 
  left: 50%; 
  animation-delay: 11.5s; 
  font-size: 2.3rem; 
}

.bg-element:nth-child(19) { 
  top: 68%; 
  right: 50%; 
  animation-delay: 13s; 
  font-size: 3.1rem; 
}

.bg-element:nth-child(20) { 
  top: 90%; 
  left: 50%; 
  animation-delay: 14.5s; 
  font-size: 2.5rem; 
}

/* Animation */
@keyframes floatBg {
  0%, 100% { 
    transform: translateY(0px) rotate(0deg) scale(1); 
  }
  25% { 
    transform: translateY(-40px) rotate(5deg) scale(1.1); 
  }
  75% { 
    transform: translateY(40px) rotate(-5deg) scale(0.9); 
  }
}
/* Different animation speeds for each element */
.bg-element:nth-child(1) { animation-duration: 18s; }
.bg-element:nth-child(2) { animation-duration: 14s; }
.bg-element:nth-child(3) { animation-duration: 20s; }
.bg-element:nth-child(4) { animation-duration: 16s; }
.bg-element:nth-child(5) { animation-duration: 22s; }
.bg-element:nth-child(6) { animation-duration: 13s; }
.bg-element:nth-child(7) { animation-duration: 19s; }
.bg-element:nth-child(8) { animation-duration: 17s; }
.bg-element:nth-child(9) { animation-duration: 21s; }
.bg-element:nth-child(10) { animation-duration: 15s; }
.bg-element:nth-child(11) { animation-duration: 23s; }
.bg-element:nth-child(12) { animation-duration: 12s; }
.bg-element:nth-child(13) { animation-duration: 20s; }
.bg-element:nth-child(14) { animation-duration: 18s; }
.bg-element:nth-child(15) { animation-duration: 16s; }
.bg-element:nth-child(16) { animation-duration: 14s; }
.bg-element:nth-child(17) { animation-duration: 22s; }
.bg-element:nth-child(18) { animation-duration: 19s; }
.bg-element:nth-child(19) { animation-duration: 15s; }
.bg-element:nth-child(20) { animation-duration: 17s; }


/* Welcome Section */
.welcome-section {
    background: linear-gradient(135deg, #fd79a8 0%, #e17055 100%);
    border-radius: 16px;
    padding: 30px 35px;
    margin-bottom: 10px;
    color: white;
    box-shadow: 0 4px 20px rgba(253, 121, 168, 0.3);
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
}

.welcome-title {
    font-size: 24px;
    font-weight: 600;
    margin: 0 0 5px 0;
}

.welcome-subtitle {
    margin: 0;
    opacity: 0.9;
    font-size: 14px;
}

.welcome-date {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 18px;
    border-radius: 20px;
    font-size: 14px;
    backdrop-filter: blur(10px);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 10px;
    margin-bottom: 10px;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
    border: 1px solid rgba(253, 121, 168, 0.06);
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(253, 121, 168, 0.12);
    border-color: #fd79a8;
}

.stat-card-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}

.stat-card-primary .stat-card-icon {
    background: rgba(253, 121, 168, 0.1);
    color: #fd79a8;
}

.stat-card-success .stat-card-icon {
    background: rgba(46, 204, 113, 0.1);
    color: #2ecc71;
}

.stat-card-warning .stat-card-icon {
    background: rgba(241, 196, 15, 0.1);
    color: #f1c40f;
}

.stat-card-info .stat-card-icon {
    background: rgba(52, 152, 219, 0.1);
    color: #3498db;
}

.stat-card-content {
    flex: 1;
}

.stat-label {
    font-size: 13px;
    color: #7f8c8d;
    font-weight: 500;
    display: block;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    color: #2c3e50;
}

.stat-trend {
    font-size: 12px;
    font-weight: 500;
    display: inline-block;
    margin-top: 4px;
}

.stat-trend-up {
    color: #2ecc71;
}

.stat-trend-down {
    color: #e74c3c;
}

/* Dashboard Grid */
.dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
}

/* Dashboard Card */
.dashboard-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
    border: 1px solid rgba(253, 121, 168, 0.06);
    overflow: hidden;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 8px 24px rgba(253, 121, 168, 0.08);
    border-color: #fd79a8;
}

.card-header-custom {
    padding: 18px 24px;
    border-bottom: 1px solid rgba(253, 121, 168, 0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafafa;
}

.card-header-left {
    display: flex;
    align-items: center;
}

.card-title {
    font-weight: 600;
    font-size: 16px;
    color: #2c3e50;
}

.view-all-btn {
    font-size: 13px;
    padding: 4px 14px;
    border-radius: 20px;
    border-color: #fd79a8;
    color: #fd79a8;
}

.view-all-btn:hover {
    background: linear-gradient(135deg, #fd79a8, #e17055);
    color: white;
    border-color: #fd79a8;
}

/* Custom Table */
.custom-table {
    margin: 0;
    font-size: 14px;
}

.custom-table thead th {
    background: transparent;
    font-weight: 600;
    color: #7f8c8d;
    border-bottom: 2px solid #f0f0f0;
    padding: 12px 16px;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.custom-table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f5f5f5;
}

.custom-table tbody tr:hover {
    background: #fafafa;
}

.order-number {
    font-weight: 600;
    color: #2c3e50;
    font-size: 13px;
}

.customer-info {
    display: flex;
    flex-direction: column;
}

.customer-name {
    font-weight: 500;
    color: #2c3e50;
}

.customer-email {
    color: #95a5a6;
    font-size: 12px;
}

.order-amount {
    font-weight: 600;
    color: #2c3e50;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    background: #f0f0f0;
    color: #7f8c8d;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    display: inline-block;
}

.status-warning {
    background: #fef9e7;
    color: #f39c12;
}

.status-warning .status-dot {
    background: #f39c12;
}

.status-success {
    background: #eafaf1;
    color: #27ae60;
}

.status-success .status-dot {
    background: #27ae60;
}

.status-info {
    background: #ebf5fb;
    color: #3498db;
}

.status-info .status-dot {
    background: #3498db;
}

.status-danger {
    background: #fdedec;
    color: #e74c3c;
}

.status-danger .status-dot {
    background: #e74c3c;
}

.date-info {
    display: flex;
    flex-direction: column;
}

.date-time {
    color: #95a5a6;
    font-size: 11px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    padding: 0;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-icon.btn-primary {
    background: rgba(253, 121, 168, 0.1);
    color: #fd79a8;
}

.btn-icon.btn-primary:hover {
    background: linear-gradient(135deg, #fd79a8, #e17055);
    color: white;
}

/* Empty State */
.empty-state {
    padding: 40px 20px;
    text-align: center;
}

/* Quick Actions */
.quick-actions-card .card-body {
    padding: 20px 24px;
}

.quick-actions-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    padding: 16px 20px;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    background: #f8f9fa;
    border-radius: 10px;
    color: #2c3e50;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.quick-action-btn:hover {
    background: white;
    border-color: #fd79a8;
    box-shadow: 0 2px 8px rgba(253, 121, 168, 0.06);
    color: #fd79a8;
    transform: translateY(-2px);
}

.quick-action-btn i {
    font-size: 18px;
}

.quick-action-btn span {
    font-size: 13px;
    font-weight: 500;
}

/* Store Stats */
.store-stats-card .card-body {
    padding: 16px 20px;
}

.store-stats-list {
    padding: 16px 20px;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 10px 14px;
    background: #f8f9fa;
    border-radius: 10px;
    transition: all 0.2s ease;
}

.stat-item:hover {
    background: #f0f0f0;
}

.stat-item-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.bg-primary-soft {
    background: rgba(253, 121, 168, 0.1);
}

.bg-success-soft {
    background: rgba(46, 204, 113, 0.1);
}

.bg-warning-soft {
    background: rgba(241, 196, 15, 0.1);
}

.bg-danger-soft {
    background: rgba(231, 76, 60, 0.1);
}

.stat-item-content {
    flex: 1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.stat-item-label {
    font-size: 13px;
    color: #7f8c8d;
}

.stat-item-value {
    font-weight: 600;
    color: #2c3e50;
    font-size: 15px;
}

/* Logout Card */
.logout-card {
    background: transparent;
    border: none;
    box-shadow: none;
}

.logout-form {
    width: 100%;
}

.logout-btn {
    width: 100%;
    padding: 14px 20px;
    border: none;
    border-radius: 12px;
    background: linear-gradient(135deg, #e74c3c, #c0392b);
    color: white;
    font-weight: 600;
    font-size: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
}

.logout-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(231, 76, 60, 0.4);
}

.logout-btn:active {
    transform: translateY(0);
}

.logout-hint {
    font-size: 11px;
    opacity: 0.7;
    font-weight: 400;
}

/* Responsive */
@media (max-width: 1200px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .welcome-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }

    .quick-actions-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 16px 20px;
    }

    .custom-table {
        font-size: 13px;
    }

    .custom-table thead th,
    .custom-table tbody td {
        padding: 8px 12px;
    }
}
</style>
@endpush
@endsection