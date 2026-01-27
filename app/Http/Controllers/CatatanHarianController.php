<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use App\Models\User;
use App\Models\Periode;
use App\Models\SiswaPeriode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CatatanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CatatanDenda::with('siswa')
            ->where('tipe_peminjaman', 'harian');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $catatans = $query->latest()->get();

        return view('catatanharian.index', compact('catatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $catatan = CatatanDenda::with([
            'siswa',
            'peminjaman.details.kodeBuku.buku',
            'handledByUser' // Tambahkan relasi untuk user yang menangani
        ])->findOrFail($id);

        // Ambil data kelas dari periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();
        if ($periodeAktif && $catatan->siswa) {
            $siswaPeriode = SiswaPeriode::where('siswa_id', $catatan->siswa->id)
                ->where('periode_id', $periodeAktif->id)
                ->first();

            if ($siswaPeriode) {
                $catatan->siswa->kelas = $siswaPeriode->kelas;
                $catatan->siswa->absen = $siswaPeriode->absen;
            }
        }

        return view('catatanharian.show', compact('catatan'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function processPayment($id)
    {
        $catatan = CatatanDenda::findOrFail($id);
        $this->markAsPaid($catatan);

        return redirect()->route('catatanharian.show', $catatan->id)->with('success', 'Pembayaran cash berhasil dicatat.');
    }

    /**
     * privasi method to mark a CatatanDenda as paid.
     * This method updates the status of the CatatanDenda to 'dibayar' and
     * sets the payment date to the current date.
     */
    private function markAsPaid(CatatanDenda $catatan)
    {
        if ($catatan->status === 'belum_dibayar') {
            $catatan->update(['status' => 'dibayar', 'tanggal_bayar' => now()]);
        }
    }

    public function export($id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        // Cek apakah ada kepala perpustakaan yang aktif
        $kepalaPerpustakaan = \App\Models\Penandatangan::getActiveByJabatan('kepala_perpustakaan');

        if (!$kepalaPerpustakaan) {
            return redirect()->route('catatanharian.show', $id)
                ->with('error', 'Tidak dapat mencetak PDF. Silakan tambahkan data Kepala Perpustakaan yang aktif terlebih dahulu di menu Penandatangan.');
        }

        $catatan = CatatanDenda::with([
            'siswa',
            'peminjaman.details.kodeBuku.buku',
            'handledByUser' // Tambahkan relasi untuk user yang menangani
        ])->findOrFail($id);

        // Ambil data kelas dari periode aktif
        $periodeAktif = Periode::where('is_active', true)->first();
        if ($periodeAktif && $catatan->siswa) {
            $siswaPeriode = SiswaPeriode::where('siswa_id', $catatan->siswa->id)
                ->where('periode_id', $periodeAktif->id)
                ->first();

            if ($siswaPeriode) {
                $catatan->siswa->kelas = $siswaPeriode->kelas;
                $catatan->siswa->absen = $siswaPeriode->absen;
            }
        }

        $pdf = Pdf::loadView('catatanharian.pdf', compact('catatan', 'kepalaPerpustakaan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('catatan_denda_' . $catatan->id . '.pdf', compact('profile'));
    }
}
