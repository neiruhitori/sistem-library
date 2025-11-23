<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Siswa - <?php echo e($siswa->nama); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
      <!-- Statistik Peminjaman -->
    <div class="stats-box">
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Peminjaman Harian</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Peminjaman Tahunan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); }) + $peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($catatanDenda->count()); ?></div>
            <div class="stat-label">Aktivitas Denda</div>
        </div>
    </div>ng: 20px;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        
        .profile-section {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #007bff;
        }
        
        .profile-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
            border-bottom: 1px dotted #ddd;
        }
        
        .profile-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        
        .profile-label {
            font-weight: bold;
            color: #333;
            width: 30%;
        }
        
        .profile-value {
            color: #666;
            width: 70%;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #000;
        }
        
        .badge-success {
            background: #28a745;
        }
        
        .badge-danger {
            background: #dc3545;
        }
        
        .badge-secondary {
            background: #6c757d;
        }
        
        .badge-male {
            background: #17a2b8;
        }
        
        .badge-female {
            background: #ffc107;
            color: #000;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }
        
        .stats-box {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            text-align: center;
        }
        
        .stat-item {
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            min-width: 100px;
            flex: 1;
            margin: 0 5px;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SMPN 02 KLAKAH</h1>
        <h2>DETAIL SISWA</h2>
    </div>
    
    <div class="profile-section">
        <div class="profile-row">
            <span class="profile-label">Nama Lengkap:</span>
            <span class="profile-value"><?php echo e($siswa->name); ?></span>
        </div>
        <div class="profile-row">
            <span class="profile-label">NISN:</span>
            <span class="profile-value"><?php echo e($siswa->nisn ?? 'N/A'); ?></span>
        </div>
        <div class="profile-row">
            <span class="profile-label">Kelas:</span>
            <span class="profile-value"><?php echo e($siswa->kelas); ?></span>
        </div>
        <div class="profile-row">
            <span class="profile-label">Terdaftar:</span>
            <span class="profile-value"><?php echo e($siswa->created_at->format('d F Y')); ?></span>
        </div>
        <div class="profile-row">
            <span class="profile-label">Tanggal Cetak:</span>
            <span class="profile-value"><?php echo e($tanggalCetak); ?></span>
        </div>
    </div>
    
    <!-- Statistik Peminjaman -->
    <div class="stats-box">
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Peminjaman Harian</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Peminjaman Tahunan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); }) + $peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
        <div class="stat-item">
            <div class="stat-number"><?php echo e($catatanDenda->count()); ?></div>
            <div class="stat-label">Aktivitas Denda</div>
        </div>
    </div>
    
    <!-- Riwayat Peminjaman Harian -->
    <div class="section-title">RIWAYAT PEMINJAMAN HARIAN</div>
    <?php if($peminjamanHarian->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal Pinjam</th>
                <th style="width: 15%">Tanggal Kembali</th>
                <th style="width: 35%">Buku</th>
                <th style="width: 15%">Kode Buku</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php $__currentLoopData = $peminjamanHarian; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $harian): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $harian->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($no++); ?></td>
                    <td><?php echo e($harian->tanggal_pinjam); ?></td>
                    <td><?php echo e($harian->tanggal_kembali ?? 'Belum dikembalikan'); ?></td>
                    <td><?php echo e($detail->kodeBuku->buku->judul ?? 'N/A'); ?></td>
                    <td>
                        <span class="badge"><?php echo e($detail->kodeBuku->kode_buku ?? 'N/A'); ?></span>
                    </td>
                    <td>
                        <?php if($harian->status == 'dipinjam'): ?>
                            <span class="badge badge-warning">Dipinjam</span>
                        <?php elseif($harian->status == 'selesai'): ?>
                            <span class="badge badge-success">Selesai</span>
                        <?php else: ?>
                            <span class="badge badge-secondary"><?php echo e(ucfirst($harian->status)); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="no-data">
        Belum ada riwayat peminjaman harian
    </div>
    <?php endif; ?>
    
    <!-- Riwayat Peminjaman Tahunan -->
    <div class="section-title">RIWAYAT PEMINJAMAN TAHUNAN</div>
    <?php if($peminjamanTahunan->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal Pinjam</th>
                <th style="width: 15%">Tanggal Kembali</th>
                <th style="width: 35%">Buku</th>
                <th style="width: 15%">Kode Buku</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php $__currentLoopData = $peminjamanTahunan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tahunan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $tahunan->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="text-center"><?php echo e($no++); ?></td>
                    <td><?php echo e($tahunan->tanggal_pinjam); ?></td>
                    <td><?php echo e($tahunan->tanggal_kembali ?? 'Belum dikembalikan'); ?></td>
                    <td><?php echo e($detail->kodeBuku->buku->judul ?? 'N/A'); ?></td>
                    <td>
                        <span class="badge"><?php echo e($detail->kodeBuku->kode_buku ?? 'N/A'); ?></span>
                    </td>
                    <td>
                        <?php if($tahunan->status == 'dipinjam'): ?>
                            <span class="badge badge-warning">Dipinjam</span>
                        <?php elseif($tahunan->status == 'selesai'): ?>
                            <span class="badge badge-success">Selesai</span>
                        <?php else: ?>
                            <span class="badge badge-secondary"><?php echo e(ucfirst($tahunan->status)); ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="no-data">
        Belum ada riwayat peminjaman tahunan
    </div>
    <?php endif; ?>
    
    <!-- Aktivitas Denda -->
    <h3>Aktivitas Denda</h3>
    <?php if($catatanDenda->count() > 0): ?>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $catatanDenda; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $denda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($denda->created_at->format('d/m/Y')); ?></td>
                <td><?php echo e($denda->keterangan ?? 'Denda keterlambatan'); ?></td>
                <td>Rp <?php echo e(number_format($denda->jumlah ?? 0, 0, ',', '.')); ?></td>
                <td>
                    <?php if($denda->status == 'dibayar'): ?>
                        <span class="badge badge-success">Lunas</span>
                    <?php else: ?>
                        <span class="badge badge-warning">Belum Lunas</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="no-data">
        Tidak ada aktivitas denda
    </div>
    <?php endif; ?>
    
    <div class="signature">
        <div class="signature-box">
            <p>Klakah, <?php echo e($tanggalCetak); ?></p>
            <p>Pustakawan</p>
            <div class="signature-line">
                <u><?php echo e(auth()->user()->name); ?></u></strong><br>NIP. <?php echo e(auth()->user()->nip); ?>

            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>Dicetak pada: <?php echo e(now()->format('d F Y H:i:s')); ?> | Sistem Perpustakaan SMPN 02 Klakah</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/kelas/detail-pdf.blade.php ENDPATH**/ ?>