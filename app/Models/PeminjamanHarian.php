<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanHarian extends Model
{
    use HasFactory;
    protected $table ='peminjaman_harians';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'siswas_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswas_id');
    }

    public function details()
    {
        return $this->hasMany(PeminjamanHarianDetail::class, 'peminjaman_harians_id');
    }
}
