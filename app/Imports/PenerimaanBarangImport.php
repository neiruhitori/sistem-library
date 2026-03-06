<?php

namespace App\Imports;

use App\Models\PenerimaanBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PenerimaanBarangImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
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
        return 4; // Row 4 is the header row
    }

    /**
     * Import data penerimaan barang dari file Excel
     */
    public function model(array $row)
    {
        // Normalisasi nama field (lowercase dan trim)
        $row = array_change_key_case($row, CASE_LOWER);
        $row = array_map(function($value) {
            return is_string($value) ? trim($value) : $value;
        }, $row);
        
        // Mapping field Excel ke database
        // Excel header: "Tanggal Terima Barang" -> Excel key: "tanggal_terima_barang"
        $tanggalTerimaKey = 'tanggal_terima_barang';
        $namaPengarangKey = 'nama_pengarang';
        $penerbitKey = 'penerbit';
        $namaBarangKey = 'nama_barang';
        $tahunKey = 'tahun';

        // Check if this is a completely empty row (all fields empty or non-existent)
        $hasAnyData = false;
        foreach ([$tanggalTerimaKey, $namaPengarangKey, $penerbitKey, $namaBarangKey, $tahunKey] as $key) {
            if (isset($row[$key]) && $row[$key] !== null && $row[$key] !== '' && $row[$key] !== '-' && $row[$key] !== '~') {
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
            // Parse tanggal - set default to "-" if empty
            $tanggalTerima = '-';
            if (isset($row[$tanggalTerimaKey]) && $row[$tanggalTerimaKey] !== null && $row[$tanggalTerimaKey] !== '' && $row[$tanggalTerimaKey] !== '-' && $row[$tanggalTerimaKey] !== '~') {
                $parsedDate = $this->parseDate($row[$tanggalTerimaKey]);

                if (!$parsedDate) {
                    $this->summary['failed']++;
                    Log::warning('Gagal parse tanggal pada row', [
                        'tanggal' => $row[$tanggalTerimaKey],
                        'nama_barang' => $row[$namaBarangKey] ?? 'unknown',
                        'row_data' => $row
                    ]);
                    return null;
                }
                $tanggalTerima = $parsedDate;
            }

            // Clean data - convert empty to "-"
            $namaPengarang = $this->normalizeValue($row[$namaPengarangKey] ?? null);
            $penerbit = $this->normalizeValue($row[$penerbitKey] ?? null);
            $namaBarang = $this->normalizeValue($row[$namaBarangKey] ?? null);
            $tahun = '-';

            if (isset($row[$tahunKey]) && $row[$tahunKey] !== null && $row[$tahunKey] !== '' && $row[$tahunKey] !== '-' && $row[$tahunKey] !== '~') {
                $yearValue = (int) $row[$tahunKey];
                // Validate tahun
                if ($yearValue >= 1900 && $yearValue <= (date('Y') + 1)) {
                    $tahun = (string) $yearValue;
                }
            }

            // Check for duplicate data (all fields must match)
            $isDuplicate = PenerimaanBarang::where('nama_barang', $namaBarang)
                ->where('nama_pengarang', $namaPengarang)
                ->where('penerbit', $penerbit)
                ->where('tahun', $tahun)
                ->where('tanggal_terima', $tanggalTerima)
                ->exists();

            if ($isDuplicate) {
                $this->summary['duplicate']++;
                Log::info('Data duplikat di-skip', [
                    'nama_barang' => $namaBarang,
                    'nama_pengarang' => $namaPengarang,
                    'penerbit' => $penerbit,
                    'tahun' => $tahun,
                    'tanggal_terima' => $tanggalTerima
                ]);
                return null;
            }

            // Create penerimaan barang
            PenerimaanBarang::create([
                'tanggal_terima' => $tanggalTerima,
                'nama_pengarang' => $namaPengarang,
                'penerbit' => $penerbit,
                'nama_barang' => $namaBarang,
                'tahun' => $tahun,
            ]);

            $this->summary['success']++;
            
        } catch (\Exception $e) {
            $this->summary['failed']++;
            Log::error('Error importing row', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'nama_barang' => $row[$namaBarangKey] ?? 'unknown',
                'row_data' => $row
            ]);
            return null;
        }

        return null;
    }

    /**
     * Parse tanggal dari berbagai format
     */
    private function parseDate($date)
    {
        if (empty($date)) {
            return null;
        }

        // If it's already a Carbon instance
        if ($date instanceof Carbon) {
            return $date->format('Y-m-d');
        }

        // If it's a numeric Excel date
        if (is_numeric($date)) {
            try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date))->format('Y-m-d');
            } catch (\Exception $e) {
                Log::error('Failed to parse numeric date: ' . $date);
                return null;
            }
        }

        // Try to parse string date - handle Indonesian month names
        try {
            // Convert Indonesian month names to English
            $indonesianMonths = [
                'Januari' => 'January',
                'Februari' => 'February',
                'Maret' => 'March',
                'April' => 'April',
                'Mei' => 'May',
                'Juni' => 'June',
                'Juli' => 'July',
                'Agustus' => 'August',
                'September' => 'September',
                'Oktober' => 'October',
                'November' => 'November',
                'Desember' => 'December'
            ];
            
            $dateString = trim($date);
            
            // Replace Indonesian month names with English ones
            foreach ($indonesianMonths as $indo => $eng) {
                $dateString = str_replace($indo, $eng, $dateString);
            }
            
            return Carbon::parse($dateString)->format('Y-m-d');
        } catch (\Exception $e) {
            Log::error('Failed to parse date string: ' . $date . ' | Error: ' . $e->getMessage());
            return null;
        }
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
            // Convert empty, "-" or "~" to "-"
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