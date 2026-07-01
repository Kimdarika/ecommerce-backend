<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     */
    public function index(Request $request)
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(15);

        $unreadCount = $request->user()->unreadNotifications()->count();

        // If API request
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $notifications,
                'unread_count' => $unreadCount
            ]);
        }

        return view('admin.notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Show the form for creating a new notification.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.notifications.create', compact('users'));
    }

    /**
     * Store a newly created notification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:system,promotion,update,alert',
            'user_id' => 'nullable|exists:users,id',
            'url' => 'nullable|url'
        ]);

        // Determine which users to send to
        if ($request->user_id) {
            $users = User::where('id', $request->user_id)->get();
        } else {
            $users = User::all(); // Send to all users
        }

        // Send notification to each user
        foreach ($users as $user) {
            $user->notify(new CustomNotification(
                $request->title,
                $request->message,
                $request->type,
                $request->url ?? route('admin.dashboard')
            ));
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification sent successfully',
                'sent_to' => $users->count() . ' user(s)'
            ], 201);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification sent successfully to ' . $users->count() . ' user(s)!');
    }

    /**
     * Display the specified notification.
     */
    public function show(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();

        // Mark as read if not read
        if (is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        $url = data_get($notification->data, 'url', route('admin.dashboard'));

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $notification,
                'url' => $url
            ]);
        }

        return redirect()->to($url);
    }

    /**
     * Show the form for editing the specified notification.
     */
    public function edit(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();

        return view('admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified notification.
     */
    public function update(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();

        if ($request->has('mark_as_read')) {
            $notification->markAsRead();
        } elseif ($request->has('mark_as_unread')) {
            $notification->markAsUnread();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification updated successfully',
                'data' => $notification
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification updated successfully!');
    }

    /**
     * Remove the specified notification.
     */
    public function destroy(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();

        $notification->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification deleted successfully'
            ]);
        }

        return redirect()->route('admin.notifications.index')
            ->with('success', 'Notification deleted successfully!');
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read'
            ]);
        }

        return back()->with('success', 'All notifications marked as read.');
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();
        
        $notification->markAsRead();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'data' => $notification
            ]);
        }

        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * Mark a single notification as unread.
     */
    public function markAsUnread(Request $request, $notificationId)
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $notificationId)
            ->firstOrFail();
        
        $notification->markAsUnread();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Notification marked as unread',
                'data' => $notification
            ]);
        }

        return back()->with('success', 'Notification marked as unread.');
    }

    /**
     * Send bulk notifications to multiple users.
     */
    public function sendBulk(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|string|in:system,promotion,update,alert',
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'url' => 'nullable|url'
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();

        foreach ($users as $user) {
            $user->notify(new CustomNotification(
                $request->title,
                $request->message,
                $request->type,
                $request->url ?? route('admin.dashboard')
            ));
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk notifications sent successfully',
            'sent_to' => $users->count() . ' users'
        ]);
    }

    /**
     * Get notification types.
     */
    public function getTypes()
    {
        return response()->json([
            'types' => ['system', 'promotion', 'update', 'alert']
        ]);
    }
}