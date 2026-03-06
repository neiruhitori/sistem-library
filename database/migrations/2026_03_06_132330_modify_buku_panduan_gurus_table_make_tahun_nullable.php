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
        Schema::table('buku_panduan_gurus', function (Blueprint $table) {
            // Make tahun column nullable
            $table->integer('tahun')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buku_panduan_gurus', function (Blueprint $table) {
            // Revert tahun to NOT NULL
            $table->integer('tahun')->nullable(false)->change();
        });
    }
};
