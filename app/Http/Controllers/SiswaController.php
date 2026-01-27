<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\Periode;
use App\Models\SiswaPeriode;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\PngWriter;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        // Ambil semua periode untuk dropdown
        $periodes = Periode::orderBy('tahun_ajaran', 'DESC')
            ->orderBy('semester', 'DESC')
            ->get();

        // Ambil periode aktif sebagai default
        $periodeAktif = Periode::where('is_active', true)->first();

        // Periode yang dipilih (dari request atau default ke periode aktif)
        $selectedPeriode = $request->periode_id ?? ($periodeAktif ? $periodeAktif->id : null);

        // Ambil data siswa berdasarkan periode yang dipilih
        if ($selectedPeriode) {
            $siswaQuery = SiswaPeriode::with(['siswa', 'periode'])
                ->where('periode_id', $selectedPeriode)
                ->orderBy('kelas', 'ASC')
                ->orderBy('absen', 'ASC');

            if ($request->has('search') && $request->search) {
                $siswaQuery->whereHas('siswa', function ($q) use ($request) {
                    $q->where('name', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('nisn', 'LIKE', '%' . $request->search . '%');
                });
            }

            $siswaData = $siswaQuery->get();
        } else {
            $siswaData = collect();
        }

        return view('siswa.index', compact('siswaData', 'periodes', 'selectedPeriode', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $periodes = Periode::orderBy('tahun_ajaran', 'DESC')->get();
        $periodeAktif = Periode::where('is_active', true)->first();

        return view('siswa.create', compact('periodes', 'periodeAktif', 'profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:1|max:100',
            'nisn' => 'required|string|unique:siswas,nisn',
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:50',
            'periode_id' => 'required|exists:periodes,id',
            'kelas' => 'required|string|max:10',
            'absen' => 'nullable|string|max:10',
            'status' => 'nullable|in:Aktif,Tidak Aktif,Lulus,Pindah'
        ]);

        DB::beginTransaction();
        try {
            // Buat data siswa (identitas)
            $siswa = Siswa::create([
                'nisn' => $request->nisn,
                'name' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
            ]);

            // Buat data siswa periode (kelas dan status)
            SiswaPeriode::create([
                'siswa_id' => $siswa->id,
                'periode_id' => $request->periode_id,
                'kelas' => $request->kelas,
                'absen' => $request->absen,
                'status' => $request->status ?? 'Aktif',
            ]);

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::with(['siswaPeriodes.periode'])->findOrFail($id);

        // Periode yang dipilih untuk ditampilkan (default periode aktif)
        $selectedPeriode = $request->periode_id;
        if (!$selectedPeriode) {
            $periodeAktif = Periode::where('is_active', true)->first();
            $selectedPeriode = $periodeAktif ? $periodeAktif->id : null;
        }

        // Data siswa untuk periode yang dipilih
        $siswaPeriode = null;
        if ($selectedPeriode) {
            $siswaPeriode = $siswa->siswaPeriodes()
                ->where('periode_id', $selectedPeriode)
                ->first();
        }

        return view('siswa.show', compact('siswa', 'siswaPeriode', 'selectedPeriode', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id, Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $siswa = Siswa::findOrFail($id);
        $periodes = Periode::orderBy('tahun_ajaran', 'DESC')->get();

        // Periode yang akan diedit (dari request atau periode aktif)
        $selectedPeriode = $request->periode_id;
        if (!$selectedPeriode) {
            $periodeAktif = Periode::where('is_active', true)->first();
            $selectedPeriode = $periodeAktif ? $periodeAktif->id : null;
        }

        // Data siswa untuk periode yang dipilih
        $siswaPeriode = null;
        if ($selectedPeriode) {
            $siswaPeriode = SiswaPeriode::where('siswa_id', $id)
                ->where('periode_id', $selectedPeriode)
                ->first();
        }

        return view('siswa.edit', compact('siswa', 'siswaPeriode', 'periodes', 'selectedPeriode', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:1|max:100',
            'nisn' => 'required|string|unique:siswas,nisn,' . $id,
            'jenis_kelamin' => 'required|in:L,P',
            'agama' => 'nullable|string|max:50',
            'periode_id' => 'required|exists:periodes,id',
            'kelas' => 'required|string|max:10',
            'absen' => 'nullable|string|max:10',
            'status' => 'nullable|in:Aktif,Tidak Aktif,Lulus,Pindah'
        ]);

        DB::beginTransaction();
        try {
            $siswa = Siswa::findOrFail($id);

            // Update data identitas siswa
            $siswa->update([
                'nisn' => $request->nisn,
                'name' => $request->name,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
            ]);

            // Update atau create data siswa periode
            SiswaPeriode::updateOrCreate(
                [
                    'siswa_id' => $siswa->id,
                    'periode_id' => $request->periode_id
                ],
                [
                    'kelas' => $request->kelas,
                    'absen' => $request->absen,
                    'status' => $request->status ?? 'Aktif',
                ]
            );

            DB::commit();
            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::findOrFail($id);

        // Cascade delete akan menghapus siswa_periodes otomatis
        $siswa->delete();

        return redirect()->back()->with('success', 'Siswa berhasil dihapus!');
    }

    public function exportPDF(Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        // Ambil periode yang dipilih atau periode aktif
        $periodeId = $request->periode_id;
        if (!$periodeId) {
            $periodeAktif = Periode::where('is_active', true)->first();
            $periodeId = $periodeAktif ? $periodeAktif->id : null;
        }

        if ($periodeId) {
            $periode = Periode::find($periodeId);
            $siswaData = SiswaPeriode::with(['siswa', 'periode'])
                ->where('periode_id', $periodeId)
                ->orderBy('kelas', 'ASC')
                ->orderBy('absen', 'ASC')
                ->get();
        } else {
            $periode = null;
            $siswaData = collect();
        }

        $pdf = PDF::loadView('siswa.pdf', compact('siswaData', 'periode', 'profile'));
        return $pdf->stream('Daftar_Siswa_SMPN_02_Klakah.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
            'periode_id' => 'required|exists:periodes,id'
        ]);

        try {
            $import = new SiswaImport($request->periode_id);
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            $message = sprintf(
                'Import berhasil! Total: %d siswa. Baru: %d, Diperbarui: %d, Dilewati: %d',
                $summary['total'],
                $summary['new'],
                $summary['updated'],
                $summary['skipped']
            );

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import siswa
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template-import-datasiswa.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }

        return response()->download($filePath, 'Template_Import_Siswa.xlsx');
    }
    public function hapussemua()
    {
        Siswa::query()->forceDelete();
        return redirect()->back()->with('removeAll', 'Hapus semua data Siswa successfully');
    }

    /**
     * Generate and print student ID card
     */
    public function printCard($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Ambil data periode aktif siswa
        $periodeAktif = Periode::where('is_active', true)->first();
        $siswaPeriode = null;

        if ($periodeAktif) {
            $siswaPeriode = SiswaPeriode::where('siswa_id', $siswa->id)
                ->where('periode_id', $periodeAktif->id)
                ->first();
        }

        // Set kelas dan absen dari periode aktif, atau default jika tidak ada
        $siswa->kelas = $siswaPeriode ? $siswaPeriode->kelas : '-';
        $siswa->absen = $siswaPeriode ? $siswaPeriode->absen : null;
        $siswa->status = $siswaPeriode ? $siswaPeriode->status : 'Tidak Aktif';

        // Generate QR Code menggunakan Endroid library
        $qrData = json_encode([
            // 'nama' => $siswa->name,
            // 'nisn' => $siswa->nisn,
            'id' => $siswa->id
        ]);

        $qr = new QrCode($qrData);
        $writer = new SvgWriter();
        $result = $writer->write($qr);

        $qrCode = base64_encode($result->getString());

        // Encode logo sebagai base64 untuk PDF
        $logoPath = public_path('AdminLTE-3.2.0/dist/img/smp2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($logoData);
        }

        // Load view ke PDF dengan setting yang sama seperti file lama
        $pdf = PDF::loadView('siswa.card_fixed', compact('siswa', 'qrCode', 'logoBase64', 'periodeAktif'))
            ->setPaper('a4', 'portrait')
            ->setOptions([
                'dpi' => 150,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true
            ]);

        return $pdf->stream('kartu-siswa-' . $siswa->name . '.pdf');
    }

    /**
     * Generate and export student ID card as PNG with 300 DPI
     */
    public function printCardPNG($id)
    {
        $siswa = Siswa::findOrFail($id);

        // Ambil data periode aktif siswa
        $periodeAktif = Periode::where('is_active', true)->first();
        $siswaPeriode = null;

        if ($periodeAktif) {
            $siswaPeriode = SiswaPeriode::where('siswa_id', $siswa->id)
                ->where('periode_id', $periodeAktif->id)
                ->first();
        }

        // Set kelas dan absen dari periode aktif, atau default jika tidak ada
        $siswa->kelas = $siswaPeriode ? $siswaPeriode->kelas : '-';
        $siswa->absen = $siswaPeriode ? $siswaPeriode->absen : null;
        $siswa->status = $siswaPeriode ? $siswaPeriode->status : 'Tidak Aktif';

        // Generate QR Code menggunakan Endroid library untuk PNG
        $qrData = json_encode([
            'id' => $siswa->id
        ]);

        $qr = new QrCode($qrData);
        $writer = new PngWriter();
        $result = $writer->write($qr);
        $qrCode = base64_encode($result->getString());

        // Encode logo sebagai base64
        $logoPath = public_path('AdminLTE-3.2.0/dist/img/smp2.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = base64_encode($logoData);
        }

        // Create PNG template dengan DPI 300
        // Ukuran: 85.6mm x 53.98mm = 1012 x 640 pixels @ 300 DPI
        $width = 1012;
        $height = 640;

        // Load view untuk konversi ke PNG
        $html = view('siswa.card_png', compact('siswa', 'qrCode', 'logoBase64', 'width', 'height', 'periodeAktif'))->render();

        // Convert HTML ke PDF dengan ukuran yang tepat untuk 300 DPI
        $pdf = PDF::loadHTML($html)
            ->setPaper([0, 0, $width * 0.75, $height * 0.75], 'portrait')
            ->setOptions([
                'dpi' => 300,
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'enable_font_subsetting' => true
            ]);

        // Return PDF dengan resolusi tinggi untuk printing
        return $pdf->download('kartu-siswa-' . $siswa->name . '-300dpi.pdf');
    }

    /**
     * Bulk update status siswa berdasarkan periode
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'siswa_periode_ids' => 'required|array|min:1',
            'siswa_periode_ids.*' => 'exists:siswa_periodes,id',
            'status' => 'required|in:Aktif,Tidak Aktif,Lulus,Pindah'
        ]);

        try {
            DB::beginTransaction();

            $updated = SiswaPeriode::whereIn('id', $request->siswa_periode_ids)
                ->update(['status' => $request->status]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengubah status {$updated} siswa menjadi {$request->status}"
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }
}
