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
        Schema::create('peminjaman_guru_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_guru_id')->constrained('peminjaman_gurus')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('buku_panduan_guru_id')->constrained('buku_panduan_gurus')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_guru_details');
    }
};
