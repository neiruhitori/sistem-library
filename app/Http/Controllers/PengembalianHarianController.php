<?php

namespace App\Http\Controllers;

use App\Models\CatatanDenda;
use App\Models\PeminjamanHarianDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
    public function update(Request $request, PeminjamanHarianDetail $detail)
    {
        DB::beginTransaction();
        try {
            $kondisi = $request->input('kondisi_buku'); // input: 'baik', 'hilang', 'rusak'
            $siswaId = $detail->peminjaman->siswas_id;

            $tglKembali = \Carbon\Carbon::parse($detail->peminjaman->tanggal_kembali);
            $tglSekarang = now();
            $detail->tanggal_dikembalikan = $tglSekarang;

            $detail->status = 'dikembalikan';
            $keteranganList = [];
            $dendaTotal = 0;
            $dendaList = [];

            // ✅ 1. Cek keterlambatan OTOMATIS (sistem menghitung sendiri)
            if ($tglSekarang->gt($tglKembali)) {
                $selisihHari = $tglKembali->copy()->startOfDay()->diffInDays($tglSekarang->copy()->startOfDay());
                if ($selisihHari > 0) {
                    $dendaList[] = [
                        'jenis_denda' => 'terlambat',
                        'jumlah' => $selisihHari * 1000,
                        'keterangan' => "Terlambat $selisihHari hari dari tanggal seharusnya",
                    ];
                    $dendaTotal += $selisihHari * 1000;
                    $keteranganList[] = "Terlambat $selisihHari hari";
                }
            }

            // ✅ 2. Denda karena hilang
            if ($kondisi === 'hilang') {
                $dendaList[] = [
                    'jenis_denda' => 'hilang',
                    'jumlah' => 50000,
                    'keterangan' => 'Buku hilang saat pengembalian',
                ];
                $dendaTotal += 50000;
                $detail->status = 'hilang';
                $keteranganList[] = "Buku hilang";
            }

            // ✅ 3. Denda karena rusak
            if ($kondisi === 'rusak') {
                $jenisKerusakan = $request->input('jenis_kerusakan', 'Tidak disebutkan');
                $rusakParah = ($jenisKerusakan === 'Rusak parah (tidak bisa dipinjam)');

                $dendaList[] = [
                    'jenis_denda' => 'rusak',
                    'jumlah' => 10000,
                    'keterangan' => "Buku rusak saat pengembalian - Jenis: $jenisKerusakan",
                ];
                $dendaTotal += 10000;
                $detail->status = 'rusak';
                $keteranganList[] = "Buku rusak ($jenisKerusakan)";
            }

            $detail->save();

            // Kode buku kembali tersedia:
            // - Jika kondisi baik (dengan atau tanpa keterlambatan) → tersedia
            // - Jika hilang → tidak tersedia
            // - Jika rusak ringan → tersedia
            // - Jika rusak parah → tidak tersedia
            if ($kondisi === 'baik') {
                $detail->kodeBuku->update(['status' => 'tersedia']);
            } elseif ($kondisi === 'rusak') {
                $jenisKerusakan = $request->input('jenis_kerusakan', '');
                $rusakParah = ($jenisKerusakan === 'Rusak parah (tidak bisa dipinjam)');

                if (!$rusakParah) {
                    // Rusak ringan, buku masih bisa dipinjam
                    $detail->kodeBuku->update(['status' => 'tersedia']);
                }
                // Jika rusak parah, status tetap (tidak diupdate ke tersedia)
            }
            // Jika hilang, status tidak diupdate (tetap dipinjam/tidak tersedia)

            // ✅ 3. Simpan catatan denda jika ada
            foreach ($dendaList as $item) {
                CatatanDenda::create([
                    'siswas_id' => $siswaId,
                    'tipe_peminjaman' => 'harian',
                    'peminjaman_harians_id' => $detail->peminjaman->id,
                    'referensi_id' => $detail->id,
                    'jenis_denda' => $item['jenis_denda'],
                    'jumlah' => $item['jumlah'],
                    'keterangan' => $item['keterangan'],
                    'tanggal_denda' => $tglSekarang->toDateString(),
                    'status' => 'belum_dibayar',
                    'handled_by_user_id' => Auth::id(), // User yang menangani pengembalian
                ]);
            }

            // ✅ 4. Cek apakah semua buku sudah dikembalikan
            $semuaSudah = $detail->peminjaman->details()->where('status', 'dipinjam')->count() === 0;
            if ($semuaSudah) {
                $detail->peminjaman->update(['status' => 'selesai']);
            }

            DB::commit();
            return redirect()->route('pengembalianharian.index')
                ->with('success', 'Buku berhasil dikembalikan' . (count($keteranganList) ? ' (' . implode(', ', $keteranganList) . ')' : ''));
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
