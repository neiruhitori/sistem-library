<?php

namespace App\Http\Controllers;

use App\Models\KodeBuku;
use App\Models\PeminjamanTahunan;
use App\Models\PeminjamanTahunanDetail;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjamans = PeminjamanTahunan::with([
            'siswa',
            'details.kodeBuku.buku' // ← ini akan bekerja jika relasi benar dan data benar
        ])->orderBy('created_at', 'desc')->get();

        return view('peminjamantahunan.index', compact('peminjamans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::all(); // pastikan model Siswa sudah disiapkan
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'tahunan');
        })->where('status', '!=', 'dipinjam')->get();

        return view('peminjamantahunan.create', compact('siswas', 'kode_bukus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kode_buku' => 'required|array|min:1',
            'kode_buku.*' => 'exists:kode_bukus,id'
        ]);

        DB::beginTransaction();

        try {
            $peminjaman = PeminjamanTahunan::create([
                'siswas_id' => $request->siswas_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dipinjam'
            ]);

            foreach ($request->kode_buku as $kode_id) {
                $kode = KodeBuku::findOrFail($kode_id);

                // Cek kalau kode buku sedang dipinjam
                if ($kode->status === 'dipinjam') {
                    throw new \Exception("Kode buku {$kode->kode_buku} sedang dipinjam.");
                }

                // Simpan detail peminjaman
                PeminjamanTahunanDetail::create([
                    'peminjaman_tahunans_id' => $peminjaman->id,
                    'kode_bukus_id' => $kode->id, // ← yang benar
                    'status' => 'dipinjam',
                ]);

                // Update status kode buku
                $kode->update(['status' => 'dipinjam']);
            }

            DB::commit();
            return redirect()->route('peminjamantahunan.index')->with('success', 'Peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $peminjaman = PeminjamanTahunan::with([
            'siswa',
            'details.kodeBuku.buku' // nested relasi
        ])->findOrFail($id);

        return view('peminjamantahunan.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = PeminjamanTahunan::with('details.kodeBuku.buku', 'siswa')->findOrFail($id);
        $siswas = Siswa::all();
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'tahunan');
        })->where('status', '!=', 'dipinjam')->get();

        return view('peminjamantahunan.edit', compact('peminjaman', 'siswas', 'kode_bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'siswas_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kode_buku' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = PeminjamanTahunan::findOrFail($id);

            // Kembalikan semua kode buku sebelumnya
            foreach ($peminjaman->details as $detail) {
                KodeBuku::where('id', $detail->kode_bukus_id)->update(['status' => 'tersedia']);
            }

            // Hapus detail sebelumnya
            $peminjaman->details()->delete();

            // Update data utama
            $peminjaman->update([
                'siswas_id' => $request->siswas_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
            ]);

            // Tambah ulang detail
            foreach ($request->kode_buku as $kode_id) {
                $kode = KodeBuku::findOrFail($kode_id);

                $peminjaman->details()->create([
                    'kode_bukus_id' => $kode->id,
                    'status' => 'dipinjam',
                ]);

                // Update status kode buku jadi dipinjam
                $kode->update(['status' => 'dipinjam']);
            }

            DB::commit();
            return redirect()->route('peminjamantahunan.index')->with('success', 'Peminjaman berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();

        try {
            // Ambil data peminjaman
            $peminjaman = PeminjamanTahunan::with('details.kodeBuku')->findOrFail($id);

            // Ubah status kode buku menjadi tersedia
            foreach ($peminjaman->details as $detail) {
                $detail->kodeBuku->update(['status' => 'tersedia']);
            }

            // Hapus semua detail peminjaman
            $peminjaman->details()->delete();

            // Hapus data utama peminjaman
            $peminjaman->delete();

            DB::commit();

            return redirect()->route('peminjamantahunan.index')->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function hapussemua()
    {
        DB::beginTransaction();
        try {
            // Ambil semua data peminjaman
            $peminjaman = PeminjamanTahunan::with('details')->get();

            foreach ($peminjaman as $p) {
                foreach ($p->details as $detail) {
                    // Reset status kode buku
                    if ($detail->kode_bukus_id) {
                        KodeBuku::where('id', $detail->kode_bukus_id)->update(['status' => 'tersedia']);
                    }
                }

                // Hapus detail peminjaman
                $p->details()->delete();
            }

            // Hapus semua peminjaman utama
            PeminjamanTahunan::query()->delete();

            DB::commit();
            return redirect()->back()->with('removeAll', 'Semua data peminjaman tahunan berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus semua data: ' . $e->getMessage());
        }
    }
}
