<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update peminjaman_harian_details
        DB::statement("ALTER TABLE peminjaman_harian_details MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'hilang', 'rusak') DEFAULT 'dipinjam'");
        
        // Update peminjaman_tahunan_details
        DB::statement("ALTER TABLE peminjaman_tahunan_details MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'hilang', 'rusak') DEFAULT 'dipinjam'");
        
        // Update catatan_dendas
        DB::statement("ALTER TABLE catatan_dendas MODIFY COLUMN jenis_denda ENUM('terlambat', 'hilang', 'rusak')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert peminjaman_harian_details
        DB::statement("ALTER TABLE peminjaman_harian_details MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'hilang') DEFAULT 'dipinjam'");
        
        // Revert peminjaman_tahunan_details
        DB::statement("ALTER TABLE peminjaman_tahunan_details MODIFY COLUMN status ENUM('dipinjam', 'dikembalikan', 'hilang') DEFAULT 'dipinjam'");
        
        // Revert catatan_dendas
        DB::statement("ALTER TABLE catatan_dendas MODIFY COLUMN jenis_denda ENUM('terlambat', 'hilang')");
    }
};
