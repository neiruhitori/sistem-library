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
        Schema::table('bukus', function (Blueprint $table) {
            // Remove isbn and kota_cetak columns
            $table->dropColumn(['isbn', 'kota_cetak']);
            
            // Add penerbit_id as foreign key to penerimaan_barangs table
            $table->foreignId('penerbit_id')->nullable()->after('penulis')
                ->constrained('penerimaan_barangs')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            // Drop foreign key and penerbit_id column
            $table->dropForeign(['penerbit_id']);
            $table->dropColumn('penerbit_id');
            
            // Re-add isbn and kota_cetak columns
            $table->string('isbn')->nullable()->after('tahun_terbit');
            $table->string('kota_cetak')->nullable()->after('isbn');
        });
    }
};
