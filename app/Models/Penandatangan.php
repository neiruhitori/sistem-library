<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penandatangan extends Model
{
    protected $table = 'penandatangans';
    protected $fillable = ['jabatan', 'nama', 'nip', 'is_active'];
    
    /**
     * Get active penandatangan by jabatan
     */
    public static function getActiveByJabatan($jabatan)
    {
        return self::where('jabatan', $jabatan)
            ->where('is_active', true)
            ->first();
    }
    
    /**
     * Set this penandatangan as active and deactivate others with same jabatan
     */
    public function setAsActive()
    {
        // Nonaktifkan semua penandatangan dengan jabatan yang sama
        self::where('jabatan', $this->jabatan)
            ->where('id', '!=', $this->id)
            ->update(['is_active' => false]);
        
        // Aktifkan penandatangan ini
        $this->update(['is_active' => true]);
    }
}
