<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexHarian()
    {
        $bukus = Buku::with(['kodeBuku']) // <-- perlu eager load relasi
            ->withCount(['kodeBuku as stok' => function ($query) {
                $query->where('status', 'tersedia');
            }])
            ->where('tipe', 'harian')
            ->get();

        return view('buku.index', compact('bukus'))->with('tipe', 'harian');
    }

    public function indexTahunan()
    {
        $bukus = Buku::with(['kodeBuku']) // <-- perlu eager load relasi
            ->withCount(['kodeBuku as stok' => function ($query) {
                $query->where('status', 'tersedia');
            }])
            ->where('tipe', 'tahunan')
            ->get();

        return view('buku.index', compact('bukus'))->with('tipe', 'tahunan');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $tipe = $request->get('tipe', 'harian');

        if (!in_array($tipe, ['harian', 'tahunan'])) {
            abort(404);
        }

        return view('buku.form', [
            'tipe' => $tipe
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'penulis' => 'nullable|string',
            'tipe' => 'required|in:harian,tahunan',
            'tahun_terbit' => 'nullable|digits:4',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_buku' => 'required|array|min:1',
            'kode_buku.*' => 'required|string|distinct|unique:kode_bukus,kode_buku'
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('bukus', 'public');
        }

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tipe' => $request->tipe,
            'tahun_terbit' => $request->tahun_terbit,
            'description' => $request->description,
            'foto' => $fotoPath ?? null,
        ]);

        foreach ($request->kode_buku as $kode) {
            $buku->kodeBuku()->create(['kode_buku' => $kode]);
        }

        return redirect()->route($buku->tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
            ->with('success', 'Buku berhasil ditambahkan.');
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
    public function edit($id)
    {
        $buku = Buku::with('kodeBuku')->findOrFail($id);
        $tipe = $buku->tipe;

        return view('buku.form', compact('buku', 'tipe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $buku = Buku::with('kodeBuku')->findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'penulis' => 'nullable|string',
            'tahun_terbit' => 'nullable|digits:4',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_buku' => 'required|array|min:1',
            'kode_buku.*' => 'required|string|distinct'
        ]);

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('bukus', 'public');
            $buku->foto = $fotoPath;
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tahun_terbit' => $request->tahun_terbit,
            'description' => $request->description
        ]);

        $existingCodes = $buku->kodeBuku->pluck('kode_buku')->toArray();
        $newCodes = $request->kode_buku;

        $toAdd = array_diff($newCodes, $existingCodes);
        $toDelete = array_diff($existingCodes, $newCodes);

        // Delete removed kode buku
        if (!empty($toDelete)) {
            $buku->kodeBuku()->whereIn('kode_buku', $toDelete)->delete();
        }

        // Add new kode buku
        foreach ($toAdd as $kode) {
            $buku->kodeBuku()->create(['kode_buku' => $kode]);
        }

        return redirect()->route($buku->tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);
        $tipe = $buku->tipe;
        $buku->delete();

        return redirect()->route($tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
            ->with('success', 'Buku berhasil dihapus.');
    }

    public function hapussemua(Request $request)
    {
        $tipe = $request->input('tipe');

        if (!in_array($tipe, ['harian', 'tahunan'])) {
            return redirect()->back()->with('error', 'Tipe tidak valid.');
        }

        Buku::where('tipe', $tipe)->delete();

        return redirect()->back()->with('removeAll', "Semua buku {$tipe} berhasil dihapus.");
    }
}
