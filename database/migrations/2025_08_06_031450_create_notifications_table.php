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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'peminjaman_harian' atau 'peminjaman_tahunan'
            $table->unsignedBigInteger('reference_id'); // ID dari peminjaman
            $table->string('title'); // Judul notifikasi
            $table->text('message'); // Pesan notifikasi
            $table->string('icon')->default('fas fa-book'); // Icon untuk notifikasi
            $table->boolean('is_read')->default(false); // Status sudah dibaca atau belum
            $table->timestamps();
            
            // Index untuk performa
            $table->index(['is_read', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
