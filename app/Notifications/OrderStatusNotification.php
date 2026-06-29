<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class OrderStatusNotification extends Notification
{
    protected Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable)
    {
        $order = $this->order;

        return TelegramMessage::create()
            ->to($notifiable->telegram_chat_id)
            ->content('Order Status Update')
            ->line('')
            ->line("Hello {$notifiable->name}!")
            ->line("Your order #{$order->order_number} has been updated.")
            ->line('')
            ->line("Status: {$order->status}")
            ->line('Total: $' . number_format((float) $order->total_amount, 2))
            ->button('View Orders', url('/orders'));
    }
}
