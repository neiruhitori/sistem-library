<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Data Siswa Kelas <?php echo e($namaKelas); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
            padding: 0;
            font-size: 10px;
        }
        
        /* Header Kop Surat */
        .kop {
            text-align: center;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }
        
        .kop table {
            width: 100%;
            border: none;
        }
        
        .kop td {
            border: none;
            vertical-align: middle;
        }
        
        .kop img {
            height: 65px;
        }
        
        .kop-text {
            text-align: center;
        }
        
        .kop-text strong {
            display: block;
            line-height: 1.3;
        }
        
        /* Info Box */
        .info-section {
            margin-bottom: 10px;
        }
        
        .info-section p {
            margin: 2px 0;
            font-size: 9px;
        }
        
        /* Table */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        
        table.data-table th {
            background-color: #f0f0f0;
            border: 1px solid #000;
            padding: 4px 3px;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }
        
        table.data-table td {
            border: 1px solid #000;
            padding: 3px;
            font-size: 9px;
        }
        
        table.data-table tr:nth-child(even) {
            background-color: #fafafa;
        }
        
        table.data-table tr {
            page-break-inside: avoid;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Badge Simple */
        .badge {
            display: inline-block;
            padding: 1px 3px;
            font-size: 7px;
            border-radius: 2px;
            background: #e0e0e0;
        }
        
        .badge-success {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-danger {
            background: #f8d7da;
            color: #721c24;
        }
        
        /* Signature */
        .signature-section {
            margin-top: 25px;
            width: 100%;
            page-break-inside: avoid;
        }
        
        .signature-section table {
            width: 100%;
            border: none;
        }
        
        .signature-section td {
            border: none;
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }
        
        .signature-box {
            text-align: center;
            font-size: 9px;
        }
        
        .signature-line {
            margin-top: 40px;
            padding-top: 3px;
            font-weight: bold;
            font-size: 9px;
        }
        
        /* Footer */
        .footer {
            margin-top: 10px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
    </style>
</head>
<body>
    <!-- Header Kop Surat -->
    <div class="kop">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td width="70">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" alt="Logo SMP">
                </td>
                <td class="kop-text">
                    <strong style="font-size: 13px;">PEMERINTAH KABUPATEN LUMAJANG</strong>
                    <strong style="font-size: 13px;">DINAS PENDIDIKAN</strong>
                    <strong style="font-size: 16px;">SMP NEGERI 02 KLAKAH</strong>
                    <span style="font-size: 10px;">Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356</span>
                </td>
                <td width="70">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/lumajang.png')); ?>" alt="Logo Lumajang">
                </td>
            </tr>
        </table>
    </div>

    <!-- Judul -->
    <h3 style="text-align: center; margin: 10px 0 8px 0; font-size: 12px;">
        DAFTAR SISWA KELAS <?php echo e(strtoupper($namaKelas)); ?><br>
        TAHUN PELAJARAN <?php echo e(now()->year); ?>/<?php echo e(now()->year + 1); ?>

    </h3>
    
    <!-- Info -->
    <div class="info-section">
        <p><strong>Kelas:</strong> <?php echo e($namaKelas); ?></p>
        <p><strong>Jumlah Siswa:</strong> <?php echo e($totalSiswa); ?> orang</p>
        <p><strong>Tanggal Cetak:</strong> <?php echo e($tanggalCetak); ?></p>
    </div>
    
    <!-- Tabel Data Siswa -->
    <?php if($siswa->count() > 0): ?>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NISN</th>
                <th width="30%">Nama Siswa</th>
                <th width="15%">Pinjam Harian</th>
                <th width="15%">Pinjam Tahunan</th>
                <th width="15%">Status Denda</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // Hitung data peminjaman dan denda
                $peminjamanHarian = $s->peminjamanHarian()->count();
                $peminjamanTahunan = $s->peminjamanTahunan()->count();
                $dendaBelumLunas = $s->catatanDenda()->where('status', 'belum_dibayar')->count();
                $dendaLunas = $s->catatanDenda()->where('status', 'dibayar')->count();
                $totalDenda = $dendaBelumLunas + $dendaLunas;
            ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($s->nisn ?? '-'); ?></td>
                <td><?php echo e($s->name); ?></td>
                <td class="text-center"><?php echo e($peminjamanHarian); ?> buku</td>
                <td class="text-center"><?php echo e($peminjamanTahunan); ?> buku</td>
                <td class="text-center">
                    <?php if($totalDenda == 0): ?>
                        <span class="badge badge-success">Tidak Ada</span>
                    <?php elseif($dendaBelumLunas > 0): ?>
                        <span class="badge badge-danger"><?php echo e($dendaBelumLunas); ?> Belum Lunas</span>
                    <?php else: ?>
                        <span class="badge badge-success">Lunas</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <p style="text-align: center; padding: 30px; color: #666;">
        Belum ada siswa yang terdaftar di kelas <?php echo e($namaKelas); ?>

    </p>
    <?php endif; ?>
    
    <!-- Tanda Tangan -->
    <div class="signature-section">
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <div class="signature-box">
                        <p style="margin: 0;">Klakah, <?php echo e($tanggalCetak); ?></p>
                        <p style="margin: 5px 0 0 0;">Kepala Perpustakaan</p>
                        <div class="signature-line">
                            <u><?php echo e($kepalaPerpustakaan->nama); ?></u><br>
                            NIP. <?php echo e($kepalaPerpustakaan->nip); ?>

                        </div>
                    </div>
                </td>
                <td>
                    <div class="signature-box">
                        <p style="margin: 0;">Klakah, <?php echo e($tanggalCetak); ?></p>
                        <p style="margin: 5px 0 0 0;">Kepala Sekolah</p>
                        <div class="signature-line">
                            <u><?php echo e($kepalaSekolah->nama); ?></u><br>
                            NIP. <?php echo e($kepalaSekolah->nip); ?>

                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p>Dicetak pada: <?php echo e(now()->format('d F Y H:i')); ?> | Sistem Perpustakaan SMPN 02 Klakah</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/kelas/pdf.blade.php ENDPATH**/ ?>