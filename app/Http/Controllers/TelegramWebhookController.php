<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $update = Telegram::getWebhookUpdate();

        if (! $update->isType('message')) {
            return 'ok';
        }

        $message = $update->getMessage();
        $text = trim((string) $message->getText());
        $chatId = $message->getChat()->getId();

        if ($text === '/start') {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Welcome to ChhoukShop Bot.\n\nYour Telegram Chat ID is: {$chatId}\n\nTo connect your account, paste this Chat ID into your profile, or send:\n/connect your-email@example.com",
            ]);

            return 'ok';
        }

        if (str_starts_with($text, '/connect')) {
            $parts = preg_split('/\s+/', $text, 2);
            $email = trim($parts[1] ?? '');

            if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Please use: /connect your-email@example.com',
                ]);

                return 'ok';
            }

            $user = User::where('email', $email)->first();

            if (! $user) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'We could not find an account with that email.',
                ]);

                return 'ok';
            }

            $user->update(['telegram_chat_id' => $chatId]);

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => 'Your Telegram account is now connected. You will receive order notifications here.',
            ]);

            return 'ok';
        }

        if (str_starts_with($text, '/status')) {
            $orderKey = trim(explode(' ', $text, 2)[1] ?? '');

            if ($orderKey === '') {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Usage: /status ORDER_ID or /status ORDER_NUMBER',
                ]);

                return 'ok';
            }

            $order = Order::where('id', $orderKey)
                ->orWhere('order_number', $orderKey)
                ->first();

            if (! $order) {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => 'Order not found.',
                ]);

                return 'ok';
            }

            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Order #{$order->order_number}\nStatus: {$order->status}\nTotal: $" . number_format((float) $order->total_amount, 2),
            ]);

            return 'ok';
        }

        if ($text === '/help') {
            Telegram::sendMessage([
                'chat_id' => $chatId,
                'text' => "Available Commands:\n\n/start - Show your Telegram Chat ID\n/connect email@example.com - Link your account\n/status ORDER_ID - Check order status\n/help - Show this help message",
            ]);

            return 'ok';
        }

        return 'ok';
    }
}
