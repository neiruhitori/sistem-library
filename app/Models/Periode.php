<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Periode extends Model
{
    use HasFactory;
    
    protected $table = 'periodes';
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'is_active',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date'
    ];
    
    /**
     * Relasi ke siswa periodes
     */
    public function siswaPeriodes()
    {
        return $this->hasMany(SiswaPeriode::class);
    }
    
    /**
     * Relasi ke siswa melalui siswa_periodes
     */
    public function siswas()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_periodes')
                    ->withPivot('kelas', 'absen', 'status')
                    ->withTimestamps();
    }
    
    /**
     * Scope untuk mendapatkan periode aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    /**
     * Method untuk set periode ini menjadi aktif
     * dan menonaktifkan periode lainnya
     */
    public function setAsActive()
    {
        // Nonaktifkan semua periode
        self::query()->update(['is_active' => false]);
        
        // Aktifkan periode ini
        $this->is_active = true;
        $this->save();
    }
    
    /**
     * Accessor untuk nama lengkap periode
     */
    public function getNamaLengkapAttribute()
    {
        return "{$this->tahun_ajaran} - Semester {$this->semester}";
    }
}
