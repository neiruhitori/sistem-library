<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'reference_id',
        'title',
        'message',
        'icon',
        'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk notifikasi terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Method untuk menandai sebagai sudah dibaca
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    // Method untuk mendapatkan URL detail berdasarkan type
    public function getDetailUrl()
    {
        switch ($this->type) {
            case 'peminjaman_harian':
                return route('peminjamanharian.show', $this->reference_id);
            case 'peminjaman_tahunan':
                return route('peminjamantahunan.show', $this->reference_id);
            default:
                return '#';
        }
    }

    // Method untuk format waktu yang user-friendly
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    // Method untuk mendapatkan class CSS berdasarkan status
    public function getBadgeClassAttribute()
    {
        return $this->is_read ? 'text-muted' : 'text-primary font-weight-bold';
    }
}
