<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CustomNotification extends Notification
{
    use Queueable;

    protected $title;
    protected $message;
    protected $type;
    protected $url;

    public function __construct($title, $message, $type = 'system', $url = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->url = $url ?? '/admin/dashboard';
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'url' => $this->url,
            'created_at' => now()->toDateTimeString()
        ];
    }
}