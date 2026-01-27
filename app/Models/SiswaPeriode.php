<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SiswaPeriode extends Model
{
    use HasFactory;
    
    protected $table = 'siswa_periodes';
    protected $fillable = [
        'siswa_id',
        'periode_id',
        'kelas',
        'absen',
        'status'
    ];
    
    /**
     * Relasi ke siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
    
    /**
     * Relasi ke periode
     */
    public function periode()
    {
        return $this->belongsTo(Periode::class);
    }
    
    /**
     * Scope untuk status aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
}
