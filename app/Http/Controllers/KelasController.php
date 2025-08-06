<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KelasController extends Controller
{
    /**
     * Daftar kelas yang tersedia
     */
    private $kelasList = [
        'viia' => 'VII A',
        'viib' => 'VII B',
        'viic' => 'VII C',
        'viid' => 'VII D',
        'viie' => 'VII E',
        'viif' => 'VII F',
        'viig' => 'VII G',
        'viiia' => 'VIII A',
        'viiib' => 'VIII B',
        'viiic' => 'VIII C',
        'viiid' => 'VIII D',
        'viiie' => 'VIII E',
        'viiif' => 'VIII F',
        'viiig' => 'VIII G',
        'ixa' => 'IX A',
        'ixb' => 'IX B',
        'ixc' => 'IX C',
        'ixd' => 'IX D',
        'ixe' => 'IX E',
        'ixf' => 'IX F',
        'ixg' => 'IX G'
    ];

    /**
     * Display a listing of students by class.
     */
    public function index($kelas)
    {
        // Validasi kelas
        if (!array_key_exists($kelas, $this->kelasList)) {
            abort(404, 'Kelas tidak ditemukan');
        }

        $namaKelas = $this->kelasList[$kelas];

        // Ambil data siswa berdasarkan kelas (tanpa pagination untuk DataTables)
        $siswa = Siswa::where('kelas', $namaKelas)
            ->orderBy('name', 'asc')
            ->get();

        // Hitung statistik
        $totalSiswa = $siswa->count();

        return view('kelas.index', compact('siswa', 'namaKelas', 'kelas', 'totalSiswa'));
    }

    /**
     * Display the specified student.
     */
    public function show($kelas, $id)
    {
        // Validasi kelas
        if (!array_key_exists($kelas, $this->kelasList)) {
            abort(404, 'Kelas tidak ditemukan');
        }

        $namaKelas = $this->kelasList[$kelas];

        // Ambil data siswa
        $siswa = Siswa::where('kelas', $namaKelas)->findOrFail($id);

        // Ambil data peminjaman harian siswa dengan relasi yang ada
        $peminjamanHarian = $siswa->peminjamanHarian()
            ->with(['details.kodeBuku.buku'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ambil data peminjaman tahunan siswa dengan relasi yang ada
        $peminjamanTahunan = $siswa->peminjamanTahunan()
            ->with(['details.kodeBuku.buku'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Ambil data catatan denda siswa
        $catatanDenda = $siswa->catatanDenda()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('kelas.show', compact('siswa', 'namaKelas', 'kelas', 'peminjamanHarian', 'peminjamanTahunan', 'catatanDenda'));
    }

    /**
     * Generate PDF for class list
     */
    public function cetakPDF($kelas)
    {
        // Validasi kelas
        if (!array_key_exists($kelas, $this->kelasList)) {
            abort(404, 'Kelas tidak ditemukan');
        }

        $namaKelas = $this->kelasList[$kelas];

        // Ambil semua data siswa berdasarkan kelas
        $siswa = Siswa::where('kelas', $namaKelas)
            ->orderBy('name', 'asc')
            ->get();

        // Hitung statistik
        $totalSiswa = $siswa->count();

        $data = [
            'siswa' => $siswa,
            'namaKelas' => $namaKelas,
            'totalSiswa' => $totalSiswa,
            'tanggalCetak' => now()->format('d F Y')
        ];

        $pdf = Pdf::loadView('kelas.pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream("Data_Siswa_Kelas_{$namaKelas}_" . now()->format('Y-m-d') . ".pdf");
    }

    /**
     * Generate PDF for student detail
     */
    public function cetakDetailPDF($kelas, $id)
    {
        // Validasi kelas
        if (!array_key_exists($kelas, $this->kelasList)) {
            abort(404, 'Kelas tidak ditemukan');
        }

        $namaKelas = $this->kelasList[$kelas];

        // Ambil data siswa
        $siswa = Siswa::where('kelas', $namaKelas)->findOrFail($id);

        // Ambil data peminjaman harian siswa
        $peminjamanHarian = $siswa->peminjamanHarian()
            ->with(['details.kodeBuku.buku'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data peminjaman tahunan siswa
        $peminjamanTahunan = $siswa->peminjamanTahunan()
            ->with(['details.kodeBuku.buku'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Ambil data catatan denda siswa
        $catatanDenda = $siswa->catatanDenda()
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'siswa' => $siswa,
            'namaKelas' => $namaKelas,
            'peminjamanHarian' => $peminjamanHarian,
            'peminjamanTahunan' => $peminjamanTahunan,
            'catatanDenda' => $catatanDenda,
            'tanggalCetak' => now()->format('d F Y')
        ];

        $pdf = Pdf::loadView('kelas.detail-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream("Detail_Siswa_{$siswa->name}_" . now()->format('Y-m-d') . ".pdf");
    }
}
