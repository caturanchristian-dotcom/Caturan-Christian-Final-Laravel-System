<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch unread notifications and real-time system state.
     */
    public function sync()
    {
        if (!Auth::check()) return response()->json(['error' => 'Unauthenticated'], 401);

        $user = Auth::user();

        // 1. Get new notifications
        $notifications = Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->latest()
            ->get();

        // 2. Role-specific data
        $payload = [
            'notifications' => $notifications,
            'unread_count' => $notifications->count(),
        ];

        if ($user->role->name === 'farmer') {
            $payload['active_orders'] = Order::whereHas('items.product', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'pending')->count();
        }

        return response()->json($payload);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === Auth::id()) {
            $notification->update(['is_read' => true]);
        }
        return response()->json(['success' => true]);
    }
}
