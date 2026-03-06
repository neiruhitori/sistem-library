<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $table = 'gurus';
    protected $primaryKey = 'id';
    protected $fillable = ['nip', 'nama', 'tambahantugas', 'keterangan', 'status'];
    protected $guarded = [];

    public function peminjamanGurus()
    {
        return $this->hasMany(PeminjamanGuru::class);
    }
}
