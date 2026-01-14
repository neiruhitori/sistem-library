<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KodeBuku;
use App\Models\PeminjamanHarian;
use App\Models\PeminjamanHarianDetail;
use App\Models\PeminjamanTahunan;
use App\Models\PeminjamanTahunanDetail;
use App\Models\Siswa;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PeminjamanApiController extends Controller
{
    /**
     * Get siswa by ID (dari QR code scan)
     */
    public function getSiswaById($id)
    {
        try {
            $siswa = Siswa::find($id);
            
            if (!$siswa) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa tidak ditemukan'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Siswa ditemukan',
                'data' => [
                    'id' => $siswa->id,
                    'name' => $siswa->name,
                    'nisn' => $siswa->nisn,
                    'kelas' => $siswa->kelas,
                    'absen' => $siswa->absen,
                    'jenis_kelamin' => $siswa->jenis_kelamin,
                    'agama' => $siswa->agama
                ]
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Search siswa by name or NISN
     */
    public function searchSiswa(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            if (empty($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata kunci pencarian tidak boleh kosong'
                ], 400);
            }
            
            $siswas = Siswa::where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('nisn', 'LIKE', '%' . $query . '%')
                ->orderBy('name', 'asc')
                ->limit(20)
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Pencarian berhasil',
                'data' => $siswas->map(function ($siswa) {
                    return [
                        'id' => $siswa->id,
                        'name' => $siswa->name,
                        'nisn' => $siswa->nisn,
                        'kelas' => $siswa->kelas,
                        'absen' => $siswa->absen,
                        'jenis_kelamin' => $siswa->jenis_kelamin,
                        'agama' => $siswa->agama
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Get available book codes by book ID
     */
    public function getAvailableBookCodes($bukuId)
    {
        try {
            $kodeBukus = KodeBuku::where('bukus_id', $bukuId)
                ->where('status', '!=', 'dipinjam')
                ->with('buku:id,judul,tipe')
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Data kode buku berhasil diambil',
                'data' => $kodeBukus->map(function ($kode) {
                    return [
                        'id' => $kode->id,
                        'kode_buku' => $kode->kode_buku,
                        'status' => $kode->status,
                        'buku_judul' => $kode->buku->judul ?? '-',
                        'buku_tipe' => $kode->buku->tipe ?? '-'
                    ];
                })
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Create new peminjaman (checkout)
     * Memisahkan peminjaman harian dan tahunan berdasarkan tipe buku
     */
    public function storePeminjaman(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswas_id' => 'required|exists:siswas,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'kode_buku_ids' => 'required|array|min:1',
            'kode_buku_ids.*' => 'exists:kode_bukus,id'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }
        
        DB::beginTransaction();
        
        try {
            // Grouping kode buku berdasarkan tipe (harian/tahunan)
            $kodeBukuHarian = [];
            $kodeBukuTahunan = [];
            
            // Verifikasi dan kelompokkan berdasarkan tipe
            foreach ($request->kode_buku_ids as $kode_id) {
                $kode = KodeBuku::with('buku')->find($kode_id);
                
                if (!$kode) {
                    throw new \Exception("Kode buku dengan ID {$kode_id} tidak ditemukan.");
                }
                
                if ($kode->status === 'dipinjam') {
                    throw new \Exception("Kode buku {$kode->kode_buku} sudah dipinjam.");
                }
                
                // Kelompokkan berdasarkan tipe buku
                if ($kode->buku && $kode->buku->tipe === 'harian') {
                    $kodeBukuHarian[] = $kode;
                } elseif ($kode->buku && $kode->buku->tipe === 'tahunan') {
                    $kodeBukuTahunan[] = $kode;
                } else {
                    throw new \Exception("Tipe buku untuk kode {$kode->kode_buku} tidak valid.");
                }
            }
            
            $responseData = [];
            
            // Process Peminjaman Harian jika ada
            if (count($kodeBukuHarian) > 0) {
                $peminjamanHarian = PeminjamanHarian::create([
                    'user_id' => null, // Null agar terlihat oleh semua admin di website
                    'siswas_id' => $request->siswas_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'dipinjam'
                ]);
                
                foreach ($kodeBukuHarian as $kode) {
                    // Simpan detail peminjaman harian
                    PeminjamanHarianDetail::create([
                        'peminjaman_harians_id' => $peminjamanHarian->id,
                        'kode_bukus_id' => $kode->id,
                        'status' => 'dipinjam',
                    ]);
                    
                    // Update status kode buku
                    $kode->update(['status' => 'dipinjam']);
                }
                
                // Buat notifikasi untuk peminjaman harian
                try {
                    NotificationService::createPeminjamanHarianNotification($peminjamanHarian->id);
                } catch (\Exception $e) {
                    Log::error('Gagal membuat notifikasi peminjaman harian: ' . $e->getMessage());
                }
                
                $peminjamanHarian->load(['siswa', 'details.kodeBuku.buku']);
                $responseData['peminjaman_harian'] = [
                    'id' => $peminjamanHarian->id,
                    'tipe' => 'harian',
                    'jumlah_buku' => count($kodeBukuHarian),
                    'buku_details' => $peminjamanHarian->details->map(function ($detail) {
                        return [
                            'kode_buku' => $detail->kodeBuku->kode_buku,
                            'judul' => $detail->kodeBuku->buku->judul ?? '-',
                            'tipe' => $detail->kodeBuku->buku->tipe ?? '-'
                        ];
                    })
                ];
            }
            
            // Process Peminjaman Tahunan jika ada
            if (count($kodeBukuTahunan) > 0) {
                $peminjamanTahunan = PeminjamanTahunan::create([
                    'user_id' => null, // Null agar terlihat oleh semua admin di website
                    'siswas_id' => $request->siswas_id,
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'status' => 'dipinjam'
                ]);
                
                foreach ($kodeBukuTahunan as $kode) {
                    // Simpan detail peminjaman tahunan
                    PeminjamanTahunanDetail::create([
                        'peminjaman_tahunans_id' => $peminjamanTahunan->id,
                        'kode_bukus_id' => $kode->id,
                        'status' => 'dipinjam',
                    ]);
                    
                    // Update status kode buku
                    $kode->update(['status' => 'dipinjam']);
                }
                
                // Buat notifikasi untuk peminjaman tahunan
                try {
                    NotificationService::createPeminjamanTahunanNotification($peminjamanTahunan->id);
                } catch (\Exception $e) {
                    Log::error('Gagal membuat notifikasi peminjaman tahunan: ' . $e->getMessage());
                }
                
                $peminjamanTahunan->load(['siswa', 'details.kodeBuku.buku']);
                $responseData['peminjaman_tahunan'] = [
                    'id' => $peminjamanTahunan->id,
                    'tipe' => 'tahunan',
                    'jumlah_buku' => count($kodeBukuTahunan),
                    'buku_details' => $peminjamanTahunan->details->map(function ($detail) {
                        return [
                            'kode_buku' => $detail->kodeBuku->kode_buku,
                            'judul' => $detail->kodeBuku->buku->judul ?? '-',
                            'tipe' => $detail->kodeBuku->buku->tipe ?? '-'
                        ];
                    })
                ];
            }
            
            DB::commit();
            
            // Get siswa info
            $siswa = Siswa::find($request->siswas_id);
            
            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil disimpan',
                'data' => [
                    'siswa' => [
                        'id' => $siswa->id,
                        'name' => $siswa->name,
                        'kelas' => $siswa->kelas
                    ],
                    'tanggal_pinjam' => $request->tanggal_pinjam,
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'peminjaman' => $responseData,
                    'total_buku' => count($request->kode_buku_ids),
                    'ringkasan' => [
                        'buku_harian' => count($kodeBukuHarian),
                        'buku_tahunan' => count($kodeBukuTahunan)
                    ]
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan peminjaman: ' . $e->getMessage()
            ], 500);
        }
    }
}
