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
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KelasController;

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
    Route::get('/siswa/{id}/print-card', [SiswaController::class, 'printCard'])->name('siswa.print.card');
    Route::resource('siswa', SiswaController::class);

    // Buku
    Route::get('/bukuharian', [BukuController::class, 'indexHarian'])->name('buku.harian');
    Route::get('/bukutahunan', [BukuController::class, 'indexTahunan'])->name('buku.tahunan');
    Route::delete('/buku/hapussemua', [BukuController::class, 'hapussemua'])->name('buku.hapussemua');
    Route::resource('buku', BukuController::class)->except(['index']);

    // Peminjaman Harian
    Route::delete('/peminjamanharian/hapussemua', [PeminjamanHarianController::class, 'hapussemua'])->name('peminjamanharian.hapussemua');
    Route::resource('peminjamanharian', PeminjamanHarianController::class);

    // Pengembalian Harian
    Route::get('/pengembalianharian', [PengembalianHarianController::class, 'index'])->name('pengembalianharian.index');
    Route::post('/pengembalianharian/{detail}/update', [PengembalianHarianController::class, 'update'])->name('pengembalianharian.update');

    // Peminjaman Tahunan
    Route::delete('/peminjamantahunan/hapussemua', [PeminjamanTahunanController::class, 'hapussemua'])->name('peminjamantahunan.hapussemua');
    Route::resource('peminjamantahunan', PeminjamanTahunanController::class);

    // Pengembalian Tahunan
    Route::get('/pengembaliantahunan', [PengembalianTahunanController::class, 'index'])->name('pengembaliantahunan.index');
    Route::post('/pengembaliantahunan/{detail}/update', [PengembalianTahunanController::class, 'update'])->name('pengembaliantahunan.update');

    // Catatan Denda Harian
    Route::get('/catatanharian', [CatatanHarianController::class, 'index'])->name('catatanharian.index');
    Route::get('/catatanharian/{id}', [CatatanHarianController::class, 'show'])->name('catatanharian.show');
    Route::get('/catatanharian/{id}/pay', [CatatanHarianController::class, 'pay'])->name('catatanharian.pay');
    Route::post('/catatanharian/{id}/process-payment', [CatatanHarianController::class, 'processPayment'])->name('catatanharian.processPayment');
    Route::post('/catatanharian/{id}/midtrans-success', [CatatanHarianController::class, 'midtransSuccess'])->name('catatanharian.midtrans.success');
    Route::get('/catatanharian/{id}/export', [CatatanHarianController::class, 'export'])->name('catatanharian.export');

    // Catatan Denda Tahunan
    Route::get('/catatantahunan', [CatatanTahunanController::class, 'index'])->name('catatantahunan.index');
    Route::get('/catatantahunan/{id}', [CatatanTahunanController::class, 'show'])->name('catatantahunan.show');
    Route::get('/catatantahunan/{id}/pay', [CatatanTahunanController::class, 'pay'])->name('catatantahunan.pay');
    Route::post('/catatantahunan/{id}/process-payment', [CatatanTahunanController::class, 'processPayment'])->name('catatantahunan.processPayment');
    Route::post('/catatantahunan/{id}/midtrans-success', [CatatanTahunanController::class, 'midtransSuccess'])->name('catatantahunan.midtrans.success');
    Route::get('/catatantahunan/{id}/export', [CatatanTahunanController::class, 'export'])->name('catatantahunan.export');

    // Kelas Routes
    Route::get('/kelas/{kelas}/cetak-pdf', [KelasController::class, 'cetakPDF'])->name('kelas.cetak-pdf');
    Route::get('/kelas/{kelas}/{id}/cetak-detail-pdf', [KelasController::class, 'cetakDetailPDF'])->name('kelas.cetak-detail-pdf');
    Route::get('/kelas/{kelas}/{id}', [KelasController::class, 'show'])->name('kelas.show');
    Route::get('/kelas/{kelas}', [KelasController::class, 'index'])->name('kelas.index');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.get');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsReadAndRedirect'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
    Route::post('/notifications/clear-all', [NotificationController::class, 'clearAll'])->name('notifications.clearAll');
    Route::delete('/notifications/{id}', [NotificationController::class, 'delete'])->name('notifications.delete');
});

require __DIR__ . '/auth.php';
