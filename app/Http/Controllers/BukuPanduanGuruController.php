<?php

namespace App\Http\Controllers;

use App\Imports\BukuPanduanGuruImport;
use App\Models\BukuPanduanGuru;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class BukuPanduanGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $bukus = BukuPanduanGuru::with(['kodePanduanGuru.peminjamanGuruDetails'])
                ->select(['id', 'penulis', 'judul', 'penerbit', 'tahun', 'is_active'])
                ->withCount(['kodePanduanGuru as stok' => function ($query) {
                    $query->where('status', 'tersedia');
                }])
                ->orderBy('id', 'desc');

            return DataTables::of($bukus)
                ->addIndexColumn()
                ->addColumn('kode', function ($row) {
                    // Display all kode with colored badges
                    $badges = $row->kodePanduanGuru->map(function($kode) {
                        // Get last peminjaman detail to check for 'hilang' status
                        $lastDetail = $kode->peminjamanGuruDetails()
                            ->latest('updated_at')
                            ->first();
                        
                        $hilang = $lastDetail && $lastDetail->status === 'hilang';
                        
                        // Determine badge color
                        $badgeClass = $hilang 
                            ? 'badge-secondary' 
                            : ($kode->status === 'dipinjam' 
                                ? 'badge-danger' 
                                : 'badge-success');
                        
                        $kodeText = '[' . ($kode->kode_awal ?: '-') . ' - ' . ($kode->kode_akhir ?: '-') . ']';
                        $hilangText = $hilang ? '<br><small class="text-white fst-italic">(Hilang)</small>' : '';
                        
                        return '<span class="badge ' . $badgeClass . ' mb-1 d-block">' . $kodeText . $hilangText . '</span>';
                    })->implode('');
                    
                    return $badges ?: '-';
                })
                ->addColumn('stok', function ($row) {
                    return '<span class="badge badge-info">' . $row->stok . '</span>';
                })
                ->addColumn('status', function ($row) {
                    if ($row->is_active) {
                        return '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>';
                    } else {
                        return '<span class="badge badge-secondary"><i class="fas fa-ban"></i> Nonaktif</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('bukupanduanguru.show', $row->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('bukupanduanguru.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    
                    // Check if book has been borrowed
                    $peminjamanCount = $row->peminjamanGuruDetails()->count();
                    $canDelete = $peminjamanCount == 0;
                    
                    $disabledAttr = $canDelete ? '' : 'disabled';
                    $titleAttr = $canDelete ? '' : 'title="Buku tidak dapat dihapus karena memiliki riwayat peminjaman"';
                    
                    $deleteBtn = '<form action="' . route('bukupanduanguru.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button class="btn btn-danger btn-sm" ' . $disabledAttr . ' ' . $titleAttr . '><i class="fas fa-trash"></i></button>
                                  </form>';
                    
                    // Toggle status button
                    $statusBtnClass = $row->is_active ? 'success' : 'secondary';
                    $statusBtnTitle = $row->is_active ? 'Nonaktifkan' : 'Aktifkan';
                    $statusIcon = $row->is_active ? 'check-circle' : 'ban';
                    
                    $statusBtn = '<form action="' . route('bukupanduanguru.toggle', $row->id) . '" method="POST" class="d-inline">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-' . $statusBtnClass . ' btn-sm" title="' . $statusBtnTitle . ' buku">
                                        <i class="fas fa-' . $statusIcon . '"></i>
                                    </button>
                                  </form>';
                    
                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $statusBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['kode', 'stok', 'status', 'action'])
                ->make(true);
        }

        $userBukuCount = BukuPanduanGuru::count();
        return view('bukupanduanguru.index', compact('userBukuCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        return view('bukupanduanguru.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'penulis' => 'required|string|max:100',
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:100',
            'tahun' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'kode_awal' => 'required|array|min:1',
            'kode_awal.*' => 'nullable|string|max:50',
            'kode_akhir' => 'required|array|min:1',
            'kode_akhir.*' => 'nullable|string|max:50'
        ];

        $request->validate($rules);

        // Validasi: setiap pair kode_awal dan kode_akhir tidak boleh kosong semua
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

        // Create buku panduan guru (1 record)
        $buku = BukuPanduanGuru::create([
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun ?: null,
        ]);

        // Create multiple kode records (relasi hasMany)
        $createdCount = 0;
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';

            // Skip if both are empty
            if (empty($kodeAwal) && empty($kodeAkhir)) {
                continue;
            }

            $buku->kodePanduanGuru()->create([
                'kode_awal' => trim($kodeAwal),
                'kode_akhir' => trim($kodeAkhir),
            ]);

            $createdCount++;
        }

        return redirect()->route('bukupanduanguru.index')->with('success', "Data buku panduan guru berhasil ditambahkan dengan {$createdCount} kode buku!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $buku = BukuPanduanGuru::with('kodePanduanGuru')->findOrFail($id);

        return view('bukupanduanguru.show', compact('buku', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $buku = BukuPanduanGuru::with('kodePanduanGuru')->findOrFail($id);

        return view('bukupanduanguru.edit', compact('buku', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'penulis' => 'required|string|max:100',
            'judul' => 'required|string|max:255',
            'penerbit' => 'required|string|max:100',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'kode_awal' => 'required|array|min:1',
            'kode_awal.*' => 'nullable|string|max:50',
            'kode_akhir' => 'required|array|min:1',
            'kode_akhir.*' => 'nullable|string|max:50'
        ];

        $request->validate($rules);

        // Validasi: setiap pair kode_awal dan kode_akhir tidak boleh kosong semua
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

        $buku = BukuPanduanGuru::findOrFail($id);

        // Update buku data
        $buku->update([
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun ?: null,
        ]);

        // Delete old kode records
        $buku->kodePanduanGuru()->delete();

        // Create new kode records
        $createdCount = 0;
        foreach ($request->kode_awal as $index => $kodeAwal) {
            $kodeAkhir = $request->kode_akhir[$index] ?? '';

            // Skip if both are empty
            if (empty($kodeAwal) && empty($kodeAkhir)) {
                continue;
            }

            $buku->kodePanduanGuru()->create([
                'kode_awal' => trim($kodeAwal),
                'kode_akhir' => trim($kodeAkhir),
            ]);

            $createdCount++;
        }

        return redirect()->route('bukupanduanguru.index')->with('success', "Data buku panduan guru berhasil diperbarui dengan {$createdCount} kode buku!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $buku = BukuPanduanGuru::with(['kodePanduanGuru', 'peminjamanGuruDetails'])->findOrFail($id);

        // Cek apakah buku pernah dipinjam
        $peminjamanCount = $buku->peminjamanGuruDetails()->count();

        if ($peminjamanCount > 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak dapat dihapus karena memiliki riwayat peminjaman. Gunakan tombol nonaktifkan untuk menyembunyikan buku dari daftar peminjaman.');
        }

        // Cek apakah ada kode buku yang sedang dipinjam
        $kodeBukuDipinjam = $buku->kodePanduanGuru()->where('status', 'dipinjam')->count();
        if ($kodeBukuDipinjam > 0) {
            return redirect()->back()
                ->with('error', 'Buku tidak dapat dihapus karena masih ada yang sedang dipinjam.');
        }

        // Jika aman, hapus kode buku terlebih dahulu, lalu hapus buku
        $buku->kodePanduanGuru()->delete();
        $buku->delete();

        return redirect()->back()->with('success', 'Buku panduan guru berhasil dihapus!');
    }

    /**
     * Toggle status aktif/nonaktif buku
     */
    public function toggleStatus($id)
    {
        $buku = BukuPanduanGuru::findOrFail($id);

        // Toggle status
        $buku->is_active = !$buku->is_active;
        $buku->save();

        $status = $buku->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $message = "Buku \"{$buku->judul}\" berhasil {$status}.";

        if (!$buku->is_active) {
            $message .= " Buku ini tidak akan muncul dalam daftar peminjaman.";
        }

        return redirect()->route('bukupanduanguru.index')
            ->with('success', $message);
    }

    public function exportPDF(Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $bukus = BukuPanduanGuru::orderBy('kode_awal', 'ASC')->get();

        $pdf = PDF::loadView('bukupanduanguru.pdf', compact('bukus', 'profile'));
        return $pdf->stream('Daftar_Buku_Panduan_Guru_SMPN_02_Klakah.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $import = new BukuPanduanGuruImport();
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            $message = sprintf(
                'Import berhasil! Total: %d buku. Baru: %d, Diperbarui: %d, Dilewati (duplikat): %d',
                $summary['total'],
                $summary['new'],
                $summary['updated'],
                $summary['skipped']
            );

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import buku panduan guru
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template-bukuguru.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file tidak ditemukan!');
        }

        return response()->download($filePath);
    }

    /**
     * Hapus semua data buku panduan guru
     */
    public function hapussemua()
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate tables
        DB::table('kode_panduan_gurus')->truncate();
        DB::table('buku_panduan_gurus')->truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        return redirect()->back()->with('success', 'Semua data buku panduan guru berhasil dihapus!');
    }
}
