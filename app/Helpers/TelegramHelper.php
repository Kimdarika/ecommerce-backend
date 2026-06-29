<?php

namespace App\Helpers;

use App\Models\User;
use App\Notifications\OrderStatusNotification;
use Illuminate\Support\Facades\Notification;

class TelegramHelper
{
    public static function sendToUser($userId, $order)
    {
        $user = User::find($userId);
        if ($user && $user->hasTelegram()) {
            $user->notify(new OrderStatusNotification($order));
            return true;
        }
        return false;
    }

    public static function sendToAdmins($order)
    {
        $admins = User::where('role', 'admin')
            ->whereNotNull('telegram_chat_id')
            ->get();

        if ($admins->isEmpty()) {
            return false;
        }

        Notification::send($admins, new OrderStatusNotification($order));
        return true;
    }
}
