<?php

namespace App\Http\Controllers;

use App\Models\Penandatangan;
use Illuminate\Http\Request;

class PenandatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penandatangans = Penandatangan::orderBy('jabatan')->orderBy('created_at', 'desc')->get();
        return view('penandatangan.index', compact('penandatangans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penandatangan.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jabatan' => 'required|in:kepala_perpustakaan,kepala_sekolah',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50'
        ]);

        $isActive = $request->has('is_active');

        // Jika akan diset aktif, nonaktifkan yang lain dengan jabatan sama terlebih dahulu
        if ($isActive) {
            Penandatangan::where('jabatan', $request->jabatan)
                ->update(['is_active' => false]);
        }

        // Buat data penandatangan baru
        $penandatangan = Penandatangan::create([
            'jabatan' => $request->jabatan,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'is_active' => $isActive
        ]);

        return redirect()->route('penandatangan.index')
            ->with('success', 'Data penandatangan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $penandatangan = Penandatangan::findOrFail($id);
        return view('penandatangan.form', compact('penandatangan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $penandatangan = Penandatangan::findOrFail($id);
        
        $request->validate([
            'jabatan' => 'required|in:kepala_perpustakaan,kepala_sekolah',
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:50'
        ]);

        $isActive = $request->has('is_active');

        $penandatangan->update([
            'jabatan' => $request->jabatan,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'is_active' => $isActive
        ]);

        // Jika diset aktif, nonaktifkan yang lain
        if ($penandatangan->is_active) {
            $penandatangan->setAsActive();
        }

        return redirect()->route('penandatangan.index')
            ->with('success', 'Data penandatangan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penandatangan = Penandatangan::findOrFail($id);
        $penandatangan->delete();

        return redirect()->route('penandatangan.index')
            ->with('success', 'Data penandatangan berhasil dihapus.');
    }
    
    /**
     * Toggle active status
     */
    public function toggleActive($id)
    {
        $penandatangan = Penandatangan::findOrFail($id);
        
        if (!$penandatangan->is_active) {
            $penandatangan->setAsActive();
            $message = 'Penandatangan berhasil diaktifkan.';
        } else {
            $penandatangan->update(['is_active' => false]);
            $message = 'Penandatangan berhasil dinonaktifkan.';
        }

        return redirect()->route('penandatangan.index')
            ->with('success', $message);
    }
}
