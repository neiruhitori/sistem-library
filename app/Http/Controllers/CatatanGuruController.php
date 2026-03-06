<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatatanGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = CatatanDenda::with('guru')
            ->where('tipe_peminjaman', 'guru');

        // Filter berdasarkan status jika ada
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $catatans = $query->latest()->get();

        return view('catatanguru.index', compact('catatans'));
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
            'guru',
            'peminjamanGuru.details.bukuPanduanGuru',
            'peminjamanGuru.details.kodePanduanGuru',
            'handledByUser'
        ])->findOrFail($id);

        return view('catatanguru.show', compact('catatan'));
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
    public function update(Request $request, $id)
    {
        $catatan = CatatanDenda::findOrFail($id);

        $request->validate([
            'status' => 'required|in:belum_dibayar,dibayar',
        ]);

        $data = [
            'status' => $request->status,
        ];

        // Jika status diubah menjadi dibayar, set tanggal bayar dan approved_by
        if ($request->status === 'dibayar' && $catatan->status !== 'dibayar') {
            $data['tanggal_bayar'] = now();
            $data['approved_by_user_id'] = Auth::id();
        }

        $catatan->update($data);

        return redirect()
            ->route('catatanguru.index')
            ->with('success', 'Status berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Bayar denda
     */
    public function bayar($id)
    {
        $catatan = CatatanDenda::findOrFail($id);

        $catatan->update([
            'status' => 'dibayar',
            'tanggal_bayar' => now(),
            'approved_by_user_id' => Auth::id(),
        ]);

        return redirect()->route('catatanguru.index')
            ->with('success', 'Denda berhasil dibayar!');
    }
}
