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
        Schema::create('catatan_dendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswas_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->enum('tipe_peminjaman', ['harian', 'tahunan']);
            $table->unsignedBigInteger('referensi_id'); // ID dari detail pinjam
            $table->enum('jenis_denda', ['terlambat', 'hilang']);
            $table->integer('jumlah');
            $table->text('keterangan')->nullable();
            $table->date('tanggal_denda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catatan_dendas');
    }
};
