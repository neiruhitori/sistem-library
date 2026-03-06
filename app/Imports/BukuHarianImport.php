<?php

namespace App\Imports;

use App\Models\Buku;
use App\Models\KodeBuku;
use App\Models\PenerimaanBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BukuHarianImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    private $summary = [
        'total' => 0,
        'success' => 0,
        'failed' => 0,
        'duplicate' => 0
    ];

    /**
     * Specify which row is the heading row
     */
    public function headingRow(): int
    {
        return 4; // Row 4 is the header row (No., Kode Awal, Kode Akhir, Penulis, Judul Buku, Penerbit, Tahun)
    }

    /**
     * Import data buku harian dari file Excel
     */
    public function model(array $row)
    {
        // Normalisasi nama field (lowercase dan trim)
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map(function($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);
        
        // Mapping field Excel ke database
        $kodeAwalKey = 'kode_awal';
        $kodeAkhirKey = 'kode_akhir';
        $penulisKey = 'penulis';
        $judulBukuKey = 'judul_buku';
        $penerbitKey = 'penerbit';
        $tahunKey = 'tahun';

        // Check if this is a completely empty row
        $hasAnyData = false;
        foreach ([$kodeAwalKey, $kodeAkhirKey, $penulisKey, $judulBukuKey, $penerbitKey, $tahunKey] as $key) {
            if (isset($row[$key]) && $row[$key] !== null && $row[$key] !== '' && $row[$key] !== '-') {
                $hasAnyData = true;
                break;
            }
        }

        // Skip completely empty rows
        if (!$hasAnyData) {
            return null;
        }

        $this->summary['total']++;

        try {
            // Ambil dan normalize data - convert empty to "-"
            $kodeAwal = $this->normalizeValue($row[$kodeAwalKey] ?? null);
            $kodeAkhir = $this->normalizeValue($row[$kodeAkhirKey] ?? null);
            $penulis = $this->normalizeValue($row[$penulisKey] ?? null);
            $judulBuku = trim($row[$judulBukuKey] ?? '');
            $penerbitName = $this->normalizeValue($row[$penerbitKey] ?? null);
            $tahun = $this->normalizeValue($row[$tahunKey] ?? null);

            // Validasi tahun jika ada
            if ($tahun !== '-' && !empty($tahun)) {
                $yearValue = (int) $tahun;
                if ($yearValue < 1900 || $yearValue > (date('Y') + 1)) {
                    $tahun = '-';
                }
            }

            // Judul buku tidak boleh kosong
            if (empty($judulBuku)) {
                $this->summary['failed']++;
                Log::warning('Judul buku kosong pada row', ['row_data' => $row]);
                return null;
            }

            // Generate kode_buku
            $kodeBuku = null;
            if ($kodeAwal !== '-' || $kodeAkhir !== '-') {
                if ($kodeAwal !== '-' && $kodeAkhir !== '-') {
                    $kodeBuku = $kodeAwal . ' - ' . $kodeAkhir;
                } else {
                    $kodeBuku = $kodeAwal !== '-' ? $kodeAwal : $kodeAkhir;
                }
            }

            // Jika tidak ada kode buku, skip
            if (empty($kodeBuku)) {
                $this->summary['failed']++;
                Log::warning('Kode buku kosong pada row', ['judul' => $judulBuku, 'row_data' => $row]);
                return null;
            }

            // Check if kode_buku already exists
            $existingKodeBuku = KodeBuku::where('kode_buku', $kodeBuku)->first();
            if ($existingKodeBuku) {
                $this->summary['duplicate']++;
                Log::info('Kode buku duplikat di-skip', ['kode_buku' => $kodeBuku, 'judul' => $judulBuku]);
                return null;
            }

            // Find or create penerbit
            $penerbitId = null;
            if ($penerbitName !== '-') {
                // Try to find existing penerbit
                $penerbit = PenerimaanBarang::where('penerbit', $penerbitName)->first();
                
                // If not found, create new penerbit entry
                if (!$penerbit) {
                    $penerbit = PenerimaanBarang::create([
                        'tanggal_terima' => '-',
                        'nama_pengarang' => '-',
                        'penerbit' => $penerbitName,
                        'nama_barang' => '-',
                        'tahun' => '-'
                    ]);
                    Log::info('Penerbit baru dibuat otomatis', ['penerbit' => $penerbitName]);
                }
                
                $penerbitId = $penerbit->id;
            }

            DB::beginTransaction();
            try {
                // Check if book with same title, penulis, penerbit, and tahun already exists
                $query = Buku::where('judul', $judulBuku)
                    ->where('tipe', 'harian');
                
                // Check penulis (handle both null and "-")
                if ($penulis !== '-') {
                    $query->where('penulis', $penulis);
                } else {
                    $query->whereNull('penulis');
                }
                
                // Check penerbit_id
                if ($penerbitId) {
                    $query->where('penerbit_id', $penerbitId);
                } else {
                    $query->whereNull('penerbit_id');
                }
                
                // Check tahun_terbit (handle both null and "-")
                if ($tahun !== '-') {
                    $query->where('tahun_terbit', $tahun);
                } else {
                    $query->whereNull('tahun_terbit');
                }
                
                $buku = $query->first();

                if (!$buku) {
                    // Create new book
                    $buku = Buku::create([
                        'judul' => $judulBuku,
                        'penulis' => $penulis !== '-' ? $penulis : null,
                        'penerbit_id' => $penerbitId,
                        'tipe' => 'harian',
                        'kelas' => null,
                        'tahun_terbit' => $tahun !== '-' ? $tahun : null,
                        'description' => null,
                        'foto' => 'sampulbuku/bukuharian.png',
                        'is_active' => true
                    ]);
                }

                // Create kode_buku
                KodeBuku::create([
                    'bukus_id' => $buku->id,
                    'kode_buku' => $kodeBuku,
                    'status' => 'tersedia'
                ]);

                DB::commit();
                $this->summary['success']++;
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            $this->summary['failed']++;
            Log::error('Error importing row', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'judul_buku' => $row[$judulBukuKey] ?? 'unknown',
                'row_data' => $row
            ]);
            return null;
        }

        return null;
    }

    /**
     * Normalize field value - convert empty, "-", "~" to "-"
     */
    private function normalizeValue($value)
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if (is_string($value)) {
            $value = trim($value);
            if ($value === '' || $value === '-' || $value === '~') {
                return '-';
            }
        }

        return $value;
    }

    /**
     * Get import summary
     */
    public function getSummary()
    {
        return $this->summary;
    }
}
