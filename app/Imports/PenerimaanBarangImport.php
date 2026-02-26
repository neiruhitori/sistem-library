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
        'failed' => 0
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
        
        // Skip if required fields are empty
        if (empty($row[$tanggalTerimaKey]) || empty($row[$namaBarangKey])) {
            return null;
        }

        $this->summary['total']++;

        try {
            // Parse tanggal
            $tanggalTerima = $this->parseDate($row[$tanggalTerimaKey]);
            
            if (!$tanggalTerima) {
                $this->summary['failed']++;
                Log::warning('Gagal parse tanggal pada row', [
                    'tanggal' => $row[$tanggalTerimaKey],
                    'nama_barang' => $row[$namaBarangKey]
                ]);
                return null;
            }

            // Validate and clean data
            $namaPengarang = trim($row[$namaPengarangKey] ?? '');
            $penerbit = trim($row[$penerbitKey] ?? '');
            $namaBarang = trim($row[$namaBarangKey] ?? '');
            $tahun = (int) ($row[$tahunKey] ?? date('Y'));
            
            // Validate tahun
            if ($tahun < 1900 || $tahun > (date('Y') + 1)) {
                $tahun = date('Y');
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
                'nama_barang' => $row[$namaBarangKey] ?? 'unknown'
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
     * Get import summary
     */
    public function getSummary()
    {
        return $this->summary;
    }
}
