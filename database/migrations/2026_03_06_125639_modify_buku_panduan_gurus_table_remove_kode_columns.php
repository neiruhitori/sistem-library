<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('buku_panduan_gurus', function (Blueprint $table) {
            // Drop kode_awal and kode_akhir columns (data sudah dipindah ke kode_panduan_gurus)
            $table->dropColumn(['kode_awal', 'kode_akhir']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku_panduan_gurus', function (Blueprint $table) {
            // Restore columns jika rollback
            $table->string('kode_awal')->nullable()->after('id');
            $table->string('kode_akhir')->nullable()->after('kode_awal');
        });
    }
};
