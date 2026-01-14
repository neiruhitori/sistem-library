<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexHarian()
    {
        $bukus = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails']) // <-- perlu eager load relasi
            ->withCount(['kodeBuku as stok' => function ($query) {
                $query->where('status', 'tersedia');
            }])
            ->where('tipe', 'harian')
            ->get();

        return view('buku.index', compact('bukus'))->with('tipe', 'harian');
    }

    public function indexTahunan()
    {
        $bukus = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails']) // <-- perlu eager load relasi
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
        $rules = [
            'judul' => 'required',
            'penulis' => 'nullable|string',
            'tipe' => 'required|in:harian,tahunan',
            'tahun_terbit' => 'nullable|digits:4',
            'isbn' => 'nullable|string',
            'kota_cetak' => 'nullable|string',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_buku' => 'required|array|min:1',
            'kode_buku.*' => 'required|string|distinct|unique:kode_bukus,kode_buku'
        ];

        // Tambahkan validasi kelas jika tipe tahunan
        if ($request->tipe === 'tahunan') {
            $rules['kelas'] = 'required|in:7,8,9';
        }

        $request->validate($rules);

        // Set foto: upload, default, atau null
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('bukus', 'public');
        } else {
            // Set default image based on book type
            $fotoPath = $request->tipe === 'harian' ? 'sampulbuku/bukuharian.png' : 'sampulbuku/bukutahunan.jpg';
        }

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'tipe' => $request->tipe,
            'kelas' => $request->tipe === 'tahunan' ? $request->kelas : null,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'kota_cetak' => $request->kota_cetak,
            'description' => $request->description,
            'foto' => $fotoPath,
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
        $buku = Buku::with('kodeBuku')->findOrFail($id);
        $tipe = $buku->tipe;

        return view('buku.show', compact('buku', 'tipe'));
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

        $rules = [
            'judul' => 'required',
            'penulis' => 'nullable|string',
            'tahun_terbit' => 'nullable|digits:4',
            'isbn' => 'nullable|string',
            'kota_cetak' => 'nullable|string',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_buku' => 'required|array|min:1',
            'kode_buku.*' => 'required|string|distinct'
        ];

        // Tambahkan validasi kelas jika tipe tahunan
        if ($buku->tipe === 'tahunan') {
            $rules['kelas'] = 'required|in:7,8,9';
        }

        $request->validate($rules);

        // Update foto only if new file uploaded
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('bukus', 'public');
            $buku->foto = $fotoPath;
        } elseif (!$buku->foto) {
            // Set default if no existing photo
            $buku->foto = $buku->tipe === 'harian' ? 'sampulbuku/bukuharian.png' : 'sampulbuku/bukutahunan.jpg';
        }

        $buku->update([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kelas' => $buku->tipe === 'tahunan' ? $request->kelas : null,
            'tahun_terbit' => $request->tahun_terbit,
            'isbn' => $request->isbn,
            'kota_cetak' => $request->kota_cetak,
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
        $buku = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails'])->findOrFail($id);
        $tipe = $buku->tipe;

        // Cek apakah buku pernah dipinjam (baik harian maupun tahunan)
        $peminjamanHarianCount = $buku->peminjamanHarianDetails()->count();
        $peminjamanTahunanCount = $buku->peminjamanTahunanDetails()->count();

        if ($peminjamanHarianCount > 0 || $peminjamanTahunanCount > 0) {
            return redirect()->route($tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
                ->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman. Data peminjaman harus tetap tersimpan untuk keperluan arsip.');
        }

        // Cek apakah ada kode buku yang sedang dipinjam
        $kodeBukuDipinjam = $buku->kodeBuku()->where('status', 'dipinjam')->count();
        if ($kodeBukuDipinjam > 0) {
            return redirect()->route($tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
                ->with('error', 'Buku tidak dapat dihapus karena masih ada yang sedang dipinjam.');
        }

        // Jika aman, hapus kode buku terlebih dahulu, lalu hapus buku
        $buku->kodeBuku()->delete();
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

        $bukus = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails'])
            ->where('tipe', $tipe)
            ->get();

        $deletedCount = 0;
        $skippedCount = 0;
        $skippedTitles = [];

        foreach ($bukus as $buku) {
            // Cek apakah buku pernah dipinjam
            $peminjamanHarianCount = $buku->peminjamanHarianDetails()->count();
            $peminjamanTahunanCount = $buku->peminjamanTahunanDetails()->count();

            // Cek apakah ada kode buku yang sedang dipinjam
            $kodeBukuDipinjam = $buku->kodeBuku()->where('status', 'dipinjam')->count();

            if ($peminjamanHarianCount > 0 || $peminjamanTahunanCount > 0 || $kodeBukuDipinjam > 0) {
                $skippedCount++;
                $skippedTitles[] = $buku->judul;
                continue; // Skip buku ini
            }

            // Aman untuk dihapus
            $buku->kodeBuku()->delete();
            $buku->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0 && $skippedCount == 0) {
            return redirect()->back()->with('removeAll', "Semua buku {$tipe} berhasil dihapus ({$deletedCount} buku).");
        } elseif ($deletedCount > 0 && $skippedCount > 0) {
            $message = "{$deletedCount} buku berhasil dihapus. {$skippedCount} buku tidak dapat dihapus karena memiliki riwayat peminjaman atau sedang dipinjam.";
            return redirect()->back()->with('warning', $message);
        } else {
            return redirect()->back()->with('error', "Tidak ada buku yang dapat dihapus. Semua buku memiliki riwayat peminjaman atau sedang dipinjam.");
        }
    }

    /**
     * Toggle status aktif/nonaktif buku
     */
    public function toggleStatus($id)
    {
        $buku = Buku::findOrFail($id);
        $tipe = $buku->tipe;

        // Toggle status
        $buku->is_active = !$buku->is_active;
        $buku->save();

        $status = $buku->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $message = "Buku \"{$buku->judul}\" berhasil {$status}.";

        if (!$buku->is_active) {
            $message .= " Buku ini tidak akan muncul dalam daftar peminjaman.";
        }

        return redirect()->route($tipe == 'harian' ? 'buku.harian' : 'buku.tahunan')
            ->with('success', $message);
    }
}