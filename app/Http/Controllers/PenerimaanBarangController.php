<?php

namespace App\Http\Controllers;

use App\Imports\PenerimaanBarangImport;
use App\Models\PenerimaanBarang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PenerimaanBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        // Order by ID DESC so newest data (manual input) appears first
        $penerimaanBarangs = PenerimaanBarang::orderBy('id', 'DESC')->get();
        
        return view('penerimaanbarang.index', compact('penerimaanBarangs', 'profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        return view('penerimaanbarang.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'nama_pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        // Check for duplicate data
        $isDuplicate = PenerimaanBarang::where('nama_barang', $request->nama_barang)
            ->where('nama_pengarang', $request->nama_pengarang)
            ->where('penerbit', $request->penerbit)
            ->where('tahun', $request->tahun)
            ->where('tanggal_terima', $request->tanggal_terima)
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data dengan informasi yang sama sudah ada di database!');
        }

        PenerimaanBarang::create([
            'tanggal_terima' => $request->tanggal_terima,
            'nama_pengarang' => $request->nama_pengarang,
            'penerbit' => $request->penerbit,
            'nama_barang' => $request->nama_barang,
            'tahun' => $request->tahun,
        ]);
        
        return redirect()->route('penerimaanbarang.index')
                        ->with('success', 'Data penerimaan barang berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        $penerimaanBarang = PenerimaanBarang::findOrFail($id);
        
        return view('penerimaanbarang.show', compact('penerimaanBarang', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();
        
        $penerimaanBarang = PenerimaanBarang::findOrFail($id);
        
        return view('penerimaanbarang.edit', compact('penerimaanBarang', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal_terima' => 'required|date',
            'nama_pengarang' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'nama_barang' => 'required|string|max:255',
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
        ]);
        
        $penerimaanBarang = PenerimaanBarang::findOrFail($id);

        // Check for duplicate data (excluding current record)
        $isDuplicate = PenerimaanBarang::where('id', '!=', $id)
            ->where('nama_barang', $request->nama_barang)
            ->where('nama_pengarang', $request->nama_pengarang)
            ->where('penerbit', $request->penerbit)
            ->where('tahun', $request->tahun)
            ->where('tanggal_terima', $request->tanggal_terima)
            ->exists();

        if ($isDuplicate) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Data dengan informasi yang sama sudah ada di database!');
        }

        $penerimaanBarang->update([
            'tanggal_terima' => $request->tanggal_terima,
            'nama_pengarang' => $request->nama_pengarang,
            'penerbit' => $request->penerbit,
            'nama_barang' => $request->nama_barang,
            'tahun' => $request->tahun,
        ]);
        
        return redirect()->route('penerimaanbarang.index')
                        ->with('success', 'Data penerimaan barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penerimaanBarang = PenerimaanBarang::findOrFail($id);
        $penerimaanBarang->delete();
        
        return redirect()->route('penerimaanbarang.index')
                        ->with('success', 'Data penerimaan barang berhasil dihapus!');
    }

    /**
     * Import data penerimaan barang dari file Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048'
        ], [
            'file.required' => 'File Excel harus diupload',
            'file.mimes' => 'File harus berformat Excel (.xlsx atau .xls)',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $import = new PenerimaanBarangImport();
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
            \Log::error('Import error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage() . '. Pastikan format file sesuai dengan template!');
        }
    }

    /**
     * Download template Excel untuk import penerimaan barang
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template-penerimaan-barang.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'File template tidak ditemukan!');
        }

        return response()->download($filePath, 'Template_Penerimaan_Barang.xlsx');
    }
}
