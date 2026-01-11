<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Auth;

class SiswaImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
     * Import data siswa dari file Excel.
     */
    public function model(array $row)
    {
        // Skip baris jika kolom penting kosong
        $name = trim($row['name'] ?? '');
        $kelas = trim($row['kelas'] ?? '');

        // Jika name atau kelas kosong, skip baris ini
        if (empty($name) || empty($kelas)) {
            return null;
        }

        $nisn = trim($row['nisn'] ?? null);

        // Jika ada NISN yang bertuliskan "Tidak ada NISN", ubah jadi null
        if (strtolower($nisn) === 'tidak ada nisn') {
            $nisn = null;
        }

        return new Siswa([
            'user_id' => Auth::id(),
            'nisn'  => $nisn,
            'name'  => $name,
            'kelas' => $kelas,
        ]);
    }
}
