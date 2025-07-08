<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table ='siswas';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function peminjamanHarian()
    {
        return $this->hasMany(PeminjamanHarian::class, 'siswas_id');
    }

    public function peminjamanTahunan()
    {
        return $this->hasMany(PeminjamanTahunan::class, 'siswas_id');
    }

    public function catatanDenda()
    {
        return $this->hasMany(CatatanDenda::class, 'siswas_id');
    }
}
