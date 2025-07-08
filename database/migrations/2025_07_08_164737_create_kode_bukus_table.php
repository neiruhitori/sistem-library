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
        Schema::create('kode_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bukus_id')->constrained('bukus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kode_buku')->unique();
            $table->enum('status', ['tersedia', 'dipinjam'])->default('tersedia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_bukus');
    }
};
