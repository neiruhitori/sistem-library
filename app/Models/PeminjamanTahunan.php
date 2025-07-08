<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanTahunan extends Model
{
    use HasFactory;
    protected $table ='peminjaman_tahunan';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }

    public function details()
    {
        return $this->hasMany(PeminjamanTahunanDetail::class, 'peminjaman_tahunans_id');
    }
}
