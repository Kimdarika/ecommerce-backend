<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Glow Beauty</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    
    @stack('styles')
    
    <style>
        /* ============================================
           ADMIN LAYOUT - PROFESSIONAL NO SCROLL
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f0f2f5;
            color: #1a1a2e;
        }

        /* ============================================
           SIDEBAR - FIXED NO SCROLL
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
            opacity: 0.08;
        }

        .bg-element:nth-child(1) { top: 5%; left: 5%; animation-delay: 0s; }
        .bg-element:nth-child(2) { top: 15%; right: 10%; animation-delay: 2s; font-size: 3.5rem; }
        .bg-element:nth-child(3) { bottom: 20%; left: 8%; animation-delay: 4s; }
        .bg-element:nth-child(4) { bottom: 10%; right: 5%; animation-delay: 6s; font-size: 4rem; }
        .bg-element:nth-child(5) { top: 45%; left: 2%; animation-delay: 1s; font-size: 2.5rem; }
        .bg-element:nth-child(6) { top: 40%; right: 2%; animation-delay: 3s; font-size: 3.2rem; }
        .bg-element:nth-child(7) { top: 70%; left: 3%; animation-delay: 5s; font-size: 2.8rem; }
        .bg-element:nth-child(8) { top: 25%; right: 3%; animation-delay: 7s; }

        @keyframes floatBg {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-40px) rotate(5deg) scale(1.1); }
            75% { transform: translateY(40px) rotate(-5deg) scale(0.9); }
        }



        .sidebar {
            background: linear-gradient(180deg, #0c1220 0%, #1a1a2e 50%, #16213e 100%) !important;
            height: 100vh;
            padding: 0 !important;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.06);
            border-right: 1px solid rgba(255, 255, 255, 0.03);
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Brand */
        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .sidebar-brand .brand-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, #fd79a8, #e17055);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 4px 20px rgba(253, 121, 168, 0.25);
            transition: all 0.4s ease;
        }

        .sidebar-brand .brand-icon:hover {
            transform: rotate(-5deg) scale(1.05);
            box-shadow: 0 8px 30px rgba(253, 121, 168, 0.35);
        }

        .sidebar-brand h5 {
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
            margin: 0;
            letter-spacing: -0.5px;
        }

        .sidebar-brand h5 span {
            background: linear-gradient(135deg, #fd79a8, #e17055);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Navigation - Scrollable */
        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 12px 14px;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
        }

        .sidebar-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        .sidebar .nav-item {
            margin-bottom: 4px;
        }

        .sidebar .nav-link {
            color: #94a3b8 !important;
            padding: 12px 16px !important;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .sidebar .nav-link i {
            width: 20px;
            font-size: 1rem;
            transition: all 0.3s ease;
            color: #94a3b8;
        }

        .sidebar .nav-link span {
            flex: 1;
        }

        .sidebar .nav-link .badge {
            margin-left: auto;
            background: linear-gradient(135deg, #fd79a8, #e17055);
            font-weight: 600;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 0.65rem;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.04);
            color: white !important;
            transform: translateX(4px);
        }

        .sidebar .nav-link:hover i {
            color: #fd79a8;
        }

        .sidebar .nav-link.active {
            background: rgba(253, 121, 168, 0.08);
            color: white !important;
            border: 1px solid rgba(253, 121, 168, 0.06);
        }

        .sidebar .nav-link.active i {
            color: #fd79a8;
        }

        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 28px;
            background: linear-gradient(180deg, #fd79a8, #e17055);
            border-radius: 0 4px 4px 0;
        }

        .sidebar-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 8px 16px;
            flex-shrink: 0;
        }

        /* Sidebar Footer - Fixed at Bottom */
        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(12px);
            flex-shrink: 0;
        }

        .sidebar-footer .logout-btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 12px;
            background: rgba(231, 76, 60, 0.12);
            color: #fc8181;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-footer .logout-btn:hover {
            background: rgba(231, 76, 60, 0.2);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(231, 76, 60, 0.1);
        }

        /* ============================================
           MAIN CONTENT - FULL HEIGHT NO SCROLL
           ============================================ */
        .main-content {
            margin-left: 250px;
            height: 100vh;
            overflow-y: auto;
            background: #f0f2f5;
            display: flex;
            flex-direction: column;
        }

        .main-content::-webkit-scrollbar {
            width: 6px;
        }

        .main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #fd79a8, #e17055);
            border-radius: 10px;
        }

        .main-content::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #e17055, #fd79a8);
        }

        /* ============================================
           TOP HEADER BAR - FIXED
           ============================================ */
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 24px;
            background: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.03);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            z-index: 100;
            flex-wrap: wrap;
            gap: 12px;
        }

        .top-header-left h4 {
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
        }

        .top-header-left p {
            color: #6c7a89;
            margin: 0;
            font-size: 0.85rem;
        }

        .top-header-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8f9fa;
            padding: 4px 20px 4px 4px;
            border-radius: 50px;
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
        }

        .admin-info:hover {
            border-color: #fd79a8;
            box-shadow: 0 2px 16px rgba(253, 121, 168, 0.08);
        }

        .admin-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #fd79a8, #e17055);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.85rem;
            box-shadow: 0 2px 12px rgba(253, 121, 168, 0.2);
        }

        .admin-details {
            display: flex;
            flex-direction: column;
            gap: 1px;
        }

        .admin-name {
            font-weight: 600;
            color: #1a1a2e;
            font-size: 0.85rem;
            line-height: 1.2;
        }

        .admin-role {
            font-size: 0.6rem;
            color: #9aa5b5;
            background: #f1f3f5;
            padding: 1px 12px;
            border-radius: 20px;
            display: inline-block;
            width: fit-content;
        }

        .notification-wrapper {
            position: relative;
        }

        .notification-trigger {
            position: relative;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background: #f8f9fa;
            color: #1a1a2e;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .notification-trigger.dropdown-toggle::after {
            display: none;
        }

        .notification-trigger:hover {
            background: rgba(253, 121, 168, 0.12);
            color: #fd79a8;
            transform: translateY(-1px);
        }

        .notification-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            min-width: 18px;
            height: 18px;
            border-radius: 999px;
            background: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 5px;
            border: 2px solid white;
        }

        .notification-menu {
            min-width: 360px;
            padding: 0;
            border: 1px solid rgba(0, 0, 0, 0.06);
            border-radius: 16px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            overflow: hidden;
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 14px 16px;
            background: #fafafa;
            border-bottom: 1px solid #eef2f7;
        }

        .notification-title {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 700;
            color: #1a1a2e;
        }

        .notification-link {
            color: #fd79a8;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }

        .notification-link:hover {
            color: #e17055;
        }

        .notification-list {
            max-height: 360px;
            overflow-y: auto;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 16px;
            text-decoration: none;
            border-bottom: 1px solid #f3f4f6;
            transition: background 0.2s ease;
        }

        .notification-item:hover {
            background: #f8fafc;
        }

        .notification-item.unread {
            background: rgba(253, 121, 168, 0.06);
        }

        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 12px;
            background: linear-gradient(135deg, #fd79a8, #e17055);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .notification-content {
            min-width: 0;
            flex: 1;
        }

        .notification-message {
            margin: 0;
            color: #1a1a2e;
            font-size: 0.85rem;
            font-weight: 600;
            line-height: 1.35;
        }

        .notification-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 4px;
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .notification-empty {
            padding: 28px 16px;
            text-align: center;
            color: #94a3b8;
        }

        .notification-footer {
            padding: 12px 16px;
            border-top: 1px solid #eef2f7;
            background: #fff;
        }

        /* ============================================
           PAGE CONTENT - SCROLLABLE
           ============================================ */
        .page-content {
            flex: 1;
            padding: 24px 32px 40px;
            overflow-y: auto;
        }

        /* ============================================
           ALERT MESSAGES
           ============================================ */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 14px 20px;
            font-weight: 500;
            margin-bottom: 24px;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-success .btn-close {
            filter: none;
            margin-left: auto;
        }

        .alert i {
            font-size: 1.1rem;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }

            .sidebar-brand h5 span,
            .sidebar-brand h5 {
                display: none;
            }

            .sidebar-brand {
                padding: 16px 12px;
                justify-content: center;
            }

            .sidebar .nav-link span {
                display: none;
            }

            .sidebar .nav-link {
                justify-content: center;
                padding: 12px !important;
            }

            .sidebar .nav-link .badge {
                display: none;
            }

            .sidebar .nav-link i {
                font-size: 1.2rem;
            }

            .sidebar-footer .logout-btn span {
                display: none;
            }

            .sidebar-footer .logout-btn {
                padding: 10px;
            }

            .sidebar-divider {
                margin: 8px 8px;
            }

            .main-content {
                margin-left: 70px;
            }

            .top-header {
                flex-direction: column;
                align-items: flex-start;
                padding: 12px 16px;
            }

            .top-header-right {
                width: 100%;
                justify-content: flex-start;
            }

            .page-content {
                padding: 16px;
            }

            .admin-details {
                display: none;
            }

            .admin-info {
                padding: 4px 10px 4px 4px;
            }

            .admin-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .top-header-left h4 {
                font-size: 1.2rem;
            }

            .top-header-left p {
                font-size: 0.75rem;
            }

            .page-content {
                padding: 12px;
            }

            .admin-avatar {
                width: 28px;
                height: 28px;
                font-size: 0.65rem;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <!-- Brand -->
        <div class="bg-elements">
            <span class="bg-element">🌸</span>
            <span class="bg-element">💄</span>
            <span class="bg-element">✨</span>
            <span class="bg-element">🌺</span>
            <span class="bg-element">💫</span>
            <span class="bg-element">🦋</span>
            <span class="bg-element">🌹</span>
            <span class="bg-element">💖</span>
        </div>
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-store"></i>
            </div>
            <h5>Chhouk<span>Shop</span></h5>
        </div>

        <!-- Navigation - Scrollable -->
        <div class="sidebar-nav">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="fas fa-tags"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                        <i class="fas fa-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                    </a>
                </li>
            </ul>

            <div class="sidebar-divider"></div>
        </div>

        <!-- Footer - Fixed at Bottom -->
        <div class="sidebar-footer">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Sign Out</span>
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header - Sticky -->
        <div class="top-header">
            <div class="top-header-left">
                <h4>@yield('title', 'Dashboard')</h4>
                <p>Manage your beauty store</p>
            </div>
            <div class="top-header-right">
                @php
                    $currentAdmin = Auth::user();
                    $notificationItems = $currentAdmin?->notifications()->latest()->take(5)->get() ?? collect();
                    $unreadCount = $currentAdmin?->unreadNotifications()->count() ?? 0;
                @endphp

                <div class="dropdown notification-wrapper">
                    <button class="notification-trigger dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        @if($unreadCount > 0)
                            <span class="notification-badge">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu dropdown-menu-end notification-menu">
                        <div class="notification-header">
                            <h6 class="notification-title">Notifications</h6>
                            @if($unreadCount > 0)
                                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="notification-link">Mark all read</button>
                                </form>
                            @endif
                        </div>

                        <div class="notification-list">
                            @forelse($notificationItems as $notification)
                                @php
                                    $isUnread = is_null($notification->read_at);
                                @endphp
                                <a href="{{ route('admin.notifications.show', $notification->id) }}" class="notification-item {{ $isUnread ? 'unread' : '' }}">
                                    <div class="notification-icon">
                                        <i class="fas fa-shopping-bag"></i>
                                    </div>
                                    <div class="notification-content">
                                        <p class="notification-message">{{ $notification->data['message'] ?? $notification->data['title'] ?? 'New notification' }}</p>
                                        <div class="notification-meta">
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                            @if(!empty($notification->data['order_number']))
                                                <span>#{{ $notification->data['order_number'] }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="notification-empty">
                                    <i class="fas fa-bell-slash mb-2"></i>
                                    <div>No notifications yet</div>
                                </div>
                            @endforelse
                        </div>

                        <div class="notification-footer">
                            <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm btn-outline-primary w-100">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>

                <div class="admin-info">
                    <div class="admin-avatar">{{ strtoupper(substr($currentAdmin->name ?? 'A', 0, 1)) }}</div>
                    <div class="admin-details">
                        <span class="admin-name">{{ $currentAdmin->name ?? 'Admin' }}</span>
                        <span class="admin-role">{{ $currentAdmin->role ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    @stack('scripts')
</body>
</html>
