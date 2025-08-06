<?php

namespace App\Http\Controllers;

use App\Models\KodeBuku;
use App\Models\PeminjamanHarian;
use App\Models\PeminjamanHarianDetail;
use App\Models\Siswa;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjamans = PeminjamanHarian::with([
                'siswa:id,name',
                'details.kodeBuku:id,kode_buku,bukus_id',
                'details.kodeBuku.buku:id,judul'
            ])->select(['id', 'siswas_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'created_at'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('nama_siswa', function ($row) {
                    return $row->siswa->name ?? '-';
                })
                ->addColumn('status_badge', function ($row) {
                    $class = $row->status === 'dipinjam' ? 'warning' : 'success';
                    return '<span class="badge badge-' . $class . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('buku_list', function ($row) {
                    $html = '<ul class="mb-0 pl-3">';
                    foreach ($row->details as $detail) {
                        $kode = $detail->kodeBuku->kode_buku ?? '???';
                        $judul = $detail->kodeBuku->buku->judul ?? '-';
                        $html .= '<li><div class="mb-1">[' . $kode . '] ' . $judul . '</div></li>';
                    }
                    $html .= '</ul>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('peminjamanharian.show', $row->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('peminjamanharian.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    $deleteBtn = '<form action="' . route('peminjamanharian.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                  </form>';

                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['status_badge', 'buku_list', 'action'])
                ->make(true);
        }

        return view('peminjamanharian.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::all(); // pastikan model Siswa sudah disiapkan
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'harian');
        })->where('status', '!=', 'dipinjam')->get();

        return view('peminjamanharian.create', compact('siswas', 'kode_bukus'));
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
            $peminjaman = PeminjamanHarian::create([
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
                PeminjamanHarianDetail::create([
                    'peminjaman_harians_id' => $peminjaman->id,
                    'kode_bukus_id' => $kode->id, // ← yang benar
                    'status' => 'dipinjam',
                ]);

                // Update status kode buku
                $kode->update(['status' => 'dipinjam']);
            }

            // Buat notifikasi setelah peminjaman berhasil
            NotificationService::createPeminjamanHarianNotification($peminjaman->id);

            DB::commit();
            return redirect()->route('peminjamanharian.index')->with('success', 'Peminjaman berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peminjaman = PeminjamanHarian::with([
            'siswa',
            'details.kodeBuku.buku' // nested relasi
        ])->findOrFail($id);

        return view('peminjamanharian.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $peminjaman = PeminjamanHarian::with('details.kodeBuku.buku', 'siswa')->findOrFail($id);
        $siswas = Siswa::all();
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'harian');
        })->where('status', '!=', 'dipinjam')->get();

        return view('peminjamanharian.edit', compact('peminjaman', 'siswas', 'kode_bukus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswas_id' => 'required',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kode_buku' => 'required|array|min:1',
        ]);

        DB::beginTransaction();
        try {
            $peminjaman = PeminjamanHarian::findOrFail($id);

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
            return redirect()->route('peminjamanharian.index')->with('success', 'Peminjaman berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            // Ambil data peminjaman
            $peminjaman = PeminjamanHarian::with('details.kodeBuku')->findOrFail($id);

            // Ubah status kode buku menjadi tersedia
            foreach ($peminjaman->details as $detail) {
                $detail->kodeBuku->update(['status' => 'tersedia']);
            }

            // Hapus semua detail peminjaman
            $peminjaman->details()->delete();

            // Hapus data utama peminjaman
            $peminjaman->delete();

            DB::commit();

            return redirect()->route('peminjamanharian.index')->with('success', 'Data peminjaman berhasil dihapus.');
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
            $peminjaman = PeminjamanHarian::with('details')->get();

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
            PeminjamanHarian::query()->delete();

            DB::commit();
            return redirect()->back()->with('removeAll', 'Semua data peminjaman harian berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus semua data: ' . $e->getMessage());
        }
    }
}
