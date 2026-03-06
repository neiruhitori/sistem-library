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
        Schema::table('peminjaman_guru_details', function (Blueprint $table) {
            // Add kode_panduan_guru_id column
            $table->foreignId('kode_panduan_guru_id')->nullable()->after('buku_panduan_guru_id')
                  ->constrained('kode_panduan_gurus')->onUpdate('cascade')->onDelete('cascade');
            
            // Add status and tanggal_dikembalikan columns
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang'])->default('dipinjam')->after('kode_panduan_guru_id');
            $table->date('tanggal_dikembalikan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman_guru_details', function (Blueprint $table) {
            $table->dropForeign(['kode_panduan_guru_id']);
            $table->dropColumn(['kode_panduan_guru_id', 'status', 'tanggal_dikembalikan']);
        });
    }
};
