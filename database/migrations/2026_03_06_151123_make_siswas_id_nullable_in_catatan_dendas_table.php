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
        // Drop foreign key first
        Schema::table('catatan_dendas', function (Blueprint $table) {
            $table->dropForeign(['siswas_id']);
        });

        // Modify column to nullable
        DB::statement('ALTER TABLE catatan_dendas MODIFY siswas_id BIGINT UNSIGNED NULL');

        // Re-add foreign key
        Schema::table('catatan_dendas', function (Blueprint $table) {
            $table->foreign('siswas_id')->references('id')->on('siswas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key
        Schema::table('catatan_dendas', function (Blueprint $table) {
            $table->dropForeign(['siswas_id']);
        });

        // Revert to NOT NULL
        DB::statement('ALTER TABLE catatan_dendas MODIFY siswas_id BIGINT UNSIGNED NOT NULL');

        // Re-add foreign key
        Schema::table('catatan_dendas', function (Blueprint $table) {
            $table->foreign('siswas_id')->references('id')->on('siswas')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }
};
