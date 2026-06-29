<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public function __construct(private Order $order)
    {
        $this->order->loadMissing('user');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return $this->payload();
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return $this->payload();
    }

    private function payload(): array
    {
        return [
            'title' => 'New order received',
            'message' => sprintf(
                '%s placed order %s',
                $this->order->user?->name ?? 'A customer',
                $this->order->order_number
            ),
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'customer_name' => $this->order->user?->name,
            'customer_email' => $this->order->user?->email,
            'total_amount' => (float) $this->order->total_amount,
            'status' => $this->order->status,
            'url' => route('admin.orders.show', $this->order),
        ];
    }
}
