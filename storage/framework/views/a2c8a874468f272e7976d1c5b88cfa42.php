<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Siswa Kelas <?php echo e($namaKelas); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
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
        
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
        }
        
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .info-row:last-child {
            margin-bottom: 0;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
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
        
        .badge-male {
            background: #17a2b8;
        }
        
        .badge-female {
            background: #ffc107;
            color: #000;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 60px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SMPN 02 KLAKAH</h1>
        <h2>DATA SISWA KELAS <?php echo e(strtoupper($namaKelas)); ?></h2>
    </div>
    
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Kelas:</span>
            <span class="info-value"><?php echo e($namaKelas); ?></span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Siswa:</span>
            <span class="info-value"><?php echo e($totalSiswa); ?> orang</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value"><?php echo e($tanggalCetak); ?></span>
        </div>
    </div>
    
    <?php if($siswa->count() > 0): ?>
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">NISN</th>
                <th style="width: 50%">Nama Siswa</th>
                <th style="width: 20%">Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $siswa; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td>
                    <span class=""><?php echo e($s->nisn ?? 'N/A'); ?></span>
                </td>
                <td><?php echo e($s->name); ?></td>
                <td><?php echo e($s->kelas); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?>
    <div style="text-align: center; padding: 50px; color: #666;">
        <p>Belum ada siswa yang terdaftar di kelas <?php echo e($namaKelas); ?></p>
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
<?php /**PATH C:\laragon\www\sistem-library\resources\views/kelas/pdf.blade.php ENDPATH**/ ?>