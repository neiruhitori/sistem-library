<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Menambahkan kolom tracking user untuk sistem catatan denda:
     * - handled_by_user_id: User yang menangani pengembalian
     * - approved_by_user_id: User yang meng-approve denda
     */
    public function up(): void
    {
        Schema::table('catatan_dendas', function (Blueprint $table) {
            // Kolom tracking user
            $table->unsignedBigInteger('handled_by_user_id')->nullable()
                  ->after('status')
                  ->comment('User yang menangani pengembalian');
                  
            $table->unsignedBigInteger('approved_by_user_id')->nullable()
                  ->after('handled_by_user_id')
                  ->comment('User yang meng-approve denda');
            
            // Foreign key constraints
            $table->foreign('handled_by_user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
                  
            $table->foreign('approved_by_user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('catatan_dendas', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['handled_by_user_id']);
            $table->dropForeign(['approved_by_user_id']);
            
            // Drop columns
            $table->dropColumn(['handled_by_user_id', 'approved_by_user_id']);
        });
    }
};
