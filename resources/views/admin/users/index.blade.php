@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="users-page">
    <div class="bg-elements">
        <span class="bg-element">🌸</span>
        <span class="bg-element">🌷</span>
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
        <span class="bg-element">🌷</span>
        <span class="bg-element">✨</span>
        <span class="bg-element">🌺</span>
        <span class="bg-element">💫</span>
      </div>
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <span class="section-tag">User Management</span>
            <h2 class="section-title">
                <i class="fas fa-users section-title-icon"></i> Users
            </h2>
            <p class="section-subtitle">Manage customer accounts and admin users</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-row">
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-primary-light">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Total Users</span>
                <span class="stat-mini-value">{{ $users->total() }}</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-success-light">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Customers</span>
                <span class="stat-mini-value">{{ $users->where('role', 'customer')->count() }}</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-danger-light">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">Admins</span>
                <span class="stat-mini-value">{{ $users->where('role', 'admin')->count() }}</span>
            </div>
        </div>
        <div class="stat-mini-card">
            <div class="stat-mini-icon bg-warning-light">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="stat-mini-content">
                <span class="stat-mini-label">New This Month</span>
                <span class="stat-mini-value">{{ $users->whereBetween('created_at', [now()->startOfMonth(), now()])->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert">×</button>
        </div>
    @endif

    <!-- Table Container -->
    <div class="table-container">
        <div class="table-header">
            <div class="table-header-left">
                <span class="table-count">Total: {{ $users->total() }} users</span>
            </div>
            <div class="table-header-right">
                <div class="search-wrapper">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" id="tableSearch" class="search-input" placeholder="Search users...">
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="custom-table" id="usersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">
                                    <span>{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <span class="user-name">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="user-email">{{ $user->email }}</span>
                        </td>
                        <td>
                            @php
                                $roleColors = [
                                    'admin' => 'role-admin',
                                    'customer' => 'role-customer'
                                ];
                                $roleColor = $roleColors[$user->role] ?? 'role-customer';
                            @endphp
                            <span class="role-badge {{ $roleColor }}">
                                <span class="role-dot"></span>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="user-phone">{{ $user->phone ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="date-info">
                                {{ optional($user->created_at)->format('M d, Y') }}
                                <small class="date-time">{{ optional($user->created_at)->format('h:i A') }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="#" class="btn-action btn-view" title="View User">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">👤</div>
                                <h4>No users found</h4>
                                <p class="empty-text">Users will appear here once they register</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination - Only ONE info text here -->
        <div class="table-footer">
            <div class="pagination-container">
                <div class="pagination-wrapper">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
                <!-- REMOVE THIS LINE TO FIX DUPLICATE -->
                <!-- <div class="pagination-info">
                    <span class="pagination-text">
                        Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} results
                    </span>
                </div> -->
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* ============================================
       USERS PAGE - CLEAN PROFESSIONAL STYLE
       ============================================ */
    .users-page {
        padding: 0;
    }

    /* ============================================
       PAGE HEADER
       ============================================ */
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
  font-size: 3rem;
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

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 1rem;
        background: linear-gradient(135deg, #fdf6f3 0%, #faf5f0 100%);
        padding: 24px 28px;
        border-radius: 16px;
        border-left: 4px solid #fd79a8;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '✦';
        position: absolute;
        right: 30px;
        top: -10px;
        font-size: 8rem;
        color: rgba(253, 121, 168, 0.05);
        font-family: Georgia, serif;
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

    /* ============================================
       STATS ROW
       ============================================ */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-mini-card {
        background: white;
        border-radius: 12px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        border: 1px solid rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .stat-mini-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
    }

    .stat-mini-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .bg-primary-light {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
    }

    .bg-success-light {
        background: rgba(46, 204, 113, 0.1);
        color: #2ecc71;
    }

    .bg-danger-light {
        background: rgba(231, 76, 60, 0.1);
        color: #e74c3c;
    }

    .bg-warning-light {
        background: rgba(241, 196, 15, 0.1);
        color: #f1c40f;
    }

    .stat-mini-content {
        display: flex;
        flex-direction: column;
    }

    .stat-mini-label {
        font-size: 12px;
        color: #6c7a89;
        font-weight: 500;
    }

    .stat-mini-value {
        font-size: 20px;
        font-weight: 700;
        color: #1a1a2e;
    }

    /* ============================================
       ALERT MESSAGES
       ============================================ */
    .alert-success {
        background: #d1fae5;
        color: #065f46;
        border: 1px solid #a7f3d0;
        padding: 14px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        animation: slideDown 0.3s ease;
    }

    .alert-success i {
        color: #10b981;
        font-size: 1.2rem;
    }

    .alert-success .btn-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        transition: opacity 0.3s ease;
        padding: 0 4px;
    }

    .alert-success .btn-close:hover {
        opacity: 1;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 12px;
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

    .table-header-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        color: #9aa5b5;
        font-size: 0.85rem;
    }

    .search-input {
        padding: 8px 16px 8px 38px;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        font-size: 0.85rem;
        background: white;
        transition: all 0.3s ease;
        width: 220px;
        color: #1a1a2e;
        outline: none;
    }

    .search-input:focus {
        border-color: #fd79a8;
        box-shadow: 0 0 0 4px rgba(253, 121, 168, 0.06);
    }

    .search-input::placeholder {
        color: #94a3b8;
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

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* User Info */
    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
        flex-shrink: 0;
    }

    .user-name {
        font-weight: 500;
        color: #1a1a2e;
    }

    .user-email {
        color: #6c7a89;
        font-size: 13px;
    }

    .user-phone {
        color: #6c7a89;
        font-size: 13px;
    }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .role-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .role-admin {
        background: #dbeafe;
        color: #1e40af;
    }

    .role-admin .role-dot {
        background: #3b82f6;
    }

    .role-customer {
        background: #d1fae5;
        color: #065f46;
    }

    .role-customer .role-dot {
        background: #10b981;
    }

    /* Date Info */
    .date-info {
        display: flex;
        flex-direction: column;
        font-size: 13px;
        color: #1a1a2e;
    }

    .date-time {
        font-size: 11px;
        color: #9aa5b5;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .btn-view {
        background: rgba(52, 152, 219, 0.1);
        color: #3498db;
    }

    .btn-view:hover {
        background: rgba(52, 152, 219, 0.2);
        transform: translateY(-2px);
        color: #3498db;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 16px;
    }

    .empty-state h4 {
        font-weight: 600;
        color: #1a1a2e;
        margin-bottom: 8px;
    }

    .empty-text {
        color: #6c7a89;
        margin-bottom: 20px;
    }

    /* ============================================
       PAGINATION - CLEAN & PROFESSIONAL
       ============================================ */
    .table-footer {
        padding: 16px 24px;
        background: #fafafa;
        border-top: 1px solid #f0f0f0;
    }

    .pagination-container {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pagination-wrapper .pagination {
        display: flex;
        gap: 4px;
        list-style: none;
        padding: 0;
        margin: 0;
        align-items: center;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-wrapper .pagination li {
        display: inline-block;
    }

    .pagination-wrapper .pagination li a,
    .pagination-wrapper .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 12px;
        border-radius: 8px;
        color: #1a1a2e;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
        background: transparent;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .pagination-wrapper .pagination li a:hover {
        background: rgba(253, 121, 168, 0.1);
        color: #fd79a8;
        border-color: rgba(253, 121, 168, 0.08);
    }

    .pagination-wrapper .pagination li.active span {
        background: linear-gradient(135deg, #fd79a8, #e17055);
        color: white;
        box-shadow: 0 4px 12px rgba(253, 121, 168, 0.25);
        border-color: transparent;
    }

    .pagination-wrapper .pagination li.disabled span {
        color: #cbd5e1;
        cursor: not-allowed;
        background: transparent;
    }

    .pagination-wrapper .pagination li.disabled span:hover {
        background: transparent;
        color: #cbd5e1;
    }

    .pagination-wrapper .pagination li a[rel="prev"],
    .pagination-wrapper .pagination li a[rel="next"] {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 0 16px;
    }

    .pagination-wrapper .pagination li a[rel="prev"]:hover,
    .pagination-wrapper .pagination li a[rel="next"]:hover {
        background: rgba(253, 121, 168, 0.08);
        color: #fd79a8;
    }

    .pagination-wrapper .pagination li a[rel="prev"] i,
    .pagination-wrapper .pagination li a[rel="next"] i {
        font-size: 12px;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1200px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 992px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 768px) {
        .stats-row {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .stat-mini-card {
            padding: 12px 16px;
        }

        .stat-mini-value {
            font-size: 18px;
        }

        .table-header {
            flex-direction: column;
            align-items: stretch;
        }

        .table-header-right {
            width: 100%;
        }

        .search-wrapper {
            width: 100%;
        }

        .search-input {
            width: 100%;
        }

        .custom-table {
            font-size: 13px;
        }

        .custom-table thead th,
        .custom-table tbody td {
            padding: 8px 12px;
        }

        .pagination-container {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 8px;
        }

        .pagination-wrapper .pagination {
            justify-content: center;
        }

        .user-avatar {
            width: 30px;
            height: 30px;
            font-size: 12px;
        }
    }

    @media (max-width: 576px) {
        .section-title {
            font-size: 1.6rem;
        }

        .stats-row {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .action-buttons {
            gap: 4px;
        }

        .btn-action {
            width: 30px;
            height: 30px;
            font-size: 0.75rem;
        }

        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            min-width: 32px;
            height: 32px;
            font-size: 13px;
            padding: 0 8px;
        }

        .pagination-wrapper .pagination li a[rel="prev"],
        .pagination-wrapper .pagination li a[rel="next"] {
            padding: 0 12px;
            font-size: 13px;
        }

        .pagination-wrapper .pagination li a[rel="prev"] span,
        .pagination-wrapper .pagination li a[rel="next"] span {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            order: [[0, 'desc']],
            pageLength: 25,
            responsive: true,
            paging: false,
            info: false,
            searching: false,
        });

        // Search functionality
        $('#tableSearch').on('keyup', function() {
            $('#usersTable').DataTable().search(this.value).draw();
        });
    });
</script>
@endpush
@endsection
