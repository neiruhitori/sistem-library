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
        Schema::create('buku_panduan_gurus', function (Blueprint $table) {
            $table->id();
            $table->string('kode_awal');
            $table->string('kode_akhir');
            $table->string('penulis');
            $table->string('judul');
            $table->string('penerbit');
            $table->integer('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_panduan_gurus');
    }
};
