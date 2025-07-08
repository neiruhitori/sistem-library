<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanHarian extends Model
{
    use HasFactory;
    protected $table ='peminjaman_harians';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(siswa::class, 'siswas_id');
    }

    public function details()
    {
        return $this->hasMany(PeminjamanHarianDetail::class, 'peminjaman_harians_id');
    }
}
