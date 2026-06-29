@extends('layouts.admin')

@section('title', 'Notifications')

@section('content')
<div class="notifications-page">
    <div class="page-header">
        <div>
            <span class="section-tag">Admin Alerts</span>
            <h2 class="section-title">
                <i class="fas fa-bell section-title-icon"></i> Notifications
            </h2>
            <p class="section-subtitle">Track new orders and other admin alerts in one place</p>
        </div>

        @if(($notifications->whereNull('read_at')->count() ?? 0) > 0)
            <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST">
                @csrf
                <button type="submit" class="btn-primary">
                    <i class="fas fa-check-double"></i> Mark All Read
                </button>
            </form>
        @endif
    </div>

    <div class="notification-summary">
        <div class="summary-card">
            <span class="summary-label">Total</span>
            <span class="summary-value">{{ $notifications->total() }}</span>
        </div>
        <div class="summary-card">
            <span class="summary-label">Unread</span>
            <span class="summary-value">{{ $notifications->whereNull('read_at')->count() }}</span>
        </div>
    </div>

    <div class="notification-list-page">
        @forelse($notifications as $notification)
            @php
                $isUnread = is_null($notification->read_at);
            @endphp
            <a href="{{ route('admin.notifications.show', $notification->id) }}" class="notification-card {{ $isUnread ? 'unread' : 'read' }}">
                <div class="notification-card-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="notification-card-content">
                    <div class="notification-card-top">
                        <h4>{{ $notification->data['title'] ?? 'New Notification' }}</h4>
                        <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="notification-card-message">{{ $notification->data['message'] ?? 'You have a new update.' }}</p>
                    <div class="notification-card-meta">
                        <span>Order: #{{ $notification->data['order_number'] ?? 'N/A' }}</span>
                        <span>Total: ${{ number_format((float) ($notification->data['total_amount'] ?? 0), 2) }}</span>
                    </div>
                </div>
                <div class="notification-card-action">
                    <i class="fas fa-angle-right"></i>
                </div>
            </a>
        @empty
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-bell-slash"></i></div>
                <h4>No notifications yet</h4>
                <p class="empty-text">New order alerts will appear here automatically.</p>
            </div>
        @endforelse
    </div>

    <div class="pagination-wrapper">
        {{ $notifications->links('pagination::bootstrap-5') }}
    </div>
</div>

@push('styles')
<style>
    .notifications-page {
        padding: 0;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
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

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.7rem 1.4rem;
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(253, 121, 168, 0.25);
        cursor: pointer;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(253, 121, 168, 0.35);
        color: white;
    }

    .notification-summary {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }

    .summary-card {
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.04);
        border-radius: 16px;
        padding: 18px 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    }

    .summary-label {
        display: block;
        color: #6c7a89;
        font-size: 0.85rem;
        margin-bottom: 6px;
    }

    .summary-value {
        font-size: 1.6rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    .notification-list-page {
        display: grid;
        gap: 12px;
    }

    .notification-card {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 20px;
        background: white;
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        text-decoration: none;
        color: inherit;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
        transition: all 0.25s ease;
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(0, 0, 0, 0.06);
        color: inherit;
    }

    .notification-card.unread {
        border-color: rgba(253, 121, 168, 0.25);
        background: linear-gradient(180deg, rgba(253, 121, 168, 0.05), #fff);
    }

    .notification-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .notification-card-content {
        flex: 1;
        min-width: 0;
    }

    .notification-card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 12px;
    }

    .notification-card-top h4 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    .notification-time {
        font-size: 0.78rem;
        color: #94a3b8;
        flex-shrink: 0;
    }

    .notification-card-message {
        margin: 8px 0 10px;
        color: #4b5563;
        font-size: 0.92rem;
    }

    .notification-card-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        font-size: 0.8rem;
        color: #6c7a89;
    }

    .notification-card-action {
        color: #cbd5e1;
        font-size: 1.1rem;
    }

    .empty-state {
        text-align: center;
        padding: 64px 20px;
        background: white;
        border-radius: 16px;
        border: 1px dashed #e2e8f0;
    }

    .empty-icon {
        font-size: 2.5rem;
        color: #cbd5e1;
        margin-bottom: 14px;
    }

    .empty-state h4 {
        margin-bottom: 8px;
        color: #1a1a2e;
    }

    .empty-text {
        color: #6c7a89;
        margin: 0;
    }

    .pagination-wrapper {
        margin-top: 18px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .notification-summary {
            grid-template-columns: 1fr;
        }

        .notification-card {
            align-items: flex-start;
        }

        .notification-card-top {
            flex-direction: column;
        }

        .notification-card-action {
            display: none;
        }
    }
</style>
@endpush
@endsection
