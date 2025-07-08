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
        Schema::create('peminjaman_harian_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_harians_id')->constrained('peminjaman_harians')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('bukus_id')->constrained('bukus')->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggal_dikembalikan')->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang'])->default('dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman_harian_details');
    }
};
