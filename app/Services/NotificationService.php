<?php

namespace App\Services;

use App\Models\PeminjamanHarian;
use App\Models\PeminjamanTahunan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    /**
     * Helper untuk membuat notifikasi - struktur custom table
     */
    private static function createNotification($data)
    {
        try {
            $result = DB::table('notifications')->insert([
                'user_id' => $data['user_id'],
                'type' => $data['type'],
                'reference_id' => $data['reference_id'] ?? null,
                'title' => $data['title'],
                'message' => $data['message'],
                'icon' => $data['icon'] ?? 'fas fa-bell',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            \Log::info('Notification created', ['result' => $result, 'user_id' => $data['user_id']]);
            return $result;
        } catch (\Exception $e) {
            \Log::error('Failed to create notification: ' . $e->getMessage(), [
                'exception' => $e->getTraceAsString(),
                'data' => $data
            ]);
            return false;
        }
    }

    /**
     * Buat notifikasi untuk semua user (broadcast)
     * Digunakan untuk peminjaman dari Android
     */
    private static function createNotificationForAllUsers($data)
    {
        try {
            $users = User::all();
            $notifications = [];

            foreach ($users as $user) {
                $notifications[] = [
                    'user_id' => $user->id,
                    'type' => $data['type'],
                    'reference_id' => $data['reference_id'] ?? null,
                    'title' => $data['title'],
                    'message' => $data['message'],
                    'icon' => $data['icon'] ?? 'fas fa-bell',
                    'is_read' => false,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }

            if (count($notifications) > 0) {
                DB::table('notifications')->insert($notifications);
                \Log::info('Broadcast notification created for ' . count($notifications) . ' users');
                return true;
            }

            return false;
        } catch (\Exception $e) {
            \Log::error('Failed to create broadcast notification: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Buat notifikasi untuk peminjaman harian baru
     * Jika user_id null (dari Android), broadcast ke semua user
     */
    public static function createPeminjamanHarianNotification($peminjamanId)
    {
        $peminjaman = PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku', 'user'])->find($peminjamanId);
        
        if (!$peminjaman) {
            return false;
        }

        $bukuCount = $peminjaman->details->count();
        $bukuText = $bukuCount > 1 ? "$bukuCount buku" : "1 buku";
        
        $title = "Peminjaman Harian Baru";
        $message = "{$peminjaman->siswa->name} meminjam {$bukuText} pada " . 
                  $peminjaman->tanggal_pinjam . " (kembali: " . $peminjaman->tanggal_kembali . ")";

        $notifData = [
            'type' => 'peminjaman_harian',
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-calendar-day'
        ];

        // Jika user_id null (dari Android), kirim ke semua user
        if ($peminjaman->user_id === null) {
            return self::createNotificationForAllUsers($notifData);
        }

        // Jika ada user_id (dari website), kirim hanya ke user tersebut
        $notifData['user_id'] = $peminjaman->user_id;
        return self::createNotification($notifData);
    }

    /**
     * Buat notifikasi untuk peminjaman tahunan baru
     * Jika user_id null (dari Android), broadcast ke semua user
     */
    public static function createPeminjamanTahunanNotification($peminjamanId)
    {
        $peminjaman = PeminjamanTahunan::with(['siswa', 'details.kodeBuku.buku', 'user'])->find($peminjamanId);
        
        if (!$peminjaman) {
            return false;
        }

        $bukuCount = $peminjaman->details->count();
        $bukuText = $bukuCount > 1 ? "$bukuCount buku" : "1 buku";
        
        $title = "Peminjaman Tahunan Baru";
        $message = "{$peminjaman->siswa->name} meminjam {$bukuText} pada " . 
                  $peminjaman->tanggal_pinjam . " (kembali: " . $peminjaman->tanggal_kembali . ")";

        $notifData = [
            'type' => 'peminjaman_tahunan',
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-calendar-alt'
        ];

        // Jika user_id null (dari Android), kirim ke semua user
        if ($peminjaman->user_id === null) {
            return self::createNotificationForAllUsers($notifData);
        }

        // Jika ada user_id (dari website), kirim hanya ke user tersebut
        $notifData['user_id'] = $peminjaman->user_id;
        return self::createNotification($notifData);
    }

    /**
     * Buat notifikasi untuk peminjaman yang akan jatuh tempo
     */
    public static function createDueDateReminder($type, $peminjamanId)
    {
        if ($type === 'harian') {
            $peminjaman = PeminjamanHarian::with('siswa', 'user')->find($peminjamanId);
            $routeType = 'peminjaman_harian';
            $icon = 'fas fa-exclamation-triangle';
        } else {
            $peminjaman = PeminjamanTahunan::with('siswa', 'user')->find($peminjamanId);
            $routeType = 'peminjaman_tahunan';
            $icon = 'fas fa-exclamation-triangle';
        }

        if (!$peminjaman) {
            return false;
        }

        $title = "Reminder Jatuh Tempo";
        $message = "Peminjaman {$peminjaman->siswa->name} akan jatuh tempo pada {$peminjaman->tanggal_kembali}";

        return self::createNotification([
            'user_id' => $peminjaman->user_id,
            'type' => $routeType,
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => $icon
        ]);
    }
}
