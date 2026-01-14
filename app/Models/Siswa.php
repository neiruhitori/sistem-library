<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table ='siswas';
    protected $primaryKey = 'id';
    protected $fillable = ['nisn', 'name', 'jenis_kelamin', 'agama', 'kelas', 'absen'];
    protected $guarded = [];

    // Hapus user relationship - siswa jadi global untuk semua user

    public function peminjamanHarian()
    {
        return $this->hasMany(PeminjamanHarian::class, 'siswas_id');
    }

    public function peminjamanHarianDetails()
    {
        return $this->hasManyThrough(
            PeminjamanHarianDetail::class,
            PeminjamanHarian::class,
            'siswas_id', // Foreign key on PeminjamanHarian table
            'peminjaman_harians_id', // Foreign key on PeminjamanHarianDetail table
            'id', // Local key on Siswa table
            'id' // Local key on PeminjamanHarian table
        );
    }

    public function peminjamanTahunan()
    {
        return $this->hasMany(PeminjamanTahunan::class, 'siswas_id');
    }

    public function peminjamanTahunanDetails()
    {
        return $this->hasManyThrough(
            PeminjamanTahunanDetail::class,
            PeminjamanTahunan::class,
            'siswas_id', // Foreign key on PeminjamanTahunan table
            'peminjaman_tahunans_id', // Foreign key on PeminjamanTahunanDetail table
            'id', // Local key on Siswa table
            'id' // Local key on PeminjamanTahunan table
        );
    }

    public function catatanDenda()
    {
        return $this->hasMany(CatatanDenda::class, 'siswas_id');
    }
}
