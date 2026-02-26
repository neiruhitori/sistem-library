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
        'tanggal_terima' => 'date',
    ];
}
