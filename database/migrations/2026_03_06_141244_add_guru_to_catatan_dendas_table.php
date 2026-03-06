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
        Schema::table('catatan_dendas', function (Blueprint $table) {
            // Add guru_id column
            $table->foreignId('gurus_id')->nullable()->after('siswas_id')
                  ->constrained('gurus')->onUpdate('cascade')->onDelete('cascade');
            
            // Add peminjaman_gurus_id column
            $table->foreignId('peminjaman_gurus_id')->nullable()->after('peminjaman_tahunans_id')
                  ->constrained('peminjaman_gurus')->onUpdate('cascade')->onDelete('cascade');
        });

        // Modify enum to include 'guru'
        DB::statement("ALTER TABLE catatan_dendas MODIFY COLUMN tipe_peminjaman ENUM('harian', 'tahunan', 'guru')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_dendas', function (Blueprint $table) {
            $table->dropForeign(['gurus_id']);
            $table->dropForeign(['peminjaman_gurus_id']);
            $table->dropColumn(['gurus_id', 'peminjaman_gurus_id']);
        });

        // Revert enum back to original
        DB::statement("ALTER TABLE catatan_dendas MODIFY COLUMN tipe_peminjaman ENUM('harian', 'tahunan')");
    }
};
