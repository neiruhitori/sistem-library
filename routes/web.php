<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanHarianController;
use App\Http\Controllers\PengembalianHarianController;
use App\Http\Controllers\PeminjamanTahunanController;
use App\Http\Controllers\PengembalianTahunanController;
use App\Http\Controllers\CatatanHarianController;
use App\Http\Controllers\CatatanTahunanController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile (Breeze default)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Siswa
    // routes/web.php
    Route::get('/siswa/export-pdf', [SiswaController::class, 'exportPDF'])->name('siswa.export.pdf');
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import');
    Route::delete('/siswa/hapussemua', [SiswaController::class, 'hapussemua'])->name('siswa.hapussemua');
    Route::resource('siswa', SiswaController::class);

    // Buku
    Route::get('/bukuharian', [BukuController::class, 'indexHarian'])->name('buku.harian');
    Route::get('/bukutahunan', [BukuController::class, 'indexTahunan'])->name('buku.tahunan');
    Route::delete('/buku/hapussemua', [BukuController::class, 'hapussemua'])->name('buku.hapussemua');
    Route::resource('buku', BukuController::class)->except(['index']);

    // Peminjaman Harian
    Route::resource('peminjaman', PeminjamanHarianController::class);

    // Pengembalian Harian
    Route::get('/pengembalian', [PengembalianHarianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian/{detail}/update', [PengembalianHarianController::class, 'update'])->name('pengembalian.update');

    // Peminjaman Tahunan
    Route::resource('peminjamantahunan', PeminjamanTahunanController::class);

    // Pengembalian Tahunan
    Route::get('/pengembaliantahunan', [PengembalianTahunanController::class, 'index'])->name('pengembaliantahunan.index');
    Route::post('/pengembaliantahunan/{detail}/update', [PengembalianTahunanController::class, 'update'])->name('pengembaliantahunan.update');

    // Catatan Denda
    Route::get('/catatanharian', [CatatanHarianController::class, 'index'])->name('catatanharian.index');
    Route::get('/catatantahunan', [CatatanTahunanController::class, 'index'])->name('catatantahunan.index');

    // Laporan
    Route::get('/sedangmeminjam', [PeminjamanHarianController::class, 'laporanSedang'])->name('laporan.harian.sedang');
    Route::get('/selesaimeminjam', [PeminjamanHarianController::class, 'laporanSelesai'])->name('laporan.harian.selesai');
    Route::get('/sedangmeminjamtahunan', [PeminjamanTahunanController::class, 'laporanSedang'])->name('laporan.tahunan.sedang');
    Route::get('/selesaimeminjamtahunan', [PeminjamanTahunanController::class, 'laporanSelesai'])->name('laporan.tahunan.selesai');
});

require __DIR__ . '/auth.php';
