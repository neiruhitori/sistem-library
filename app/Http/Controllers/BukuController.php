<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\PenerimaanBarang;
use App\Imports\BukuHarianImport;
use App\Imports\BukuTahunanImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexHarian()
    {
        $bukus = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails', 'penerbit']) // <-- perlu eager load relasi
            ->withCount(['kodeBuku as stok' => function ($query) {
                $query->where('status', 'tersedia');
            }])
            ->where('tipe', 'harian')
            ->get();

        return view('buku.index', compact('bukus'))->with('tipe', 'harian');
    }

    public function indexTahunan()
    {
        $bukus = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails', 'penerbit']) // <-- perlu eager load relasi
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

        $penerbits = PenerimaanBarang::select('id', 'penerbit', 'nama_barang')
            ->whereNotNull('penerbit')
            ->where('penerbit', '!=', '')
            ->orderBy('penerbit')
            ->get();

        return view('buku.form', [
            'tipe' => $tipe,
            'penerbits' => $penerbits
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
            'penerbit_id' => 'nullable|exists:penerimaan_barangs,id',
            'tipe' => 'required|in:harian,tahunan',
            'tahun_terbit' => 'nullable|digits:4',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_awal' => 'required|array|min:1',
            'kode_awal.*' => 'nullable|string',
            'kode_akhir' => 'required|array|min:1',
            'kode_akhir.*' => 'nullable|string'
        ];

        // Tambahkan validasi kelas jika tipe tahunan
        if ($request->tipe === 'tahunan') {
            $rules['kelas'] = 'required|in:7,8,9';
        }

        $request->validate($rules);

        // Validasi custom: setiap pair kode_awal dan kode_akhir tidak boleh kosong semua
        $hasValidPair = false;
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';
            if (!empty($kodeAwal) || !empty($kodeAkhir)) {
                $hasValidPair = true;
                break;
            }
        }

        if (!$hasValidPair) {
            return back()->withErrors(['kode_buku' => 'Minimal harus ada satu kode buku yang diisi (kode awal atau kode akhir).'])->withInput();
        }

        // Generate kode_buku array from multiple kode_awal and kode_akhir pairs
        $kodeBukuArray = [];
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';

            // Skip if both are empty
            if (empty($kodeAwal) && empty($kodeAkhir)) {
                continue;
            }

            $generated = $this->generateKodeBuku($kodeAwal, $kodeAkhir);
            $kodeBukuArray = array_merge($kodeBukuArray, $generated);
        }

        // Remove duplicates
        $kodeBukuArray = array_unique($kodeBukuArray);

        // Validate generated kode_buku uniqueness
        $existingKodes = \App\Models\KodeBuku::whereIn('kode_buku', $kodeBukuArray)->pluck('kode_buku')->toArray();
        if (count($existingKodes) > 0) {
            return back()->withErrors(['kode_buku' => 'Kode buku berikut sudah ada: ' . implode(', ', $existingKodes)])->withInput();
        }

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
            'penerbit_id' => $request->penerbit_id,
            'tipe' => $request->tipe,
            'kelas' => $request->tipe === 'tahunan' ? $request->kelas : null,
            'tahun_terbit' => $request->tahun_terbit,
            'description' => $request->description,
            'foto' => $fotoPath,
        ]);

        foreach ($kodeBukuArray as $kode) {
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
        $buku = Buku::with(['kodeBuku', 'penerbit'])->findOrFail($id);
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

        $penerbits = PenerimaanBarang::select('id', 'penerbit', 'nama_barang')
            ->whereNotNull('penerbit')
            ->where('penerbit', '!=', '')
            ->orderBy('penerbit')
            ->get();

        return view('buku.form', compact('buku', 'tipe', 'penerbits'));
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
            'penerbit_id' => 'nullable|exists:penerimaan_barangs,id',
            'tahun_terbit' => 'nullable|digits:4',
            'description' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kode_awal' => 'required|array|min:1',
            'kode_awal.*' => 'nullable|string',
            'kode_akhir' => 'required|array|min:1',
            'kode_akhir.*' => 'nullable|string'
        ];

        // Tambahkan validasi kelas jika tipe tahunan
        if ($buku->tipe === 'tahunan') {
            $rules['kelas'] = 'required|in:7,8,9';
        }

        $request->validate($rules);

        // Validasi custom: setiap pair kode_awal dan kode_akhir tidak boleh kosong semua
        $hasValidPair = false;
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';
            if (!empty($kodeAwal) || !empty($kodeAkhir)) {
                $hasValidPair = true;
                break;
            }
        }

        if (!$hasValidPair) {
            return back()->withErrors(['kode_buku' => 'Minimal harus ada satu kode buku yang diisi (kode awal atau kode akhir).'])->withInput();
        }

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
            'penerbit_id' => $request->penerbit_id,
            'kelas' => $buku->tipe === 'tahunan' ? $request->kelas : null,
            'tahun_terbit' => $request->tahun_terbit,
            'description' => $request->description
        ]);

        // Generate kode_buku array from multiple kode_awal and kode_akhir pairs
        $kodeBukuArray = [];
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';

            // Skip if both are empty
            if (empty($kodeAwal) && empty($kodeAkhir)) {
                continue;
            }

            $generated = $this->generateKodeBuku($kodeAwal, $kodeAkhir);
            $kodeBukuArray = array_merge($kodeBukuArray, $generated);
        }

        // Remove duplicates
        $kodeBukuArray = array_unique($kodeBukuArray);

        // Validate generated kode_buku uniqueness (excluding current book's codes)
        $existingKodes = \App\Models\KodeBuku::whereIn('kode_buku', $kodeBukuArray)
            ->where('bukus_id', '!=', $buku->id)
            ->pluck('kode_buku')
            ->toArray();
        if (count($existingKodes) > 0) {
            return back()->withErrors(['kode_buku' => 'Kode buku berikut sudah ada: ' . implode(', ', $existingKodes)])->withInput();
        }

        $existingCodes = $buku->kodeBuku->pluck('kode_buku')->toArray();
        $newCodes = $kodeBukuArray;

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

    /**
     * Import buku harian dari file Excel
     */
    public function importHarian(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ], [
            'file.required' => 'File Excel harus diupload',
            'file.mimes' => 'File harus berformat Excel (.xlsx atau .xls)',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $import = new BukuHarianImport();
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            if ($summary['success'] > 0) {
                $message = sprintf(
                    'Import berhasil! Total: %d data. Berhasil: %d, Gagal: %d, Duplikat (di-skip): %d',
                    $summary['total'],
                    $summary['success'],
                    $summary['failed'],
                    $summary['duplicate']
                );
                return redirect()->back()->with('success', $message);
            } else {
                $message = sprintf(
                    'Import gagal! Total data: %d. Berhasil: %d, Gagal: %d, Duplikat (di-skip): %d. Periksa format file Excel dan pastikan sesuai dengan template.',
                    $summary['total'],
                    $summary['success'],
                    $summary['failed'],
                    $summary['duplicate']
                );
                return redirect()->back()->with('error', $message);
            }
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage() . '. Pastikan format file sesuai dengan template!');
        }
    }

    /**
     * Import buku tahunan dari file Excel
     */
    public function importTahunan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
            'kelas' => 'required|in:7,8,9'
        ], [
            'file.required' => 'File Excel harus diupload',
            'file.mimes' => 'File harus berformat Excel (.xlsx atau .xls)',
            'file.max' => 'Ukuran file maksimal 2MB',
            'kelas.required' => 'Kelas harus dipilih'
        ]);

        try {
            $import = new BukuTahunanImport($request->kelas);
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            if ($summary['success'] > 0) {
                $message = sprintf(
                    'Import berhasil untuk kelas %s! Total: %d data. Berhasil: %d, Gagal: %d, Duplikat (di-skip): %d',
                    $request->kelas,
                    $summary['total'],
                    $summary['success'],
                    $summary['failed'],
                    $summary['duplicate']
                );
                return redirect()->back()->with('success', $message);
            } else {
                $message = sprintf(
                    'Import gagal! Total data: %d. Berhasil: %d, Gagal: %d, Duplikat (di-skip): %d. Periksa format file Excel dan pastikan sesuai dengan template.',
                    $summary['total'],
                    $summary['success'],
                    $summary['failed'],
                    $summary['duplicate']
                );
                return redirect()->back()->with('error', $message);
            }
        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage() . '. Pastikan format file sesuai dengan template!');
        }
    }

    /**
     * Download template Excel untuk import buku harian
     */
    public function downloadTemplateHarian()
    {
        $filePath = public_path('templates/template-bukuharian.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }

        return response()->download($filePath, 'Template_Buku_Harian.xlsx');
    }

    /**
     * Download template Excel untuk import buku tahunan
     */
    public function downloadTemplateTahunan()
    {
        $filePath = public_path('templates/template-bukutahunan.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }

        return response()->download($filePath, 'Template_Buku_Tahunan.xlsx');
    }

    /**
     * Generate kode_buku by concatenating kode_awal and kode_akhir with dash
     */
    private function generateKodeBuku($kodeAwal, $kodeAkhir)
    {
        // Trim both values
        $kodeAwal = trim($kodeAwal);
        $kodeAkhir = trim($kodeAkhir);

        // Handle empty values
        if (empty($kodeAwal) && empty($kodeAkhir)) {
            return [];
        }

        // If both have values, concatenate with " - "
        if (!empty($kodeAwal) && !empty($kodeAkhir)) {
            $kodeBuku = $kodeAwal . ' - ' . $kodeAkhir;
        }
        // If only one has value, use that one
        else {
            $kodeBuku = !empty($kodeAwal) ? $kodeAwal : $kodeAkhir;
        }

        // Return as array with single element
        return [$kodeBuku];
    }
}