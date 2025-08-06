<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\PeminjamanHarian;
use App\Models\PeminjamanTahunan;

class NotificationService
{
    /**
     * Buat notifikasi untuk peminjaman harian baru
     */
    public static function createPeminjamanHarianNotification($peminjamanId)
    {
        $peminjaman = PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku'])->find($peminjamanId);
        
        if (!$peminjaman) {
            return false;
        }

        $bukuCount = $peminjaman->details->count();
        $bukuText = $bukuCount > 1 ? "$bukuCount buku" : "1 buku";
        
        $title = "Peminjaman Harian Baru";
        $message = "{$peminjaman->siswa->name} meminjam {$bukuText} pada " . 
                  $peminjaman->tanggal_pinjam . " (kembali: " . $peminjaman->tanggal_kembali . ")";

        return Notification::create([
            'type' => 'peminjaman_harian',
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-calendar-day'
        ]);
    }

    /**
     * Buat notifikasi untuk peminjaman tahunan baru
     */
    public static function createPeminjamanTahunanNotification($peminjamanId)
    {
        $peminjaman = PeminjamanTahunan::with(['siswa', 'details.kodeBuku.buku'])->find($peminjamanId);
        
        if (!$peminjaman) {
            return false;
        }

        $bukuCount = $peminjaman->details->count();
        $bukuText = $bukuCount > 1 ? "$bukuCount buku" : "1 buku";
        
        $title = "Peminjaman Tahunan Baru";
        $message = "{$peminjaman->siswa->name} meminjam {$bukuText} pada " . 
                  $peminjaman->tanggal_pinjam . " (kembali: " . $peminjaman->tanggal_kembali . ")";

        return Notification::create([
            'type' => 'peminjaman_tahunan',
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => 'fas fa-calendar-alt'
        ]);
    }

    /**
     * Buat notifikasi untuk peminjaman yang akan jatuh tempo
     */
    public static function createDueDateReminder($type, $peminjamanId)
    {
        if ($type === 'harian') {
            $peminjaman = PeminjamanHarian::with('siswa')->find($peminjamanId);
            $routeType = 'peminjaman_harian';
            $icon = 'fas fa-exclamation-triangle';
        } else {
            $peminjaman = PeminjamanTahunan::with('siswa')->find($peminjamanId);
            $routeType = 'peminjaman_tahunan';
            $icon = 'fas fa-exclamation-triangle';
        }

        if (!$peminjaman) {
            return false;
        }

        $title = "Reminder Jatuh Tempo";
        $message = "Peminjaman {$peminjaman->siswa->name} akan jatuh tempo pada {$peminjaman->tanggal_kembali}";

        return Notification::create([
            'type' => $routeType,
            'reference_id' => $peminjamanId,
            'title' => $title,
            'message' => $message,
            'icon' => $icon
        ]);
    }
}
