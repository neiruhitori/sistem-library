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
        Schema::table('siswas', function (Blueprint $table) {
            // Hapus kolom kelas karena sekarang ada di siswa_periodes
            if (Schema::hasColumn('siswas', 'kelas')) {
                $table->dropColumn('kelas');
            }
            
            // Hapus kolom absen karena sekarang ada di siswa_periodes
            if (Schema::hasColumn('siswas', 'absen')) {
                $table->dropColumn('absen');
            }
            
            // Tambahkan kolom untuk data identitas siswa
            if (!Schema::hasColumn('siswas', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable()->after('name');
            }
            
            if (!Schema::hasColumn('siswas', 'agama')) {
                $table->string('agama')->nullable()->after('jenis_kelamin');
            }
            
            // NISN harus unique
            $table->string('nisn')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Kembalikan kolom kelas dan absen
            $table->string('kelas')->nullable();
            $table->string('absen')->nullable();
            
            // Hapus kolom jenis_kelamin dan agama (jika baru ditambahkan)
            if (Schema::hasColumn('siswas', 'jenis_kelamin')) {
                $table->dropColumn('jenis_kelamin');
            }
            
            if (Schema::hasColumn('siswas', 'agama')) {
                $table->dropColumn('agama');
            }
        });
    }
};
