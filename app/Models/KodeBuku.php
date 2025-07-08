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
}
