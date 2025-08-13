<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanDenda extends Model
{
    use HasFactory;
    protected $table = 'catatan_dendas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'siswas_id',
        'tipe_peminjaman',
        'peminjaman_harians_id',
        'peminjaman_tahunans_id',
        'referensi_id',
        'jenis_denda',
        'jumlah',
        'keterangan',
        'tanggal_denda',
        'status',
        'handled_by_user_id',
        'approved_by_user_id'
    ];
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanHarian::class, 'peminjaman_harians_id');
    }

    public function peminjamantahunan()
    {
        return $this->belongsTo(PeminjamanTahunan::class, 'peminjaman_tahunans_id');
    }

    // User yang menangani pengembalian/denda
    public function handledByUser()
    {
        return $this->belongsTo(User::class, 'handled_by_user_id');
    }

    // User yang meng-approve denda
    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by_user_id');
    }
}
