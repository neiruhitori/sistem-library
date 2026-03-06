<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanGuru extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_gurus';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'guru_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function details()
    {
        return $this->hasMany(PeminjamanGuruDetail::class);
    }
}
