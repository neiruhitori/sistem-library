<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table ='bukus';
    protected $primaryKey = 'id';
    protected $fillable = ['judul', 'penulis', 'tipe', 'tahun_terbit', 'isbn', 'kota_cetak', 'description', 'foto'];
    protected $guarded = [];

    // Hapus user relationship - buku jadi global untuk semua user

    public function peminjamanHarianDetails()
    {
        return $this->hasManyThrough(
            PeminjamanHarianDetail::class,
            KodeBuku::class,
            'bukus_id', // Foreign key on kode_bukus table
            'kode_bukus_id', // Foreign key on peminjaman_harian_details table
            'id', // Local key on bukus table
            'id' // Local key on kode_bukus table
        );
    }

    public function peminjamanTahunanDetails()
    {
        return $this->hasManyThrough(
            PeminjamanTahunanDetail::class,
            KodeBuku::class,
            'bukus_id', // Foreign key on kode_bukus table
            'kode_bukus_id', // Foreign key on peminjaman_tahunan_details table
            'id', // Local key on bukus table
            'id' // Local key on kode_bukus table
        );
    }

    
    public function kodeBuku()
    {
        return $this->hasMany(KodeBuku::class, 'bukus_id');
    }
}
