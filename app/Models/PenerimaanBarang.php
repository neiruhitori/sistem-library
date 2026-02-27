<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenerimaanBarang extends Model
{
    use HasFactory;
    
    protected $table = 'penerimaan_barangs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tanggal_terima',
        'nama_pengarang',
        'penerbit',
        'nama_barang',
        'tahun'
    ];
    protected $guarded = [];
    
    protected $casts = [
        // tanggal_terima as string to allow '-' value from import
    ];

    /**
     * Get formatted tanggal_terima for display
     */
    public function getTanggalTerimaFormattedAttribute()
    {
        if ($this->tanggal_terima === '-' || empty($this->tanggal_terima)) {
            return '-';
        }

        try {
            return \Carbon\Carbon::parse($this->tanggal_terima)->format('d/m/Y');
        } catch (\Exception $e) {
            return $this->tanggal_terima;
        }
    }
}
