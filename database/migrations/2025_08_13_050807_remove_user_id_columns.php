<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menghapus kolom user_id dari tabel siswas dan bukus.
     * Data siswa dan buku menjadi global untuk semua user.
     * Hanya peminjaman yang tetap ter-isolasi per user.
     */
    public function up(): void
    {
        // Remove user_id from siswas table (jika ada)
        Schema::table('siswas', function (Blueprint $table) {
            // Cek apakah foreign key exists sebelum drop
            if (Schema::hasColumn('siswas', 'user_id')) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Foreign key mungkin tidak ada, skip
                }
                $table->dropColumn('user_id');
            }
        });

        // Remove user_id from bukus table (jika ada)
        Schema::table('bukus', function (Blueprint $table) {
            // Cek apakah foreign key exists sebelum drop
            if (Schema::hasColumn('bukus', 'user_id')) {
                try {
                    $table->dropForeign(['user_id']);
                } catch (\Exception $e) {
                    // Foreign key mungkin tidak ada, skip
                }
                $table->dropColumn('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore user_id to siswas table
        Schema::table('siswas', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()
                  ->after('id')
                  ->comment('User yang mengelola siswa');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });

        // Restore user_id to bukus table
        Schema::table('bukus', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()
                  ->after('id')
                  ->comment('User yang mengelola buku');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }
};
