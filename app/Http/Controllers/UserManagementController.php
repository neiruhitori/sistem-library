<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    /**
     * Check if user is Kepala Perpustakaan
     */
    private function checkKepalaAccess()
    {
        if (!Auth::check() || Auth::user()->role !== 'Kepala Perpustakaan') {
            abort(403, 'Unauthorized. Hanya Kepala Perpustakaan yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->checkKepalaAccess();
        
        if ($request->ajax()) {
            $users = User::select(['id', 'nip', 'name', 'email', 'role', 'created_at'])
                ->orderBy('created_at', 'desc');

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('nip_display', function ($row) {
                    return $row->nip ?? '-';
                })
                ->addColumn('role_display', function ($row) {
                    $badges = [
                        'Kepala Perpustakaan' => 'badge-danger',
                        'Petugas Perpustakaan' => 'badge-primary',
                        'Guru' => 'badge-info'
                    ];
                    $badge = $badges[$row->role] ?? 'badge-secondary';
                    return '<span class="badge ' . $badge . '">' . $row->role . '</span>';
                })
                ->addColumn('created_at_display', function ($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('usermanagement.edit', $row->id) . '" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>';
                    
                    // Add Transfer button for Kepala Perpustakaan
                    if ($row->role === 'Kepala Perpustakaan') {
                        $transferBtn = '<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#transferModal" data-user-id="' . $row->id . '" data-user-name="' . $row->name . '" title="Transfer Jabatan"><i class="fas fa-exchange-alt"></i></button>';
                        $deleteBtn = '<button class="btn btn-secondary btn-sm" disabled title="Kepala Perpustakaan tidak dapat dihapus"><i class="fas fa-ban"></i></button>';
                        return '<div class="btn-group" role="group">' . $editBtn . ' ' . $transferBtn . ' ' . $deleteBtn . '</div>';
                    } else {
                        $deleteBtn = '<form action="' . route('usermanagement.destroy', $row->id) . '" method="POST" onsubmit="return confirm(\'Yakin hapus user ini?\')" class="d-inline">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                      </form>';
                        return '<div class="btn-group" role="group">' . $editBtn . ' ' . $deleteBtn . '</div>';
                    }
                })
                ->rawColumns(['role_display', 'action'])
                ->make(true);
        }

        $userCount = User::count();
        $profile = User::where('id', Auth::id())->first();
        
        // Get all users except Kepala Perpustakaan for transfer dropdown
        $otherUsers = User::where('role', '!=', 'Kepala Perpustakaan')
            ->orderBy('name', 'asc')
            ->get();
        
        return view('usermanagement.index', compact('userCount', 'profile', 'otherUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->checkKepalaAccess();
        
        $profile = User::where('id', Auth::id())->first();
        
        // Available roles (exclude Kepala Perpustakaan for new users)
        $availableRoles = ['Petugas Perpustakaan', 'Guru'];
        
        return view('usermanagement.create', compact('profile', 'availableRoles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->checkKepalaAccess();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:users,nip',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:Petugas Perpustakaan,Guru',
        ]);

        User::create([
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'email_verified_at' => now(),
        ]);

        return redirect()->route('usermanagement.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->checkKepalaAccess();
        
        $user = User::findOrFail($id);
        $profile = User::where('id', Auth::id())->first();
        
        // Check if this is the current Kepala Perpustakaan
        $isKepala = $user->role === 'Kepala Perpustakaan';
        
        // Available roles for editing
        if ($isKepala) {
            $availableRoles = ['Kepala Perpustakaan']; // Cannot change role directly
        } else {
            $availableRoles = ['Petugas Perpustakaan', 'Guru'];
        }
        
        return view('usermanagement.edit', compact('user', 'profile', 'availableRoles', 'isKepala'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->checkKepalaAccess();
        
        $user = User::findOrFail($id);

        $validationRules = [
            'name' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $id,
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ];
        
        // Only validate role if user is not Kepala Perpustakaan
        if ($user->role !== 'Kepala Perpustakaan') {
            $validationRules['role'] = 'required|in:Petugas Perpustakaan,Guru';
        }

        $request->validate($validationRules);

        $data = [
            'name' => $request->name,
            'nip' => $request->nip,
            'email' => $request->email,
        ];
        
        // Only update role if not Kepala Perpustakaan
        if ($user->role !== 'Kepala Perpustakaan' && $request->filled('role')) {
            $data['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('usermanagement.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Transfer Kepala Perpustakaan role to another user
     */
    public function transferKepala(Request $request, string $id)
    {
        $this->checkKepalaAccess();
        
        $request->validate([
            'new_kepala_id' => 'required|exists:users,id',
        ]);

        $currentKepala = User::findOrFail($id);
        
        // Verify current user is Kepala Perpustakaan
        if ($currentKepala->role !== 'Kepala Perpustakaan') {
            return redirect()->back()->with('error', 'User ini bukan Kepala Perpustakaan!');
        }

        $newKepala = User::findOrFail($request->new_kepala_id);
        
        // Prevent transferring to self
        if ($currentKepala->id == $newKepala->id) {
            return redirect()->back()->with('error', 'Tidak dapat transfer ke diri sendiri!');
        }

        // Use transaction for safety
        DB::beginTransaction();
        try {
            // Demote current Kepala to Petugas
            $currentKepala->update(['role' => 'Petugas Perpustakaan']);
            
            // Promote new user to Kepala
            $newKepala->update(['role' => 'Kepala Perpustakaan']);
            
            DB::commit();
            
            return redirect()->route('usermanagement.index')
                ->with('success', 'Jabatan Kepala Perpustakaan berhasil ditransfer ke ' . $newKepala->name);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal transfer jabatan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->checkKepalaAccess();
        
        $user = User::findOrFail($id);
        
        // Prevent deleting current logged in user
        if ($user->id == Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus user yang sedang login!');
        }
        
        // Prevent deleting Kepala Perpustakaan
        if ($user->role === 'Kepala Perpustakaan') {
            return redirect()->back()->with('error', 'Tidak dapat menghapus Kepala Perpustakaan! Transfer jabatan terlebih dahulu.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }
}
