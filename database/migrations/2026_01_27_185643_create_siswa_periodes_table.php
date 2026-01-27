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
        Schema::create('siswa_periodes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('periode_id')->constrained('periodes')->onDelete('cascade');
            $table->string('kelas');
            $table->string('absen')->nullable();
            $table->enum('status', ['Aktif', 'Tidak Aktif', 'Lulus', 'Pindah'])->default('Aktif');
            $table->timestamps();
            
            // Unique constraint untuk mencegah siswa terdaftar 2x di periode yang sama
            $table->unique(['siswa_id', 'periode_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa_periodes');
    }
};
