<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan kolom user_id ke tabel peminjaman_harians.
     * Setiap peminjaman harian akan ter-isolasi per user.
     */
    public function up(): void
    {
        Schema::table('peminjaman_harians', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->nullable()
                  ->after('id')
                  ->comment('User yang mengelola peminjaman')
                  ->constrained('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_harians', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
