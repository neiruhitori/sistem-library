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
            $buku = Buku::orderBy('created_at', 'desc')->get();
            
            // Format URL foto untuk setiap buku
            $buku = $buku->map(function($item) {
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
                return $item;
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Data buku berhasil diambil',
                'data' => $buku
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data buku',
                'error' => $e->getMessage()
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
            $buku = Buku::find($id);
            
            if (!$buku) {
                return response()->json([
                    'success' => false,
                    'message' => 'Buku tidak ditemukan',
                    'data' => null
                ], 404);
            }
            
            // Format URL foto
            if ($buku->foto) {
                if (filter_var($buku->foto, FILTER_VALIDATE_URL)) {
                    $buku->foto_url = $buku->foto;
                } else {
                    $buku->foto_url = asset('storage/' . $buku->foto);
                }
            } else {
                $buku->foto_url = null;
            }
            
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
            
            $buku = Buku::where('judul', 'like', "%{$keyword}%")
                ->orWhere('penulis', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Format URL foto
            $buku = $buku->map(function($item) {
                if ($item->foto) {
                    if (filter_var($item->foto, FILTER_VALIDATE_URL)) {
                        $item->foto_url = $item->foto;
                    } else {
                        $item->foto_url = asset('storage/' . $item->foto);
                    }
                } else {
                    $item->foto_url = null;
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
