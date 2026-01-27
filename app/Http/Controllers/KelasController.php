<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Periode;
use App\Models\SiswaPeriode;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KelasController extends Controller
{
    /**
     * Daftar kelas yang tersedia
     */
    private $kelasList = [
        '7a' => '7A',
        '7b' => '7B',
        '7c' => '7C',
        '7d' => '7D',
        '7e' => '7E',
        '7f' => '7F',
        '7g' => '7G',
        '8a' => '8A',
        '8b' => '8B',
        '8c' => '8C',
        '8d' => '8D',
        '8e' => '8E',
        '8f' => '8F',
        '8g' => '8G',
        '9a' => '9A',
        '9b' => '9B',
        '9c' => '9C',
        '9d' => '9D',
        '9e' => '9E',
        '9f' => '9F',
        '9g' => '9G'
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

        // Ambil periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.');
        }

        // Ambil data siswa berdasarkan kelas dari periode aktif
        $siswaPeriodes = SiswaPeriode::where('periode_id', $periodeAktif->id)
            ->where('kelas', $namaKelas)
            ->where('status', 'Aktif') // Hanya tampilkan siswa dengan status Aktif
            ->with('siswa')
            ->get();

        // Transform ke collection siswa dengan tambahan informasi periode
        $siswa = $siswaPeriodes->map(function ($siswaPeriode) {
            $student = $siswaPeriode->siswa;
            $student->kelas = $siswaPeriode->kelas;
            $student->absen = $siswaPeriode->absen;
            $student->status = $siswaPeriode->status;
            $student->siswa_periode_id = $siswaPeriode->id;
            return $student;
        })->sortBy('name');

        // Hitung statistik
        $totalSiswa = $siswa->count();

        return view('kelas.index', compact('siswa', 'namaKelas', 'kelas', 'totalSiswa', 'periodeAktif'));
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

        // Ambil periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()->back()->with('error', 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.');
        }

        // Ambil data siswa
        $siswa = Siswa::findOrFail($id);

        // Ambil data periode siswa untuk kelas yang sesuai
        $siswaPeriode = SiswaPeriode::where('siswa_id', $id)
            ->where('periode_id', $periodeAktif->id)
            ->where('kelas', $namaKelas)
            ->firstOrFail();

        // Tambahkan informasi periode ke siswa
        $siswa->kelas = $siswaPeriode->kelas;
        $siswa->absen = $siswaPeriode->absen;
        $siswa->status = $siswaPeriode->status;

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

        return view('kelas.show', compact('siswa', 'namaKelas', 'kelas', 'peminjamanHarian', 'peminjamanTahunan', 'catatanDenda', 'periodeAktif'));
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

        // Cek apakah ada kepala perpustakaan yang aktif
        $kepalaPerpustakaan = \App\Models\Penandatangan::getActiveByJabatan('kepala_perpustakaan');
        $kepalaSekolah = \App\Models\Penandatangan::getActiveByJabatan('kepala_sekolah');

        if (!$kepalaPerpustakaan || !$kepalaSekolah) {
            $message = 'Tidak dapat mencetak PDF. Silakan tambahkan data yang aktif terlebih dahulu di menu Penandatangan: ';
            $missing = [];
            if (!$kepalaPerpustakaan) $missing[] = 'Kepala Perpustakaan';
            if (!$kepalaSekolah) $missing[] = 'Kepala Sekolah';

            return redirect()->route('kelas.index', $kelas)
                ->with('error', $message . implode(' dan ', $missing));
        }

        // Ambil periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('kelas.index', $kelas)
                ->with('error', 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.');
        }

        // Ambil semua data siswa berdasarkan kelas dari periode aktif
        $siswaPeriodes = SiswaPeriode::where('periode_id', $periodeAktif->id)
            ->where('kelas', $namaKelas)
            ->where('status', 'Aktif') // Hanya tampilkan siswa dengan status Aktif
            ->with('siswa')
            ->get();

        // Transform ke collection siswa dengan tambahan informasi periode
        $siswa = $siswaPeriodes->map(function ($siswaPeriode) {
            $student = $siswaPeriode->siswa;
            $student->kelas = $siswaPeriode->kelas;
            $student->absen = $siswaPeriode->absen;
            $student->status = $siswaPeriode->status;
            return $student;
        })->sortBy('name');

        // Hitung statistik
        $totalSiswa = $siswa->count();

        $data = [
            'siswa' => $siswa,
            'namaKelas' => $namaKelas,
            'totalSiswa' => $totalSiswa,
            'tanggalCetak' => now()->format('d F Y'),
            'kepalaPerpustakaan' => $kepalaPerpustakaan,
            'kepalaSekolah' => $kepalaSekolah,
            'periodeAktif' => $periodeAktif
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

        // Cek apakah ada kepala perpustakaan yang aktif
        $kepalaPerpustakaan = \App\Models\Penandatangan::getActiveByJabatan('kepala_perpustakaan');

        if (!$kepalaPerpustakaan) {
            return redirect()->route('kelas.show', ['kelas' => $kelas, 'id' => $id])
                ->with('error', 'Tidak dapat mencetak PDF. Silakan tambahkan data Kepala Perpustakaan yang aktif terlebih dahulu di menu Penandatangan.');
        }

        // Ambil periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();

        if (!$periodeAktif) {
            return redirect()->route('kelas.show', ['kelas' => $kelas, 'id' => $id])
                ->with('error', 'Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu.');
        }

        // Ambil data siswa
        $siswa = Siswa::findOrFail($id);

        // Ambil data periode siswa untuk kelas yang sesuai
        $siswaPeriode = SiswaPeriode::where('siswa_id', $id)
            ->where('periode_id', $periodeAktif->id)
            ->where('kelas', $namaKelas)
            ->firstOrFail();

        // Tambahkan informasi periode ke siswa
        $siswa->kelas = $siswaPeriode->kelas;
        $siswa->absen = $siswaPeriode->absen;
        $siswa->status = $siswaPeriode->status;

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
            'tanggalCetak' => now()->format('d F Y'),
            'kepalaPerpustakaan' => $kepalaPerpustakaan,
            'periodeAktif' => $periodeAktif
        ];

        $pdf = Pdf::loadView('kelas.detail-pdf', $data);
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream("Detail_Siswa_{$siswa->name}_" . now()->format('Y-m-d') . ".pdf");
    }
}
