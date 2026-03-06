<?php

namespace App\Http\Controllers;

use App\Models\BukuPanduanGuru;
use App\Models\KodePanduanGuru;
use App\Models\PeminjamanGuru;
use App\Models\PeminjamanGuruDetail;
use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Services\NotificationService;

class PeminjamanGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjamans = PeminjamanGuru::with([
                'guru:id,nama,nip',
                'details.bukuPanduanGuru:id,judul,penulis',
                'details.kodePanduanGuru:id,buku_panduan_guru_id,kode_awal,kode_akhir,status'
            ])->where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id');
            })
                ->select(['id', 'guru_id', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'created_at'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($peminjamans)
                ->addIndexColumn()
                ->addColumn('nama_guru', function ($row) {
                    return $row->guru->nama ?? '-';
                })
                ->addColumn('nip', function ($row) {
                    return $row->guru->nip ?? '-';
                })
                ->addColumn('status_badge', function ($row) {
                    $class = $row->status === 'dipinjam' ? 'warning' : 'success';
                    return '<span class="badge badge-' . $class . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('buku_list', function ($row) {
                    $html = '<ul class="mb-0 pl-3">';
                    foreach ($row->details as $detail) {
                        $kode = $detail->kodePanduanGuru;
                        $buku = $detail->bukuPanduanGuru;
                        
                        // Badge color based on detail status
                        $badgeClass = 'badge-secondary';
                        if ($detail->status === 'dikembalikan') {
                            $badgeClass = 'badge-success';
                        } elseif ($detail->status === 'dipinjam') {
                            $badgeClass = 'badge-warning';
                        } elseif ($detail->status === 'hilang') {
                            $badgeClass = 'badge-danger';
                        }
                        
                        $kodeText = '[' . ($kode->kode_awal ?? '-') . ' - ' . ($kode->kode_akhir ?? '-') . ']';
                        $judul = $buku->judul ?? '-';
                        $statusText = ucfirst($detail->status ?? 'dipinjam');
                        
                        $html .= '<li><div class="mb-1">';
                        $html .= '<span class="badge ' . $badgeClass . '">' . $kodeText . '</span> ';
                        $html .= $judul . ' <small class="text-muted">(' . $statusText . ')</small>';
                        $html .= '</div></li>';
                    }
                    $html .= '</ul>';
                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('peminjamanguru.show', $row->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('peminjamanguru.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';

                    $canDelete = $row->status === 'selesai';
                    $deleteBtn = '<form action="' . route('peminjamanguru.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button class="btn btn-danger btn-sm" ' . ($canDelete ? '' : 'disabled title="Hanya peminjaman yang sudah selesai yang dapat dihapus"') . '><i class="fas fa-trash"></i></button>
                                  </form>';

                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['status_badge', 'buku_list', 'action'])
                ->make(true);
        }

        $userPeminjamanCount = PeminjamanGuru::where('user_id', Auth::id())->count();

        return view('peminjamanguru.index', compact('userPeminjamanCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::orderBy('nama', 'ASC')->get();
        
        // Get only available kode (status tersedia) from active books
        $kodes = KodePanduanGuru::with('bukuPanduanGuru:id,judul,penulis')
            ->where('status', 'tersedia')
            ->whereHas('bukuPanduanGuru', function($q) {
                $q->where('is_active', true);
            })
            ->get()
            ->map(function($kode) {
                return [
                    'id' => $kode->id,
                    'kode_text' => '[' . ($kode->kode_awal ?? '-') . ' - ' . ($kode->kode_akhir ?? '-') . ']',
                    'buku_info' => $kode->bukuPanduanGuru->judul . ' - ' . $kode->bukuPanduanGuru->penulis,
                    'display' => '[' . ($kode->kode_awal ?? '-') . ' - ' . ($kode->kode_akhir ?? '-') . '] ' . 
                                 $kode->bukuPanduanGuru->judul . ' - ' . $kode->bukuPanduanGuru->penulis
                ];
            });

        return view('peminjamanguru.create', compact('gurus', 'kodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kode_ids' => 'required|array|min:1',
            'kode_ids.*' => 'exists:kode_panduan_gurus,id'
        ]);

        DB::beginTransaction();

        try {
            $peminjaman = PeminjamanGuru::create([
                'user_id' => Auth::id(),
                'guru_id' => $request->guru_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'dipinjam'
            ]);

            foreach ($request->kode_ids as $kode_id) {
                // Get kode info
                $kode = KodePanduanGuru::findOrFail($kode_id);
                
                // Create detail
                PeminjamanGuruDetail::create([
                    'peminjaman_guru_id' => $peminjaman->id,
                    'buku_panduan_guru_id' => $kode->buku_panduan_guru_id,
                    'kode_panduan_guru_id' => $kode_id,
                    'status' => 'dipinjam',
                ]);
                
                // Update kode status to dipinjam
                $kode->update(['status' => 'dipinjam']);
            }

            DB::commit();

            // Create notification
            NotificationService::createPeminjamanGuruNotification($peminjaman->id);

            return redirect()->route('peminjamanguru.index')->with('success', 'Peminjaman guru berhasil disimpan.');
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
        $peminjaman = PeminjamanGuru::with([
            'guru',
            'details.bukuPanduanGuru',
            'details.kodePanduanGuru'
        ])->where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhereNull('user_id');
        })->findOrFail($id);

        return view('peminjamanguru.show', compact('peminjaman'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peminjaman = PeminjamanGuru::with([
            'details.bukuPanduanGuru',
            'details.kodePanduanGuru',
            'guru'
        ])->where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhereNull('user_id');
        })->findOrFail($id);

        $gurus = Guru::orderBy('nama', 'ASC')->get();

        return view('peminjamanguru.edit', compact('peminjaman', 'gurus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'guru_id' => 'required|exists:gurus,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,selesai',
            'detail_status' => 'array',
            'detail_status.*' => 'in:dipinjam,dikembalikan,hilang'
        ]);

        DB::beginTransaction();

        try {
            $peminjaman = PeminjamanGuru::where(function ($query) {
                $query->where('user_id', Auth::id())
                    ->orWhereNull('user_id');
            })->findOrFail($id);

            $peminjaman->update([
                'guru_id' => $request->guru_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => $request->status,
            ]);

            // Update status for each detail
            if ($request->has('detail_status')) {
                foreach ($request->detail_status as $detailId => $newStatus) {
                    $detail = PeminjamanGuruDetail::findOrFail($detailId);
                    $oldStatus = $detail->status;
                    
                    // Update detail status
                    $detail->update([
                        'status' => $newStatus,
                        'tanggal_dikembalikan' => ($newStatus === 'dikembalikan') ? now() : $detail->tanggal_dikembalikan
                    ]);
                    
                    // Update kode status
                    if ($detail->kodePanduanGuru) {
                        if ($newStatus === 'dikembalikan') {
                            // Return kode to tersedia
                            $detail->kodePanduanGuru->update(['status' => 'tersedia']);
                        } elseif ($newStatus === 'dipinjam' && $oldStatus !== 'dipinjam') {
                            // Mark as dipinjam
                            $detail->kodePanduanGuru->update(['status' => 'dipinjam']);
                        }
                        // For 'hilang', kode status stays 'dipinjam' but detail shows 'hilang'
                    }
                }
            }

            DB::commit();

            return redirect()->route('peminjamanguru.index')->with('success', 'Peminjaman guru berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = PeminjamanGuru::where(function ($query) {
            $query->where('user_id', Auth::id())
                ->orWhereNull('user_id');
        })->findOrFail($id);

        if ($peminjaman->status !== 'selesai') {
            return back()->with('error', 'Hanya peminjaman yang sudah selesai yang dapat dihapus.');
        }

        $peminjaman->delete();

        return redirect()->back()->with('success', 'Peminjaman guru berhasil dihapus!');
    }

    /**
     * Hapus semua data peminjaman guru
     */
    public function hapussemua()
    {
        PeminjamanGuru::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Semua data peminjaman guru Anda berhasil dihapus!');
    }
}
