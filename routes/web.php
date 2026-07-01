<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\TelegramWebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Telegram routes
Route::get('/get-telegram-id', function () {
    try {
        $updates = \NotificationChannels\Telegram\TelegramUpdates::create()
            ->limit(1)
            ->get();

        if ($updates['ok'] && !empty($updates['result'])) {
            $chatId = $updates['result'][0]['message']['chat']['id'];
            return "✅ Your Chat ID is: <strong>{$chatId}</strong>";
        }
        return "❌ No updates found. Send a message to your bot first!";
    } catch (\Exception $e) {
        return "❌ Error: " . $e->getMessage();
    }
});

Route::post('/telegram-webhook', [TelegramWebhookController::class, 'handle']);

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check() && Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

// Admin Login Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', function () {
        return view('admin.auth.login');
    })->name('login')->middleware('guest');

    Route::post('/login', [AdminLoginController::class, 'login'])
        ->name('login.submit')
        ->middleware('guest');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes (Full CRUD)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ==================== DASHBOARD ====================
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });

    // ==================== CATEGORY MANAGEMENT (FULL CRUD) ====================
    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/create', [CategoryController::class, 'create'])->name('create');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('/{category}', [CategoryController::class, 'show'])->name('show');
        Route::get('/{category}/edit', [CategoryController::class, 'edit'])->name('edit');
        Route::put('/{category}', [CategoryController::class, 'update'])->name('update');
        Route::patch('/{category}', [CategoryController::class, 'update'])->name('update.patch');
        Route::delete('/{category}', [CategoryController::class, 'destroy'])->name('destroy');
        
        // Additional category actions
        Route::post('/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('toggle-status');
        Route::get('/{category}/products', [CategoryController::class, 'products'])->name('products');
    });

    // ==================== PRODUCT MANAGEMENT (FULL CRUD) ====================
    
    Route::prefix('products')->name('products.')->group(function () {
        // Route::get('/{product}', [ProductController::class, 'show']);
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::patch('/{product}', [ProductController::class, 'update'])->name('update.patch');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
        // ==================== PRODUCT MANAGEMENT ====================

        
      
        
        // Additional product actions
        Route::post('/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{product}/update-stock', [ProductController::class, 'updateStock'])->name('update-stock');
        Route::get('/{product}/reviews', [ProductController::class, 'reviews'])->name('reviews');
        Route::post('/{product}/featured', [ProductController::class, 'toggleFeatured'])->name('toggle-featured');
        Route::get('/export', [ProductController::class, 'export'])->name('export');
        Route::post('/import', [ProductController::class, 'import'])->name('import');
        Route::post('/bulk-delete', [ProductController::class, 'bulkDelete'])->name('bulk-delete');
    });

    // ==================== ORDER MANAGEMENT (FULL CRUD) ====================
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::patch('/{order}', [OrderController::class, 'update'])->name('update.patch');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        
        // Order specific actions
        Route::put('/{order}/status', [OrderController::class, 'updateStatus'])->name('status');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
        Route::post('/{order}/refund', [OrderController::class, 'refund'])->name('refund');
        Route::get('/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('invoice');
        Route::post('/{order}/send-email', [OrderController::class, 'sendEmail'])->name('send-email');
        Route::get('/export', [OrderController::class, 'export'])->name('export');
        Route::get('/filters', [OrderController::class, 'filter'])->name('filter');
    });

    // ==================== USER MANAGEMENT (FULL CRUD) ====================
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::patch('/{user}', [UserController::class, 'update'])->name('update.patch');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
        
        // User specific actions
        Route::post('/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/{user}/reset-password', [UserController::class, 'resetPassword'])->name('reset-password');
        Route::post('/{user}/assign-role', [UserController::class, 'assignRole'])->name('assign-role');
        Route::post('/{user}/block', [UserController::class, 'block'])->name('block');
        Route::post('/{user}/unblock', [UserController::class, 'unblock'])->name('unblock');
        Route::get('/export', [UserController::class, 'export'])->name('export');
        Route::post('/bulk-delete', [UserController::class, 'bulkDelete'])->name('bulk-delete');
    });

    // ==================== NOTIFICATION MANAGEMENT (FULL CRUD) ====================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/create', [NotificationController::class, 'create'])->name('create');
        Route::post('/', [NotificationController::class, 'store'])->name('store');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
        Route::get('/{notification}/edit', [NotificationController::class, 'edit'])->name('edit');
        Route::put('/{notification}', [NotificationController::class, 'update'])->name('update');
        Route::patch('/{notification}', [NotificationController::class, 'update'])->name('update.patch');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
        
        // Notification specific actions
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('mark-unread');
        Route::post('/send-bulk', [NotificationController::class, 'sendBulk'])->name('send-bulk');
        Route::get('/types', [NotificationController::class, 'getTypes'])->name('types');
    });

    // ==================== ADDITIONAL ADMIN ROUTES ====================
    
    // // Profile
    // Route::prefix('profile')->name('profile.')->group(function () {
    //     Route::get('/', [ProfileController::class, 'show'])->name('show');
    //     Route::put('/', [ProfileController::class, 'update'])->name('update');
    //     Route::put('/password', [ProfileController::class, 'updatePassword'])->name('update-password');
    // });

    // Logout
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Test Routes (For Development Only)
|--------------------------------------------------------------------------
*/

if (app()->environment('local', 'testing')) {
    Route::prefix('test')->name('test.')->group(function () {
        // Test category routes
        Route::get('/categories', function () {
            return response()->json([
                'routes' => [
                    'index' => route('admin.categories.index'),
                    'create' => route('admin.categories.create'),
                    'store' => route('admin.categories.store'),
                    'show' => route('admin.categories.show', 1),
                    'edit' => route('admin.categories.edit', 1),
                    'update' => route('admin.categories.update', 1),
                    'destroy' => route('admin.categories.destroy', 1),
                ]
            ]);
        });

        // Test product routes
        Route::get('/products', function () {
            return response()->json([
                'routes' => [
                    'index' => route('admin.products.index'),
                    'create' => route('admin.products.create'),
                    'store' => route('admin.products.store'),
                    'show' => route('admin.products.show', 1),
                    'edit' => route('admin.products.edit', 1),
                    'update' => route('admin.products.update', 1),
                    'destroy' => route('admin.products.destroy', 1),
                ]
            ]);
        });

        // Test all routes
        Route::get('/all-routes', function () {
            $routes = [];
            foreach (Route::getRoutes() as $route) {
                if (strpos($route->uri, 'admin') !== false) {
                    $routes[] = [
                        'method' => implode('|', $route->methods()),
                        'uri' => $route->uri(),
                        'name' => $route->getName(),
                        'action' => $route->getActionName(),
                    ];
                }
            }
            return response()->json($routes);
        });
    });
}