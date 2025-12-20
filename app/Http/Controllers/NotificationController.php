<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    // Mendapatkan semua notifikasi untuk dropdown
    public function getNotifications()
    {
        try {
            // Gunakan struktur custom tabel: user_id, type, reference_id, title, message, icon, is_read
            $notifications = DB::table('notifications')
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get()
                ->map(function ($notification) {
                    return [
                        'id' => $notification->id,
                        'type' => $notification->type,
                        'title' => $notification->title,
                        'message' => $notification->message,
                        'icon' => $notification->icon,
                        'is_read' => (bool) $notification->is_read,
                        'created_at' => $notification->created_at
                    ];
                });

            $unreadCount = DB::table('notifications')
                ->where('user_id', Auth::id())
                ->where('is_read', false)
                ->count();

            return response()->json([
                'notifications' => $notifications,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Notification error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'notifications' => [],
                'unread_count' => 0,
                'error' => $e->getMessage()
            ], 200);
        }
    }

    // Menandai notifikasi sebagai sudah dibaca dan redirect ke detail
    public function markAsReadAndRedirect($id)
    {
        try {
            DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->update(['is_read' => true]);

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('dashboard');
        }
    }

    // Menandai semua notifikasi sebagai sudah dibaca
    public function markAllAsRead()
    {
        try {
            DB::table('notifications')
                ->where('user_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi'
            ]);
        }
    }

    // Menghapus semua notifikasi
    public function clearAll()
    {
        try {
            DB::table('notifications')
                ->where('user_id', Auth::id())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notifikasi'
            ]);
        }
    }

    // Menghapus notifikasi tertentu
    public function delete($id)
    {
        try {
            DB::table('notifications')
                ->where('id', $id)
                ->where('user_id', Auth::id())
                ->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus notifikasi'
            ]);
        }
    }
}
