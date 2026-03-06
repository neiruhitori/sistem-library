<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create kode_panduan_gurus table
        Schema::create('kode_panduan_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buku_panduan_guru_id')
                  ->constrained('buku_panduan_gurus')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('kode_awal')->nullable();
            $table->string('kode_akhir')->nullable();
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['kode_awal', 'kode_akhir']);
        });

        // Migrate existing data from buku_panduan_gurus to kode_panduan_gurus
        $existingBukus = DB::table('buku_panduan_gurus')->get();
        
        foreach ($existingBukus as $buku) {
            DB::table('kode_panduan_gurus')->insert([
                'buku_panduan_guru_id' => $buku->id,
                'kode_awal' => $buku->kode_awal,
                'kode_akhir' => $buku->kode_akhir,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_panduan_gurus');
    }
};
