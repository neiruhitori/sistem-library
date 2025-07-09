<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanHarianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $details = PeminjamanHarianDetail::with(['peminjaman.siswa', 'kodeBuku.buku'])
            ->where('status', 'dipinjam')
            ->orderByDesc('created_at')
            ->get();

        return view('pengembalianharian.index', compact('details'));
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
        //
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
    public function update(PeminjamanHarianDetail $detail)
    {
        DB::beginTransaction();
        try {
            // Update status detail
            $detail->update([
                'status' => 'dikembalikan',
                'tanggal_dikembalikan' => now(),
            ]);

            // Update status kode_buku kembali menjadi tersedia
            $detail->kodeBuku->update([
                'status' => 'tersedia'
            ]);

            // Cek apakah semua buku di peminjaman ini sudah dikembalikan
            $semuaSudah = $detail->peminjaman->details()->where('status', 'dipinjam')->count() === 0;

            // Jika semua sudah, update status di tabel utama
            if ($semuaSudah) {
                $detail->peminjaman->update([
                    'status' => 'selesai'
                ]);
            }

            DB::commit();
            return redirect()->route('pengembalianharian.index')->with('success', 'Buku berhasil dikembalikan');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengembalikan buku: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
