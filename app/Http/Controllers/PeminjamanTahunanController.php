<?php

namespace App\Http\Controllers;

use App\Models\KodeBuku;
use App\Models\PeminjamanTahunan;
use App\Models\PeminjamanTahunanDetail;
use App\Models\Siswa;
use App\Models\Buku;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PeminjamanTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjamans = PeminjamanTahunan::with([
                'siswa:id,name',
                'details.kodeBuku:id,kode_buku,bukus_id',
                'details.kodeBuku.buku:id,judul'
            ])->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id'); // Tampilkan juga data dari Android
            })
                ->select(['id', 'siswas_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'created_at'])
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
                    $viewBtn = '<a href="' . route('peminjamantahunan.show', $row->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('peminjamantahunan.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';

                // Button delete hanya enabled jika status 'selesai'
                $canDelete = $row->status === 'selesai';
                    $deleteBtn = '<form action="' . route('peminjamantahunan.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button class="btn btn-danger btn-sm" ' . ($canDelete ? '' : 'disabled title="Hanya peminjaman yang sudah selesai yang dapat dihapus"') . '><i class="fas fa-trash"></i></button>
                                  </form>';

                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['status_badge', 'buku_list', 'action'])
                ->make(true);
        }

        // Hitung jumlah peminjaman user untuk menentukan apakah button hapus semua di-disable
        $userPeminjamanCount = PeminjamanTahunan::where('user_id', Auth::id())->count();

        return view('peminjamantahunan.index', compact('userPeminjamanCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswas = Siswa::all(); // pastikan model Siswa sudah disiapkan
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'tahunan')
                ->where('is_active', true); // Hanya buku yang aktif
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
                'user_id' => Auth::id(),
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

            // Buat notifikasi setelah peminjaman berhasil
            $notifCreated = NotificationService::createPeminjamanTahunanNotification($peminjaman->id);

            DB::commit();

            $message = 'Peminjaman berhasil disimpan.';
            if ($notifCreated) {
                $message .= ' Notifikasi telah dibuat.';
            }

            return redirect()->route('peminjamantahunan.index')->with('success', $message);
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
        ])->where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhereNull('user_id'); // Bisa akses data dari Android
        })->findOrFail($id);

        return view('peminjamantahunan.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = PeminjamanTahunan::with('details.kodeBuku.buku', 'siswa')
            ->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id'); // Bisa akses data dari Android
            })->findOrFail($id);
        $siswas = Siswa::all();
        $kode_bukus = KodeBuku::whereHas('buku', function ($q) {
            $q->where('tipe', 'tahunan')
                ->where('is_active', true); // Hanya buku yang aktif
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
            $peminjaman = PeminjamanTahunan::where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id'); // Bisa akses data dari Android
            })->findOrFail($id);

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
            $peminjaman = PeminjamanTahunan::with('details.kodeBuku')
                ->where(function ($query) {
                    $query->where('user_id', Auth::id())
                        ->orWhereNull('user_id'); // Bisa akses data dari Android
                })->findOrFail($id);

            // Validasi: Hanya peminjaman dengan status 'selesai' yang bisa dihapus
            if ($peminjaman->status !== 'selesai') {
                return redirect()->route('peminjamantahunan.index')
                    ->with('error', 'Data peminjaman tidak dapat dihapus karena masih berstatus "' . $peminjaman->status . '". Hanya peminjaman yang sudah selesai yang dapat dihapus.');
            }

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
            // Ambil semua data peminjaman milik user yang sedang login
            $peminjaman = PeminjamanTahunan::with('details')->where('user_id', Auth::id())->get();

            $deletedCount = 0;
            $skippedCount = 0;

            foreach ($peminjaman as $p) {
                // Skip peminjaman yang masih berstatus dipinjam
                if ($p->status !== 'selesai') {
                    $skippedCount++;
                    continue;
                }

                foreach ($p->details as $detail) {
                    // Reset status kode buku
                    if ($detail->kode_bukus_id) {
                        KodeBuku::where('id', $detail->kode_bukus_id)->update(['status' => 'tersedia']);
                    }
                }

                // Hapus detail peminjaman
                $p->details()->delete();
                $p->delete();
                $deletedCount++;
            }

            DB::commit();

            if ($deletedCount > 0 && $skippedCount == 0) {
                return redirect()->back()->with('removeAll', "Semua data peminjaman tahunan berhasil dihapus ({$deletedCount} data).");
            } elseif ($deletedCount > 0 && $skippedCount > 0) {
                return redirect()->back()->with('warning', "{$deletedCount} data berhasil dihapus. {$skippedCount} data tidak dapat dihapus karena masih berstatus dipinjam.");
            } else {
                return redirect()->back()->with('error', 'Tidak ada data yang dapat dihapus. Semua peminjaman masih berstatus dipinjam.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menghapus semua data: ' . $e->getMessage());
        }
    }

    /**
     * Get books filtered by student's class (for AJAX)
     */
    public function getBukuByKelas(Request $request)
    {
        $siswaId = $request->siswa_id;

        // Get student's class
        $siswa = Siswa::find($siswaId);

        if (!$siswa || !$siswa->kelas) {
            return response()->json([]);
        }

        // Extract base grade from student's class
        // e.g., "7A" -> "7", "8B" -> "8", "9C" -> "9"
        $kelasPattern = '/^([7-9])/';
        preg_match($kelasPattern, $siswa->kelas, $matches);
        $baseKelas = $matches[1] ?? null;

        if (!$baseKelas) {
            return response()->json([]);
        }

        // Get books that match student's base class and are active (strict matching)
        $bukus = Buku::where('tipe', 'tahunan')
            ->where('is_active', true)
            ->where('kelas', $baseKelas)
            ->get();

        // Get available kode_buku for each buku
        $result = [];
        foreach ($bukus as $buku) {
            $kodeBukus = KodeBuku::where('bukus_id', $buku->id)
                ->where('status', 'tersedia')
                ->get();

            foreach ($kodeBukus as $kodeBuku) {
                $result[] = [
                    'id' => $kodeBuku->id,
                    'text' => $kodeBuku->kode_buku . ' - ' . $buku->judul
                ];
            }
        }

        return response()->json($result);
    }
}
