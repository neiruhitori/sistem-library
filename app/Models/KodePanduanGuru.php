<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodePanduanGuru extends Model
{
    use HasFactory;
    
    protected $table = 'kode_panduan_gurus';
    protected $primaryKey = 'id';
    protected $fillable = ['buku_panduan_guru_id', 'kode_awal', 'kode_akhir', 'status'];
    protected $guarded = [];
    protected $attributes = [
        'status' => 'tersedia',
    ];

    /**
     * Relasi ke BukuPanduanGuru
     */
    public function bukuPanduanGuru()
    {
        return $this->belongsTo(BukuPanduanGuru::class, 'buku_panduan_guru_id');
    }

    /**
     * Relasi ke PeminjamanGuruDetail
     */
    public function peminjamanGuruDetails()
    {
        return $this->hasMany(PeminjamanGuruDetail::class, 'kode_panduan_guru_id');
    }
}
