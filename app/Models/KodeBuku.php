<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KodeBuku extends Model
{
    use HasFactory;
    protected $table = 'kode_bukus';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'bukus_id');
    }

    public function detailPeminjamanHarian()
    {
        return $this->hasMany(\App\Models\PeminjamanHarianDetail::class, 'kode_bukus_id');
    }

    public function detailPeminjamanTahunan()
    {
        return $this->hasMany(\App\Models\PeminjamanTahunanDetail::class, 'kode_bukus_id');
    }
}
