<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table ='bukus';
    protected $primaryKey = 'id';
    protected $fillable = [];
    protected $guarded = [];

    public function peminjamanHarianDetails()
    {
        return $this->hasMany(PeminjamanHarianDetail::class);
    }

    public function peminjamanTahunanDetails()
    {
        return $this->hasMany(PeminjamanTahunanDetail::class);
    }

    
    public function kodeBuku()
    {
        return $this->hasMany(KodeBuku::class, 'bukus_id');
    }
}
