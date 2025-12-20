<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Siswa;
use App\Models\Buku;
use App\Models\PeminjamanHarian;
use App\Models\PeminjamanTahunan;
use App\Models\PeminjamanHarianDetail;
use App\Models\PeminjamanTahunanDetail;
use App\Models\CatatanDenda;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        try {
            // Data yang dibatasi berdasarkan user yang login
            // Hitung peminjaman hari ini dari harian + tahunan
            $peminjamanHarianHariIni = PeminjamanHarianDetail::whereHas('peminjaman', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereDate('created_at', today())->count();
            
            $peminjamanTahunanHariIni = PeminjamanTahunanDetail::whereHas('peminjaman', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereDate('created_at', today())->count();
            
            $data = [
                'totalSiswa' => Siswa::count(), // Global untuk semua user
                'totalBuku' => Buku::count(), // Global untuk semua user
                'peminjamanHariIni' => $peminjamanHarianHariIni + $peminjamanTahunanHariIni, // Gabungan harian + tahunan
                'dendaAktif' => CatatanDenda::where('status', 'belum_dibayar')->count() // Global untuk semua user
            ];
            
            // Chart data per user
            $peminjamanHarianData = [];
            $peminjamanTahunanData = [];
            
            for ($month = 1; $month <= 12; $month++) {
                $peminjamanHarianData[] = PeminjamanHarianDetail::whereHas('peminjaman', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->whereMonth('created_at', $month)
                  ->whereYear('created_at', now()->year)
                  ->count();
                  
                $peminjamanTahunanData[] = PeminjamanTahunanDetail::whereHas('peminjaman', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })->whereMonth('created_at', $month)
                  ->whereYear('created_at', now()->year)
                  ->count();
            }
            
            // Stats kelas dari semua siswa (global)
            $kelasStats = Siswa::selectRaw('kelas, COUNT(*) as total')
                ->groupBy('kelas')
                ->pluck('total', 'kelas')
                ->toArray();
                
            // Jika kosong, berikan data default
            if (empty($kelasStats)) {
                $kelasStats = [];
            }
                
            // Recent activities dari user ini (gabung harian dan tahunan dengan union query)
            // Ambil data dari kedua tabel dan gabungkan berdasarkan timestamp
            $recentPeminjamanHarian = PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(10) // Ambil 10 untuk memastikan cukup data
                ->get()
                ->map(function($item) {
                    $item->tipe_peminjaman = 'harian';
                    return $item;
                });
                
            $recentPeminjamanTahunan = PeminjamanTahunan::with(['siswa', 'details.kodeBuku.buku'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(10) // Ambil 10 untuk memastikan cukup data
                ->get()
                ->map(function($item) {
                    $item->tipe_peminjaman = 'tahunan';
                    return $item;
                });
                
            // Gabungkan dan urutkan berdasarkan created_at terbaru
            $recentPeminjaman = $recentPeminjamanHarian->merge($recentPeminjamanTahunan)
                ->sortByDesc('created_at')
                ->take(3) // Ambil 3 teratas
                ->values(); // Reset index
                
            $newSiswa = Siswa::latest()
                ->take(2)
                ->get();
                
            // Top borrowers dari user ini (gabung harian dan tahunan)
            $topBorrowersHarian = PeminjamanHarian::with('siswa')
                ->where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get()
                ->groupBy('siswas_id')
                ->map(function($group, $siswaId) {
                    return (object)[
                        'siswa' => $group->first()->siswa,
                        'siswas_id' => $siswaId,
                        'total_peminjaman' => $group->count()
                    ];
                });
                
            $topBorrowersTahunan = PeminjamanTahunan::with('siswa')
                ->where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->get()
                ->groupBy('siswas_id')
                ->map(function($group, $siswaId) {
                    return (object)[
                        'siswa' => $group->first()->siswa,
                        'siswas_id' => $siswaId,
                        'total_peminjaman' => $group->count()
                    ];
                });
                
            // Gabungkan dan hitung total per siswa
            $allBorrowers = collect();
            
            // Kumpulkan semua siswa yang meminjam
            foreach($topBorrowersHarian as $borrower) {
                $allBorrowers->put($borrower->siswas_id, $borrower);
            }
            
            foreach($topBorrowersTahunan as $borrower) {
                if($allBorrowers->has($borrower->siswas_id)) {
                    // Jika siswa sudah ada, tambahkan total peminjaman
                    $existing = $allBorrowers->get($borrower->siswas_id);
                    $existing->total_peminjaman += $borrower->total_peminjaman;
                } else {
                    // Jika siswa belum ada, tambahkan baru
                    $allBorrowers->put($borrower->siswas_id, $borrower);
                }
            }
                
            $topBorrowers = $allBorrowers->sortByDesc('total_peminjaman')->values()->take(5);

            // Popular books dari user ini (gabung harian dan tahunan)
            $popularBooksHarianData = PeminjamanHarianDetail::with('kodeBuku.buku')
                ->whereHas('peminjaman', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();

            $popularBooksTahunanData = PeminjamanTahunanDetail::with('kodeBuku.buku')
                ->whereHas('peminjaman', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->get();

            // Gabungkan data terlebih dahulu, baru groupBy
            $allPopularBooksData = $popularBooksHarianData->merge($popularBooksTahunanData);

            $popularBooks = $allPopularBooksData
                ->groupBy('kode_bukus_id')
                ->map(function($group) {
                    return (object)[
                        'kodeBuku' => $group->first()->kodeBuku,
                        'kode_bukus_id' => $group->first()->kode_bukus_id,
                        'total_peminjaman' => $group->count()
                    ];
                })
                ->sortByDesc('total_peminjaman')
                ->take(5);
                
            // Overdue books dari user ini (gabung harian dan tahunan)
            $overdueBooksHarian = PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku'])
                ->where('user_id', $user->id)
                ->whereDate('tanggal_kembali', '<', now())
                ->where('status', 'dipinjam')
                ->limit(3)
                ->get();
                
            $overdueBooksTaghunan = PeminjamanTahunan::with(['siswa', 'details.kodeBuku.buku'])
                ->where('user_id', $user->id)
                ->whereDate('tanggal_kembali', '<', now())
                ->where('status', 'dipinjam')
                ->limit(3)
                ->get();
                
            $overdueBooks = $overdueBooksHarian->merge($overdueBooksTaghunan)
                ->sortBy('tanggal_kembali')
                ->take(5);
            
        } catch (\Exception $e) {
            // Jika ada error, berikan data default
            Log::error('Dashboard error: ' . $e->getMessage());
            
            $data = [
                'totalSiswa' => 0,
                'totalBuku' => 0,
                'peminjamanHariIni' => 0,
                'dendaAktif' => 0
            ];
            
            $peminjamanHarianData = array_fill(0, 12, 0);
            $peminjamanTahunanData = array_fill(0, 12, 0);
            $kelasStats = [];
            $recentPeminjaman = collect();
            $newSiswa = collect();
            $topBorrowers = collect();
            $popularBooks = collect();
            $overdueBooks = collect();
        }
        
        return view('dashboard', compact(
            'data',
            'peminjamanHarianData',
            'peminjamanTahunanData', 
            'kelasStats',
            'recentPeminjaman',
            'newSiswa',
            'topBorrowers',
            'popularBooks',
            'overdueBooks'
        ));
    }
}
