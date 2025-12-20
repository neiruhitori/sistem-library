<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanHarianDetail extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_harian_details';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function peminjaman()
    {
        return $this->belongsTo(PeminjamanHarian::class, 'peminjaman_harians_id');
    }

    public function kodeBuku()
    {
        return $this->belongsTo(KodeBuku::class, 'kode_bukus_id');
    }
}
