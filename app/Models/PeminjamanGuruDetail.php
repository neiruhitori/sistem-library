<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanGuruDetail extends Model
{
    use HasFactory;
    protected $table = 'peminjaman_guru_details';
    protected $primaryKey = 'id';
    protected $fillable = ['peminjaman_guru_id', 'buku_panduan_guru_id', 'kode_panduan_guru_id', 'status', 'tanggal_dikembalikan'];
    protected $guarded = [];
    protected $attributes = [
        'status' => 'dipinjam',
    ];

    public function peminjamanGuru()
    {
        return $this->belongsTo(PeminjamanGuru::class);
    }

    public function bukuPanduanGuru()
    {
        return $this->belongsTo(BukuPanduanGuru::class);
    }

    public function kodePanduanGuru()
    {
        return $this->belongsTo(KodePanduanGuru::class);
    }
}
