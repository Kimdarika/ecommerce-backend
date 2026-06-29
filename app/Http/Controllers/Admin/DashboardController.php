<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'revenue' => Order::sum('total_amount'),
            'users' => User::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recentOrders = Order::with('user')->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }
}