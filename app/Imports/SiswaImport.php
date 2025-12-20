<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class SiswaImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * Import data siswa dari file Excel.
     */
    public function model(array $row)
    {
        $nisn = trim($row['nisn'] ?? null);

        // Jika ada NISN yang bertuliskan "Tidak ada NISN", ubah jadi null
        if (strtolower($nisn) === 'tidak ada nisn') {
            $nisn = null;
        }

        return new Siswa([
            'user_id' => Auth::id(),
            'nisn'  => $nisn,
            'name'  => trim($row['name']),
            'kelas' => trim($row['kelas']),
        ]);
    }

    /**
     * Validasi agar 'name' dan 'kelas' tidak kosong.
     */
    public function rules(): array
    {
        return [
            '*.name'  => ['required'],
            '*.kelas' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            '*.name.required'  => 'Kolom nama tidak boleh kosong.',
            '*.kelas.required' => 'Kolom kelas tidak boleh kosong.',
        ];
    }
}
