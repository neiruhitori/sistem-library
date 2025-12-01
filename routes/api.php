<?php

use App\Http\Controllers\Api\BukuApiController;
use App\Http\Controllers\Api\PeminjamanApiController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/midtrans/callback', [MidtransCallbackController::class, 'receive']);

// API Routes untuk Aplikasi Android
Route::prefix('buku')->group(function () {
    Route::get('/', [BukuApiController::class, 'index']); // GET /api/buku
    Route::get('/search', [BukuApiController::class, 'search']); // GET /api/buku/search?q=keyword
    Route::get('/{id}', [BukuApiController::class, 'show']); // GET /api/buku/{id}
    Route::get('/{id}/kode-buku', [PeminjamanApiController::class, 'getAvailableBookCodes']); // GET /api/buku/{id}/kode-buku

    // Routes untuk admin (opsional - bisa ditambahkan middleware auth nanti)
    Route::post('/', [BukuApiController::class, 'store']); // POST /api/buku
    Route::put('/{id}', [BukuApiController::class, 'update']); // PUT /api/buku/{id}
    Route::delete('/{id}', [BukuApiController::class, 'destroy']); // DELETE /api/buku/{id}
});

// API Routes untuk Peminjaman
Route::prefix('peminjaman')->group(function () {
    Route::post('/store', [PeminjamanApiController::class, 'storePeminjaman']); // POST /api/peminjaman/store
});

// API Routes untuk Siswa
Route::prefix('siswa')->group(function () {
    Route::get('/{id}', [PeminjamanApiController::class, 'getSiswaById']); // GET /api/siswa/{id}
    Route::get('/search/query', [PeminjamanApiController::class, 'searchSiswa']); // GET /api/siswa/search/query?q=keyword
});
