<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BukuPanduanGuru extends Model
{
    use HasFactory;
    
    protected $table = 'buku_panduan_gurus';
    protected $primaryKey = 'id';
    protected $fillable = ['penulis', 'judul', 'penerbit', 'tahun', 'is_active'];
    protected $guarded = [];

    /**
     * Relasi ke KodePanduanGuru (hasMany)
     */
    public function kodePanduanGuru()
    {
        return $this->hasMany(KodePanduanGuru::class, 'buku_panduan_guru_id');
    }

    /**
     * Relasi ke PeminjamanGuruDetail
     */
    public function peminjamanGuruDetails()
    {
        return $this->hasMany(PeminjamanGuruDetail::class, 'buku_panduan_guru_id');
    }
}
