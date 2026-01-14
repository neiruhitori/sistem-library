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
     * Specify which row is the heading row
     */
    public function headingRow(): int
    {
        return 5; // Row 5 adalah header (URUT, ABSEN, KELAS, NIS, NISN, NAMA, L/P, AGAMA)
    }

    /**
     * Import data siswa dari file Excel.
     * Logic: Jika NISN sudah ada -> UPDATE, jika belum ada -> INSERT
     */
    public function model(array $row)
    {
        // Debug: log semua key dari row (hanya sekali untuk row pertama)
        if (!isset($this->logged)) {
            \Log::info('Excel Headers: ' . implode(', ', array_keys($row)));
            $this->logged = true;
        }

        // Ambil nama dan kelas
        $name = trim($row['nama'] ?? '');
        $kelas = trim($row['kelas'] ?? '');

        // Jika name atau kelas kosong, skip baris ini
        if (empty($name) || empty($kelas)) {
            return null;
        }

        // Ambil data dari kolom Excel
        $absen = trim($row['absen'] ?? $row['urut'] ?? '');
        $nisnSekolah = trim($row['nis'] ?? '');
        $nisnNasional = trim($row['nisn'] ?? '');
        $jenisKelamin = strtoupper(trim($row['lp'] ?? ''));
        $agama = trim($row['agama'] ?? '');

        // Convert old format (VII A) to new format (7A) for kelas
        $kelas = str_replace(' ', '', $kelas);
        $kelas = str_replace(['VII', 'VIII', 'IX'], ['7', '8', '9'], $kelas);

        // Merge NISN sekolah dan nasional
        $nisn = null;
        if ($nisnSekolah || $nisnNasional) {
            $nisn = $nisnSekolah . ' / ' . $nisnNasional;
            $nisn = trim($nisn, ' /');
        }

        // Validate jenis kelamin
        if (!in_array($jenisKelamin, ['L', 'P'])) {
            $jenisKelamin = null;
        }

        // Data untuk insert/update
        $data = [
            'absen' => $absen ?: null,
            'name' => $name,
            'jenis_kelamin' => $jenisKelamin,
            'agama' => $agama ?: null,
            'nisn' => $nisn,
            'kelas' => $kelas,
        ];

        // Upsert: Update jika NISN ada, Insert jika NISN tidak ada
        if (!empty($nisn)) {
            $siswa = Siswa::where('nisn', $nisn)->first();

            if ($siswa) {
                // NISN sudah ada -> UPDATE
                $siswa->update($data);
                return null; // Return null karena sudah di-update manual
            }
        }

        // NISN tidak ada atau NISN kosong -> INSERT baru
        return new Siswa($data);
    }

    private $logged = false;
}
