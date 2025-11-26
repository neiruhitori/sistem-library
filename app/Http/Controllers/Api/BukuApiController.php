<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuApiController extends Controller
{
    /**
     * GET /api/buku
     * Mendapatkan semua buku
     */
    public function index()
    {
        try {
            $buku = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails'])
                ->orderBy('created_at', 'desc')
                ->get();

            // Format URL foto untuk setiap buku dan hitung stok
            $buku = $buku->map(function($item) {
                try {
                    if ($item->foto) {
                        // Jika foto sudah berupa URL lengkap, gunakan langsung
                        if (filter_var($item->foto, FILTER_VALIDATE_URL)) {
                            $item->foto_url = $item->foto;
                        } else {
                            // Jika foto berupa path, buat URL lengkap
                            $item->foto_url = asset('storage/' . $item->foto);
                        }
                    } else {
                        $item->foto_url = null;
                    }

                    // Hitung stok buku berdasarkan status di kode_bukus
                    $kodeBukuCollection = $item->kodeBuku ?? collect([]);
                    $item->stok = $kodeBukuCollection->count(); // Total semua kode buku

                    // Hitung berdasarkan status langsung dari kode_bukus
                    $tersedia = $kodeBukuCollection->where('status', 'tersedia')->count();
                    $dipinjam = $kodeBukuCollection->where('status', 'dipinjam')->count();

                    $item->stok_tersedia = $tersedia;
                    $item->sedang_dipinjam = $dipinjam;

                    // Hitung total peminjaman (untuk sorting buku paling banyak dipinjam)
                    try {
                        $totalHarian = $item->peminjamanHarianDetails ? $item->peminjamanHarianDetails->count() : 0;
                        $totalTahunan = $item->peminjamanTahunanDetails ? $item->peminjamanTahunanDetails->count() : 0;
                        $item->total_peminjaman = $totalHarian + $totalTahunan;
                    } catch (\Exception $e) {
                        $item->total_peminjaman = 0;
                    }

                    // Remove relations from response
                    unset($item->kodeBuku);
                    unset($item->peminjamanHarianDetails);
                    unset($item->peminjamanTahunanDetails);
                } catch (\Exception $e) {
                    // Set default values if error
                    $item->foto_url = null;
                    $item->stok = 0;
                    $item->stok_tersedia = 0;
                    $item->sedang_dipinjam = 0;
                    $item->total_peminjaman = 0;
                }

                return $item;
            });

            // Sort by total_peminjaman descending untuk memudahkan client
            $buku = $buku->sortByDesc('total_peminjaman')->values();
            
            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil diambil',
                'data' => $buku
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data buku',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * GET /api/buku/{id}
     * Mendapatkan detail buku berdasarkan ID
     */
    public function show($id)
    {
        try {
            $buku = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails'])->find($id);
            
            if (!$buku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan',
                    'data' => null
                ], 404);
            }

            // Format URL foto
            try {
                if ($buku->foto) {
                    if (filter_var($buku->foto, FILTER_VALIDATE_URL)) {
                        $buku->foto_url = $buku->foto;
                    } else {
                        $buku->foto_url = asset('storage/' . $buku->foto);
                    }
                } else {
                    $buku->foto_url = null;
                }
            } catch (\Exception $e) {
                $buku->foto_url = null;
            }

            // Hitung stok buku
            try {
                $kodeBukuCollection = $buku->kodeBuku ?? collect([]);
                $buku->stok = $kodeBukuCollection->count();

                // Hitung berdasarkan status langsung dari kode_bukus
                $tersedia = $kodeBukuCollection->where('status', 'tersedia')->count();
                $dipinjam = $kodeBukuCollection->where('status', 'dipinjam')->count();

                $buku->stok_tersedia = $tersedia;
                $buku->sedang_dipinjam = $dipinjam;
            } catch (\Exception $e) {
                $buku->stok = 0;
                $buku->stok_tersedia = 0;
                $buku->sedang_dipinjam = 0;
            }

            // Total peminjaman
            try {
                $totalHarian = $buku->peminjamanHarianDetails ? $buku->peminjamanHarianDetails->count() : 0;
                $totalTahunan = $buku->peminjamanTahunanDetails ? $buku->peminjamanTahunanDetails->count() : 0;
                $buku->total_peminjaman = $totalHarian + $totalTahunan;
            } catch (\Exception $e) {
                $buku->total_peminjaman = 0;
            }

            // Remove relations dari response
            unset($buku->kodeBuku);
            unset($buku->peminjamanHarianDetails);
            unset($buku->peminjamanTahunanDetails);

            return response()->json([
                'success' => true,
                'message' => 'Detail buku berhasil diambil',
                'data' => $buku
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * GET /api/buku/search?q=keyword
     * Mencari buku berdasarkan keyword
     */
    public function search(Request $request)
    {
        try {
            $keyword = $request->query('q');
            
            if (!$keyword) {
                return $this->index(); // Jika tidak ada keyword, return semua buku
            }

            $buku = Buku::with(['kodeBuku', 'peminjamanHarianDetails', 'peminjamanTahunanDetails'])
                ->where('judul', 'like', "%{$keyword}%")
                ->orWhere('penulis', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orderBy('created_at', 'desc')
                ->get();

            // Format URL foto dan hitung stok
            $buku = $buku->map(function($item) {
                try {
                    if ($item->foto) {
                        if (filter_var($item->foto, FILTER_VALIDATE_URL)) {
                            $item->foto_url = $item->foto;
                        } else {
                            $item->foto_url = asset('storage/' . $item->foto);
                        }
                    } else {
                        $item->foto_url = null;
                    }

                    $kodeBukuCollection = $item->kodeBuku ?? collect([]);
                    $item->stok = $kodeBukuCollection->count();

                    // Hitung berdasarkan status langsung dari kode_bukus
                    $tersedia = $kodeBukuCollection->where('status', 'tersedia')->count();
                    $dipinjam = $kodeBukuCollection->where('status', 'dipinjam')->count();

                    $item->stok_tersedia = $tersedia;
                    $item->sedang_dipinjam = $dipinjam;

                    $totalHarian = $item->peminjamanHarianDetails ? $item->peminjamanHarianDetails->count() : 0;
                    $totalTahunan = $item->peminjamanTahunanDetails ? $item->peminjamanTahunanDetails->count() : 0;
                    $item->total_peminjaman = $totalHarian + $totalTahunan;

                    unset($item->kodeBuku);
                    unset($item->peminjamanHarianDetails);
                    unset($item->peminjamanTahunanDetails);
                } catch (\Exception $e) {
                    $item->foto_url = null;
                    $item->stok = 0;
                    $item->stok_tersedia = 0;
                    $item->sedang_dipinjam = 0;
                    $item->total_peminjaman = 0;
                }

                return $item;
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Hasil pencarian buku',
                'data' => $buku
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal melakukan pencarian',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * POST /api/buku
     * Menambah buku baru (opsional untuk admin)
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'judul' => 'required|string|max:255',
                'penulis' => 'required|string|max:255',
                'tipe' => 'required|in:harian,tahunan',
                'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
                'description' => 'required|string',
                'foto' => 'nullable|string'
            ]);

            $buku = Buku::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan',
                'data' => $buku
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * PUT /api/buku/{id}
     * Update buku (opsional untuk admin)
     */
    public function update(Request $request, $id)
    {
        try {
            $buku = Buku::find($id);
            
            if (!$buku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $request->validate([
                'judul' => 'sometimes|string|max:255',
                'penulis' => 'sometimes|string|max:255',
                'tipe' => 'sometimes|in:harian,tahunan',
                'tahun_terbit' => 'sometimes|integer|min:1900|max:' . date('Y'),
                'description' => 'sometimes|string',
                'foto' => 'nullable|string'
            ]);

            $buku->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil diupdate',
                'data' => $buku
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * DELETE /api/buku/{id}
     * Hapus buku (opsional untuk admin)
     */
    public function destroy($id)
    {
        try {
            $buku = Buku::find($id);
            
            if (!$buku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan'
                ], 404);
            }

            $buku->delete();

            return response()->json([
                'success' => true,
                'message' => 'Buku berhasil dihapus'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus buku',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
