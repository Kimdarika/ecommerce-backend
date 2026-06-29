<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TelegramWebhookController;
Route::get('/get-telegram-id', function () {
    $updates = \NotificationChannels\Telegram\TelegramUpdates::create()
        ->limit(1)
        ->get();

    if ($updates['ok'] && !empty($updates['result'])) {
        $chatId = $updates['result'][0]['message']['chat']['id'];
        return "✅ Your Chat ID is: <strong>{$chatId}</strong>";
    }
    return "❌ No updates found. Send a message to your bot first!";
});

// Webhook route for incoming messages (if using interactive features)
Route::post('/telegram-webhook', [TelegramWebhookController::class, 'handle']);
Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('admin.login');
});

// Admin Login (Direct Login - Working)
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
})->middleware('admin');

// Admin Dashboard Routes (Protected)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Category Management
    Route::resource('categories', CategoryController::class)->except(['show']);
    
    // Product Management
    Route::resource('products', ProductController::class)->except(['show']);
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Order Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');

    // Notification Center
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::get('/notifications/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
    
    // User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});
