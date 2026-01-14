<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Return array of sample data
     */
    public function array(): array
    {
        // Baris 1-4: Informasi dan instruksi
        return [
            ['TEMPLATE IMPORT DATA SISWA', '', '', '', '', '', '', ''],
            ['Petunjuk Pengisian:', '', '', '', '', '', '', ''],
            ['1. Isi data siswa mulai dari baris ke-6 (di bawah header)', '', '', '', '', '', '', ''],
            ['2. Jangan hapus atau ubah header (baris ke-5)', '', '', '', '', '', '', ''],
            ['3. Format: KELAS (7A-9G), L/P (L atau P), AGAMA (Islam/Kristen/Katolik/Hindu/Buddha/Konghucu)', '', '', '', '', '', '', ''],
            ['4. Kolom yang wajib diisi: NAMA dan KELAS', '', '', '', '', '', '', ''],
            ['', '', '', '', '', '', '', ''],
            // Baris 5 kosong untuk spacing
            // Baris 6 akan berisi header dari method headings()
            // Contoh data (opsional, bisa dihapus)
            ['1', '1', '7A', '7696', '0132585541', 'Contoh Siswa 1', 'L', 'Islam'],
            ['2', '2', '7A', '7697', '0132585542', 'Contoh Siswa 2', 'P', 'Kristen'],
        ];
    }

    /**
     * Define column headers (akan muncul di row 5 sesuai dengan headingRow() di import)
     */
    public function headings(): array
    {
        return [
            'URUT',
            'ABSEN',
            'KELAS',
            'NIS',
            'NISN',
            'NAMA',
            'L/P',
            'AGAMA',
        ];
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk baris 1 (Judul)
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            
            // Style untuk baris 2-7 (Petunjuk)
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['italic' => true, 'size' => 9]],
            4 => ['font' => ['italic' => true, 'size' => 9]],
            5 => ['font' => ['italic' => true, 'size' => 9]],
            6 => ['font' => ['italic' => true, 'size' => 9]],
            
            // Style untuk header di baris 8 (yang akan jadi row 5 di headingRow)
            8 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '203764'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }

    /**
     * Define column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,   // URUT
            'B' => 10,  // ABSEN
            'C' => 10,  // KELAS
            'D' => 12,  // NIS
            'E' => 15,  // NISN
            'F' => 30,  // NAMA
            'G' => 8,   // L/P
            'H' => 15,  // AGAMA
        ];
    }
}
