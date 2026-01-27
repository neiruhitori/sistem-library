<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table ='siswas';
    protected $primaryKey = 'id';
    protected $fillable = ['nisn', 'name', 'jenis_kelamin', 'agama'];
    protected $guarded = [];

    /**
     * Relasi ke siswa periodes
     */
    public function siswaPeriodes()
    {
        return $this->hasMany(SiswaPeriode::class);
    }

    /**
     * Relasi ke siswa periode yang aktif
     */
    public function siswaPeriodeAktif()
    {
        return $this->hasOne(SiswaPeriode::class)
            ->whereHas('periode', function ($query) {
                $query->where('status', 'aktif');
            });
    }

    /**
     * Relasi ke periodes melalui siswa_periodes
     */
    public function periodes()
    {
        return $this->belongsToMany(Periode::class, 'siswa_periodes')
            ->withPivot('kelas', 'absen', 'status')
            ->withTimestamps();
    }

    /**
     * Mendapatkan data siswa untuk periode tertentu
     */
    public function getPeriodeData($periodeId)
    {
        return $this->siswaPeriodes()->where('periode_id', $periodeId)->first();
    }

    /**
     * Mendapatkan kelas siswa untuk periode tertentu
     */
    public function getKelasByPeriode($periodeId)
    {
        $data = $this->getPeriodeData($periodeId);
        return $data ? $data->kelas : null;
    }

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
