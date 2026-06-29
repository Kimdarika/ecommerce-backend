<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    // When order is created
    public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_amount' => $request->total_amount ?? $request->total ?? 0,
            'status' => 'pending',
        ]);

        $user = User::find($order->user_id);
        if ($user?->hasTelegram()) {
            $user->notify(new OrderStatusNotification($order));
        }

        $admins = User::where('role', 'admin')
            ->whereNotNull('telegram_chat_id')
            ->get();

        if ($admins->isNotEmpty()) {
            Notification::send($admins, new OrderStatusNotification($order));
        }

        return redirect()->route('orders.show', $order);
    }

    // When order status is updated
    public function update(Request $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
        ]);

        $user = User::find($order->user_id);
        if ($user?->hasTelegram()) {
            $user->notify(new OrderStatusNotification($order));
        }

        return redirect()->route('orders.index');
    }
}
