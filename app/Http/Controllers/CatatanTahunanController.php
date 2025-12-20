<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CatatanTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catatans = CatatanDenda::with('siswa')
            ->where('tipe_peminjaman', 'tahunan')
            ->latest()
            ->get();

        return view('catatantahunan.index', compact('catatans'));
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
    public function show(string $id)
    {
        $catatan = CatatanDenda::with([
            'siswa',
            'peminjamantahunan.details.kodeBuku.buku',
            'handledByUser' // Tambahkan relasi untuk user yang menangani
        ])->findOrFail($id);

        return view('catatantahunan.show', compact('catatan'));
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

        return redirect()->route('catatantahunan.show', $catatan->id)->with('success', 'Pembayaran cash berhasil dicatat.');
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

        $catatan = CatatanDenda::with([
            'siswa',
            'peminjamantahunan.details.kodeBuku.buku',
            'handledByUser' // Tambahkan relasi untuk user yang menangani
        ])->findOrFail($id);

        $pdf = Pdf::loadView('catatantahunan.pdf', compact('catatan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('catatan_denda_' . $catatan->id . '.pdf', compact('profile'));
    }
}
