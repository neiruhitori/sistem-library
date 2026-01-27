<?php

namespace App\Http\Controllers;

use App\Models\Periode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        $periodes = Periode::orderBy('tahun_ajaran', 'DESC')
                          ->orderBy('semester', 'DESC')
                          ->get();
        
        return view('periode.index', compact('periodes', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        return view('periode.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9', // Format: 2024/2025
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'boolean'
        ]);
        
        // Cek jika ada periode dengan tahun ajaran dan semester yang sama
        $exists = Periode::where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('semester', $request->semester)
                        ->exists();
        
        if ($exists) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Periode dengan tahun ajaran dan semester tersebut sudah ada!');
        }
        
        // Jika is_active dicentang, nonaktifkan periode lain
        if ($request->has('is_active') && $request->is_active) {
            Periode::query()->update(['is_active' => false]);
        }
        
        Periode::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => $request->has('is_active') ? true : false
        ]);
        
        return redirect()->route('periode.index')
                        ->with('success', 'Periode tahun ajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        $periode = Periode::with(['siswaPeriodes.siswa'])->findOrFail($id);
        
        return view('periode.show', compact('periode', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        $periode = Periode::findOrFail($id);
        
        return view('periode.edit', compact('periode', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'semester' => 'required|in:Ganjil,Genap',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'is_active' => 'boolean'
        ]);
        
        $periode = Periode::findOrFail($id);
        
        // Cek jika ada periode lain dengan tahun ajaran dan semester yang sama
        $exists = Periode::where('tahun_ajaran', $request->tahun_ajaran)
                        ->where('semester', $request->semester)
                        ->where('id', '!=', $id)
                        ->exists();
        
        if ($exists) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Periode dengan tahun ajaran dan semester tersebut sudah ada!');
        }
        
        // Jika is_active dicentang, nonaktifkan periode lain
        if ($request->has('is_active') && $request->is_active) {
            Periode::where('id', '!=', $id)->update(['is_active' => false]);
        }
        
        $periode->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester' => $request->semester,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'is_active' => $request->has('is_active') ? true : false
        ]);
        
        return redirect()->route('periode.index')
                        ->with('success', 'Periode tahun ajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periode = Periode::findOrFail($id);
        
        // Cek apakah periode ini aktif
        if ($periode->is_active) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus periode yang sedang aktif!');
        }
        
        // Cek apakah ada siswa terdaftar di periode ini
        if ($periode->siswaPeriodes()->count() > 0) {
            return redirect()->back()
                           ->with('error', 'Tidak dapat menghapus periode yang memiliki data siswa!');
        }
        
        $periode->delete();
        
        return redirect()->route('periode.index')
                        ->with('success', 'Periode tahun ajaran berhasil dihapus!');
    }
    
    /**
     * Set periode sebagai aktif
     */
    public function setActive(string $id)
    {
        $periode = Periode::findOrFail($id);
        $periode->setAsActive();
        
        return redirect()->route('periode.index')
                        ->with('success', 'Periode berhasil diaktifkan!');
    }
}
