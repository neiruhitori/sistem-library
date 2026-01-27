<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Siswa - <?php echo e($siswa->nama); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            font-size: 12px;
        }
        
        @page {
            margin: 20px;
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
            margin-top: 20px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .signature {
            margin-top: 50px;
            page-break-inside: avoid;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            margin-top: 60px;
            padding-top: 5px;
        }
        
        .page-break-before {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="kop">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none; border-collapse: collapse;">
            <tr>
                <td width="80" style="border: none; vertical-align: middle;">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" alt="smp"
                        style="height: 80px;">
                </td>
                <td style="border: none; vertical-align: middle; text-align: center;">
                    <div style="line-height: 1.5;">
                        <strong style="font-size: 14px;">PEMERINTAH KABUPATEN LUMAJANG</strong><br>
                        <strong style="font-size: 14px;">DINAS PENDIDIKAN</strong><br>
                        <strong style="font-size: 18px;">SMP NEGERI 02 KLAKAH</strong><br>
                        <span style="font-size: 12px;">Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356</span>
                    </div>
                </td>
                <td width="80" style="border: none; vertical-align: middle;">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/lumajang.png')); ?>" alt="kabupaten"
                        style="height: 80px;">
                </td>
            </tr>
        </table>
        <hr style="border: 1px solid #000; margin-top: 5px;">
    </div>

    <h3 style="text-align: center; margin-top: 10px;">Detail Siswa</h3>
    
    <!-- Data Siswa -->
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
        <p style="margin: 3px 0;"><strong>Nama Lengkap</strong> : <?php echo e($siswa->name); ?></p>
        <p style="margin: 3px 0;"><strong>NISN</strong> : <?php echo e($siswa->nisn ?? 'N/A'); ?></p>
        <p style="margin: 3px 0;"><strong>Kelas</strong> : <?php echo e($siswa->kelas); ?></p>
        <p style="margin: 3px 0;"><strong>Absen</strong> : <?php echo e($siswa->absen ?? '-'); ?></p>
        <p style="margin: 3px 0;"><strong>Jenis Kelamin</strong> : <?php echo e($siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-')); ?></p>
        <p style="margin: 3px 0;"><strong>Agama</strong> : <?php echo e($siswa->agama ?? '-'); ?></p>
        <p style="margin: 3px 0;"><strong>Terdaftar</strong> : <?php echo e($siswa->created_at->format('d F Y')); ?></p>
        <p style="margin: 3px 0;"><strong>Tanggal Cetak</strong> : <?php echo e($tanggalCetak); ?></p>
    </div>
    
    <!-- Statistik Peminjaman -->
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
        <p style="margin: 3px 0;"><strong>Peminjaman Harian</strong> : <?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); })); ?></p>
        <p style="margin: 3px 0;"><strong>Peminjaman Tahunan</strong> : <?php echo e($peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></p>
        <p style="margin: 3px 0;"><strong>Total Peminjaman</strong> : <?php echo e($peminjamanHarian->sum(function($p) { return $p->details->count(); }) + $peminjamanTahunan->sum(function($p) { return $p->details->count(); })); ?></p>
        <p style="margin: 3px 0;"><strong>Aktivitas Denda</strong> : <?php echo e($catatanDenda->count()); ?></p>
    </div>
    
    <!-- Riwayat Peminjaman Harian -->
    <div class="section-title">RIWAYAT PEMINJAMAN HARIAN</div>
    <?php if($peminjamanHarian->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 12%">Tanggal Pinjam</th>
                <th style="width: 12%">Tanggal Kembali</th>
                <th style="width: 28%">Buku</th>
                <th style="width: 13%">Kode Buku</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Tanda Tangan</th>
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
                    <td style="height: 40px;"></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="text-align: right; margin-top: 10px; margin-bottom: 20px;">
        <div style="display: inline-block; text-align: center; min-width: 200px;">
            <p style="margin: 0;">Klakah, <?php echo e($tanggalCetak); ?></p>
            <p style="margin: 5px 0;">Kepala Perpustakaan</p>
            <div style="margin-top: 60px;">
                <strong><u><?php echo e($kepalaPerpustakaan->nama); ?></u></strong><br>
                NIP. <?php echo e($kepalaPerpustakaan->nip); ?>

            </div>
        </div>
    </div>
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
                <th style="width: 12%">Tanggal Pinjam</th>
                <th style="width: 12%">Tanggal Kembali</th>
                <th style="width: 28%">Buku</th>
                <th style="width: 13%">Kode Buku</th>
                <th style="width: 10%">Status</th>
                <th style="width: 20%">Tanda Tangan</th>
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
                    <td style="height: 40px;"></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <div style="text-align: right; margin-top: 10px; margin-bottom: 20px;">
        <div style="display: inline-block; text-align: center; min-width: 200px;">
            <p style="margin: 0;">Klakah, <?php echo e($tanggalCetak); ?></p>
            <p style="margin: 5px 0;">Kepala Perpustakaan</p>
            <div style="margin-top: 60px;">
                <strong><u><?php echo e($kepalaPerpustakaan->nama); ?></u></strong><br>
                NIP. <?php echo e($kepalaPerpustakaan->nip); ?>

            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="no-data">
        Belum ada riwayat peminjaman tahunan
    </div>
    <?php endif; ?>
    
    <!-- Aktivitas Denda -->
    <div class="section-title">AKTIVITAS DENDA</div>
    <?php if($catatanDenda->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal</th>
                <th style="width: 30%">Keterangan</th>
                <th style="width: 15%">Jumlah Denda</th>
                <th style="width: 15%">Status</th>
                <th style="width: 20%">Tanda Tangan</th>
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
                <td style="height: 40px;"></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    
    <?php else: ?>
    <div class="no-data">
        Tidak ada aktivitas denda
    </div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/kelas/detail-pdf.blade.php ENDPATH**/ ?>