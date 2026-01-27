<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\SiswaPeriode;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;

class SiswaImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    private $periodeId;
    private $summary = [
        'total' => 0,
        'new' => 0,
        'updated' => 0,
        'skipped' => 0
    ];

    public function __construct($periodeId)
    {
        $this->periodeId = $periodeId;
    }

    /**
     * Specify which row is the heading row
     */
    public function headingRow(): int
    {
        return 5; // Row 5 adalah header (URUT, ABSEN, KELAS, NIS, NISN, NAMA, L/P, AGAMA)
    }

    /**
     * Import data siswa dari file Excel dengan logika periode.
     * 
     * Logika:
     * 1. NISN belum ada di tabel siswas -> Tambah siswa baru + data periode
     * 2. NISN ada tapi belum di periode aktif -> Tambah data periode (kenaikan kelas)
     * 3. NISN ada dan sudah di periode aktif:
     *    - Jika kelas berbeda -> Update kelas
     *    - Jika kelas sama -> Skip
     */
    public function model(array $row)
    {
        // Ambil data dari Excel
        $name = trim($row['nama'] ?? '');
        $kelas = trim($row['kelas'] ?? '');

        // Skip jika nama atau kelas kosong
        if (empty($name) || empty($kelas)) {
            return null;
        }

        // Ambil data lainnya
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
            $jenisKelamin = 'L'; // Default
        }

        // NISN harus ada
        if (empty($nisn)) {
            return null;
        }

        $this->summary['total']++;

        // Cari siswa berdasarkan NISN
        $siswa = Siswa::where('nisn', $nisn)->first();

        DB::beginTransaction();
        try {
            if (!$siswa) {
                // CASE 1: NISN belum ada -> Tambah siswa baru + data periode
                $siswa = Siswa::create([
                    'nisn' => $nisn,
                    'name' => $name,
                    'jenis_kelamin' => $jenisKelamin,
                    'agama' => $agama ?: null,
                ]);

                SiswaPeriode::create([
                    'siswa_id' => $siswa->id,
                    'periode_id' => $this->periodeId,
                    'kelas' => $kelas,
                    'absen' => $absen ?: null,
                    'status' => 'Aktif'
                ]);

                $this->summary['new']++;
            } else {
                // CASE 2 & 3: NISN sudah ada
                // Cek apakah sudah terdaftar di periode ini
                $siswaPeriode = SiswaPeriode::where('siswa_id', $siswa->id)
                    ->where('periode_id', $this->periodeId)
                    ->first();

                if (!$siswaPeriode) {
                    // CASE 2: Belum di periode aktif -> Tambah data periode baru (kenaikan kelas)
                    SiswaPeriode::create([
                        'siswa_id' => $siswa->id,
                        'periode_id' => $this->periodeId,
                        'kelas' => $kelas,
                        'absen' => $absen ?: null,
                        'status' => 'Aktif'
                    ]);

                    $this->summary['new']++;
                } else {
                    // CASE 3: Sudah di periode aktif
                    if ($siswaPeriode->kelas != $kelas) {
                        // Kelas berbeda -> Update
                        $siswaPeriode->update([
                            'kelas' => $kelas,
                            'absen' => $absen ?: $siswaPeriode->absen
                        ]);

                        $this->summary['updated']++;
                    } else {
                        // Kelas sama -> Skip (tidak duplikat)
                        $this->summary['skipped']++;
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error importing siswa: ' . $e->getMessage());
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
