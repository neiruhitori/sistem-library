<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Midtrans\Config;
use Midtrans\Snap;

class CatatanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catatans = CatatanDenda::with('siswa')
            ->where('tipe_peminjaman', 'harian')
            ->latest()
            ->get();

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
            'peminjaman.details.kodeBuku.buku'
        ])->findOrFail($id);

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

    public function pay($id)
    {
        $catatan = CatatanDenda::findOrFail($id);

        if ($catatan->status === 'dibayar') {
            return back()->with('info', 'Catatan ini sudah dibayar.');
        }

        // Konfigurasi Midtrans dari config/services.php
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'DENDA-' . $catatan->id . '-' . time(),
                'gross_amount' => $catatan->jumlah,
            ],
            'customer_details' => [
                'first_name' => $catatan->siswa->name,
                'email' => $catatan->siswa->email ?? 'dummy@email.com',
                'phone' => $catatan->siswa->telepon ?? '081234567890',
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        $catatan->snap_token = $snapToken;
        $catatan->save();

        return view('catatanharian.payment', compact('catatan'));
    }


    public function processPayment($id)
    {
        $catatan = CatatanDenda::findOrFail($id);

        if ($catatan->status === 'belum_dibayar') {
            $catatan->update([
                'status' => 'dibayar',
                'tanggal_bayar' => now(),
            ]);
        }

        return redirect()->route('catatanharian.show', $catatan->id)->with('success', 'Pembayaran cash berhasil dicatat.');
    }

    public function export($id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $catatan = CatatanDenda::with([
            'siswa',
            'peminjaman.details.kodeBuku.buku'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('catatanharian.pdf', compact('catatan'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('catatan_denda_' . $catatan->id . '.pdf', compact('profile'));
    }
}
