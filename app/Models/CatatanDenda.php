<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanDenda extends Model
{
    use HasFactory;
    protected $table = 'catatan_dendas';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanHarian::class, 'peminjaman_harians_id');
    }

    public function peminjamantahunan()
    {
        return $this->belongsTo(PeminjamanTahunan::class, 'peminjaman_tahunans_id');
    }
}
