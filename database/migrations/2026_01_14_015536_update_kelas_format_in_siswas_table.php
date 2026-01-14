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
        // Update existing data: VII A -> 7A, VIII B -> 8B, IX C -> 9C
        DB::statement("UPDATE siswas SET kelas = REPLACE(REPLACE(REPLACE(kelas, ' ', ''), 'VII', '7'), 'VIII', '8') WHERE kelas LIKE 'VII%'");
        DB::statement("UPDATE siswas SET kelas = REPLACE(REPLACE(kelas, ' ', ''), 'VIII', '8') WHERE kelas LIKE 'VIII%'");
        DB::statement("UPDATE siswas SET kelas = REPLACE(REPLACE(kelas, ' ', ''), 'IX', '9') WHERE kelas LIKE 'IX%'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse: 7A -> VII A, 8B -> VIII B, 9C -> IX C
        DB::statement("UPDATE siswas SET kelas = CONCAT('VII ', SUBSTRING(kelas, 2)) WHERE kelas LIKE '7%'");
        DB::statement("UPDATE siswas SET kelas = CONCAT('VIII ', SUBSTRING(kelas, 2)) WHERE kelas LIKE '8%'");
        DB::statement("UPDATE siswas SET kelas = CONCAT('IX ', SUBSTRING(kelas, 2)) WHERE kelas LIKE '9%'");
    }
};
