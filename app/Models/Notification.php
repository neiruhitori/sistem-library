<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

// Model ini TIDAK DIGUNAKAN lagi
// Notifikasi sekarang menggunakan Laravel's built-in notifications table
// dengan struktur: notifiable_id, notifiable_type, data (JSON)
// 
// Semua operasi notifikasi dilakukan via DB::table('notifications') langsung
// di NotificationController dan NotificationService

class Notification extends Model
{
    // Model kosong - tidak digunakan
}
