<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Mendapatkan semua notifikasi untuk dropdown
    public function getNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->take(10) // Ambil 10 notifikasi terbaru
            ->get();

        $unreadCount = Notification::where('user_id', Auth::id())->unread()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    // Menandai notifikasi sebagai sudah dibaca dan redirect ke detail
    public function markAsReadAndRedirect($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->markAsRead();
        
        return redirect($notification->getDetailUrl());
    }

    // Menandai semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        Notification::where('user_id', Auth::id())->unread()->update(['is_read' => true]);
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
        ]);
    }

    // Menghapus semua notifikasi
    public function clearAll()
    {
        Notification::where('user_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah dihapus'
        ]);
    }

    // Menghapus notifikasi tertentu
    public function delete($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);
        $notification->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus'
        ]);
    }
}
