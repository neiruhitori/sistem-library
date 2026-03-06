<?php

namespace App\Http\Controllers;

use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $gurus = Guru::select(['id', 'nip', 'nama', 'tambahantugas', 'keterangan', 'status'])
                ->orderBy('nama', 'asc');

            return DataTables::of($gurus)
                ->addIndexColumn()
                ->addColumn('nip_display', function ($row) {
                    return $row->nip ? "" . $row->nip : '-';
                })
                ->addColumn('tambahantugas_display', function ($row) {
                    return $row->tambahantugas ?? '-';
                })
                ->addColumn('keterangan_display', function ($row) {
                    return $row->keterangan ? \Illuminate\Support\Str::limit($row->keterangan, 50) : '-';
                })
                ->addColumn('status_display', function ($row) {
                    if ($row->status == 'Aktif') {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-secondary">Tidak Aktif</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $viewBtn = '<a href="' . route('guru.show', $row->id) . '" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a>';
                    $editBtn = '<a href="' . route('guru.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    $deleteBtn = '<form action="' . route('guru.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus data ini?\')" class="d-inline">
                                    ' . csrf_field() . method_field('DELETE') . '
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                  </form>';
                    return '<div class="btn-group" role="group">' . $viewBtn . ' ' . $editBtn . ' ' . $deleteBtn . '</div>';
                })
                ->rawColumns(['status_display', 'action'])
                ->make(true);
        }

        $userGuruCount = Guru::count();
        $guruData = Guru::orderBy('nama', 'asc')->get();
        return view('guru.index', compact('userGuruCount', 'guruData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        return view('guru.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:1|max:100',
            'nip' => 'nullable|string|max:50',
            'tambahantugas' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string'
        ]);

        Guru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tambahantugas' => $request->tambahantugas,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $guru = Guru::findOrFail($id);

        return view('guru.show', compact('guru', 'profile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $guru = Guru::findOrFail($id);

        return view('guru.edit', compact('guru', 'profile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|min:1|max:100',
            'nip' => 'nullable|string|max:50',
            'tambahantugas' => 'nullable|string|max:100',
            'keterangan' => 'nullable|string'
        ]);

        $guru = Guru::findOrFail($id);

        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'tambahantugas' => $request->tambahantugas,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = Guru::findOrFail($id);
        $guru->delete();

        return redirect()->back()->with('success', 'Guru berhasil dihapus!');
    }

    public function exportPDF(Request $request)
    {
        $iduser = Auth::id();
        $profile = User::where('id', $iduser)->first();

        $gurus = Guru::orderBy('nama', 'ASC')->get();

        $pdf = PDF::loadView('guru.pdf', compact('gurus', 'profile'));
        return $pdf->stream('Daftar_Guru_SMPN_02_Klakah.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $import = new GuruImport();
            Excel::import($import, $request->file('file'));

            $summary = $import->getSummary();

            $message = sprintf(
                'Import berhasil! Total: %d guru. Baru: %d, Diperbarui: %d',
                $summary['total'],
                $summary['new'],
                $summary['updated']
            );

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal import data: ' . $e->getMessage());
        }
    }

    /**
     * Download template Excel untuk import guru
     */
    public function downloadTemplate()
    {
        $filePath = public_path('templates/template-guru.xlsx');

        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'Template file tidak ditemukan!');
        }

        return response()->download($filePath);
    }

    /**
     * Bulk update status guru
     */
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'guru_ids' => 'required|array|min:1',
            'guru_ids.*' => 'exists:gurus,id',
            'status' => 'required|in:Aktif,Tidak Aktif'
        ]);

        try {
            \DB::beginTransaction();

            $updated = Guru::whereIn('id', $request->guru_ids)
                ->update(['status' => $request->status]);

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengubah status {$updated} guru menjadi {$request->status}"
            ]);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus semua data guru
     */
    public function hapussemua()
    {
        Guru::truncate();
        return redirect()->back()->with('success', 'Semua data guru berhasil dihapus!');
    }
}
