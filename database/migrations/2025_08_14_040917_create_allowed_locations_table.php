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
        Schema::create('allowed_locations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama lokasi (contoh: "SMPN 02 Klakah")
            $table->decimal('latitude', 10, 8); // Koordinat latitude
            $table->decimal('longitude', 11, 8); // Koordinat longitude
            $table->integer('radius_meters')->default(200); // Radius dalam meter
            $table->boolean('is_active')->default(true); // Status aktif/nonaktif
            $table->text('description')->nullable(); // Deskripsi tambahan
            $table->timestamps();
        });

        // Insert data SMPN 02 Klakah (koordinat contoh, perlu disesuaikan dengan lokasi sebenarnya)
        DB::table('allowed_locations')->insert([
            'name' => 'SMPN 02 Klakah',
            'latitude' => -8.1234567, // Ganti dengan koordinat sebenarnya
            'longitude' => 113.7890123, // Ganti dengan koordinat sebenarnya
            'radius_meters' => 200,
            'is_active' => true,
            'description' => 'Area sekolah SMPN 02 Klakah dan sekitarnya',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowed_locations');
    }
};
