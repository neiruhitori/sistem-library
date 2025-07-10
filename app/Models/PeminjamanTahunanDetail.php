<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanTahunanDetail extends Model
{
    use HasFactory;
    protected $table ='peminjaman_tahunan_details';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

     public function peminjaman()
    {
        return $this->belongsTo(PeminjamanTahunan::class, 'peminjaman_tahunans_id');
    }

    public function kodeBuku()
    {
        return $this->belongsTo(KodeBuku::class, 'kode_bukus_id');
    }
}
