<?php

namespace App\Imports;

use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GuruImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    private $summary = [
        'total' => 0,
        'new' => 0,
        'updated' => 0,
        'skipped' => 0
    ];

    /**
     * Specify which row is the heading row
     */
    public function headingRow(): int
    {
        return 1; // Row 1 adalah header (NO, NIP, NAMA, TAMBAHAN TUGAS, KET.)
    }

    /**
     * Import data guru dari file Excel.
     */
    public function model(array $row)
    {
        // Ambil data dari Excel dengan berbagai variasi nama kolom
        $nipRaw = $row['nip'] ?? '';
        $nama = trim($row['nama'] ?? '');

        // Skip jika nama kosong
        if (empty($nama)) {
            return null;
        }

        // Format NIP - handle scientific notation dari Excel
        $nip = '';
        if (!empty($nipRaw)) {
            // Jika NIP adalah angka dalam scientific notation, convert ke string
            if (is_numeric($nipRaw)) {
                $nip = sprintf('%.0f', $nipRaw); // Convert float/scientific ke integer string
            } else {
                $nip = trim($nipRaw);
            }
        }

        // Ambil data lainnya - cek berbagai kemungkinan nama kolom
        $tambahanTugas = trim($row['tambahan_tugas'] ?? $row['tambahantugas'] ?? $row['tambahan_tugas'] ?? '');
        $keterangan = trim($row['ket'] ?? $row['keterangan'] ?? '');

        $this->summary['total']++;

        DB::beginTransaction();
        try {
            // Jika ada NIP, cari berdasarkan NIP
            $guru = null;
            if (!empty($nip)) {
                $guru = Guru::where('nip', $nip)->first();
            }

            // Jika tidak ada NIP atau tidak ditemukan, cari berdasarkan nama
            if (!$guru) {
                $guru = Guru::where('nama', $nama)->first();
            }

            if (!$guru) {
                // Guru belum ada -> Tambah guru baru
                Guru::create([
                    'nip' => $nip ?: null,
                    'nama' => $nama,
                    'tambahantugas' => $tambahanTugas ?: null,
                    'keterangan' => $keterangan ?: null,
                ]);

                $this->summary['new']++;
            } else {
                // Guru sudah ada -> Update
                $guru->update([
                    'nip' => $nip ?: $guru->nip,
                    'nama' => $nama,
                    'tambahantugas' => $tambahanTugas ?: $guru->tambahantugas,
                    'keterangan' => $keterangan ?: $guru->keterangan,
                ]);

                $this->summary['updated']++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error importing guru: ' . $e->getMessage());
        }

        return null; // Return null karena kita handle create/update manual
    }

    /**
     * Get import summary
     */
    public function getSummary()
    {
        return $this->summary;
    }
}
