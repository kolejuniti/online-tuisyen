<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get all notifications for the authenticated student
     */
    public function index()
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notifications = $student->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return response()->json($notifications);
    }

    /**
     * Get unread notifications count
     */
    public function unreadCount()
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $count = $student->unreadNotifications()->count();

        return response()->json(['count' => $count]);
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $notification = $student->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Notification not found'], 404);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $student->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    /**
     * Get notifications for the student layout
     */
    public function getForLayout()
    {
        $student = Auth::guard('student')->user();
        
        if (!$student) {
            return response()->json(['notifications' => [], 'unread_count' => 0]);
        }

        $notifications = $student->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'] ?? '',
                    'data' => $notification->data['data'] ?? [],
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans(),
                    'is_unread' => is_null($notification->read_at)
                ];
            });

        $unreadCount = $student->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }
}
