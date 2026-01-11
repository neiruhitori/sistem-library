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
        Schema::create('penandatangans', function (Blueprint $table) {
            $table->id();
            $table->enum('jabatan', ['kepala_perpustakaan', 'kepala_sekolah']); // Jabatan penandatangan
            $table->string('nama'); // Nama penandatangan
            $table->string('nip'); // NIP penandatangan
            $table->boolean('is_active')->default(false); // Status digunakan atau tidak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penandatangans');
    }
};
