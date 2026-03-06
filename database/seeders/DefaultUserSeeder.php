<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default user - Kepala Perpustakaan
        User::updateOrCreate(
            ['email' => 'nailulmaksudi@gmail.com'],
            [
                'name' => 'Umi Widarti, S.Pd.',
                'nip' => '196808102008012028',
                'email' => 'nailulmaksudi@gmail.com',
                'password' => Hash::make('196808102008012028'),
                'role' => 'Kepala Perpustakaan',
                'email_verified_at' => now(),
            ]
        );
    }
}
