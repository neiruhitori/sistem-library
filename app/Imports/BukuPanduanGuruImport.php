<?php

namespace App\Imports;

use App\Models\BukuPanduanGuru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipEmptyRows;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BukuPanduanGuruImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    private $summary = [
        'total' => 0,
        'new' => 0,
        'updated' => 0,
        'skipped' => 0
    ];

    private $processedRows = []; // Track processed rows untuk cek duplikasi dalam file yang sama

    /**
     * Specify which row is the heading row
     */
    public function headingRow(): int
    {
        return 4; // Row 4 adalah header (NO, Kode Awal, Kode Akhir, Penulis, Judul Buku, Penerbit, Tahun)
    }

    /**
     * Import data buku panduan guru dari file Excel.
     */
    public function model(array $row)
    {
        // Ambil data dari Excel
        $kodeAwal = trim($row['kode_awal'] ?? '');
        $kodeAkhir = trim($row['kode_akhir'] ?? '');
        $penulis = trim($row['penulis'] ?? '');
        $judul = trim($row['judul_buku'] ?? '');
        $penerbit = trim($row['penerbit'] ?? '');
        $tahun = trim($row['tahun'] ?? '');

        // Skip jika judul kosong
        if (empty($judul)) {
            return null;
        }

        // Cek duplikasi dalam file Excel yang sama (satu baris data sama)
        $rowKey = $kodeAwal . '|' . $kodeAkhir . '|' . $judul . '|' . $penulis . '|' . $penerbit . '|' . $tahun;
        if (isset($this->processedRows[$rowKey])) {
            // Data duplikat di dalam file Excel yang sama, skip
            $this->summary['skipped']++;
            Log::info('Skipped duplicate row in import file: ' . $rowKey);
            return null;
        }

        $this->summary['total']++;
        
        // Mark row as processed
        $this->processedRows[$rowKey] = true;

        DB::beginTransaction();
        try {
            // Convert tahun to null if empty
            $tahunValue = !empty($tahun) ? (int)$tahun : null;

            // Cari buku berdasarkan judul, penulis, penerbit, tahun (exact match including NULL)
            $query = BukuPanduanGuru::where('judul', $judul)
                ->where('penulis', $penulis)
                ->where('penerbit', $penerbit);
            
            // Handle NULL tahun comparison
            if ($tahunValue === null) {
                $query->whereNull('tahun');
            } else {
                $query->where('tahun', $tahunValue);
            }
            
            $buku = $query->first();

            if (!$buku) {
                // Buku belum ada -> Buat buku baru
                $buku = BukuPanduanGuru::create([
                    'penulis' => $penulis,
                    'judul' => $judul,
                    'penerbit' => $penerbit,
                    'tahun' => $tahunValue,
                ]);

                // Tambahkan kode panduan guru
                $buku->kodePanduanGuru()->create([
                    'kode_awal' => $kodeAwal,
                    'kode_akhir' => $kodeAkhir,
                ]);

                $this->summary['new']++;
            } else {
                // Buku sudah ada -> Cek apakah kode ini sudah ada
                $kodeExists = $buku->kodePanduanGuru()
                    ->where('kode_awal', $kodeAwal)
                    ->where('kode_akhir', $kodeAkhir)
                    ->exists();

                if (!$kodeExists) {
                    // Kode belum ada -> Tambahkan kode baru
                    $buku->kodePanduanGuru()->create([
                        'kode_awal' => $kodeAwal,
                        'kode_akhir' => $kodeAkhir,
                    ]);

                    $this->summary['updated']++;
                } else {
                    // Kode sudah ada -> Skip
                    $this->summary['skipped']++;
                    Log::info('Skipped existing kode for buku ID ' . $buku->id . ': ' . $kodeAwal . ' - ' . $kodeAkhir);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error importing buku panduan guru: ' . $e->getMessage());
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
