<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Guru SMPN 02 Klakah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 02 KLAKAH</h2>
        <h3>DAFTAR GURU</h3>
        <p>Dicetak pada: <?php echo e(date('d/m/Y H:i')); ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NIP</th>
                <th width="30%">Nama</th>
                <th width="25%">Tambahan Tugas</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($guru->nip ?? '-'); ?></td>
                    <td><?php echo e($guru->nama); ?></td>
                    <td><?php echo e($guru->tambahantugas ?? '-'); ?></td>
                    <td><?php echo e($guru->keterangan ?? '-'); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Total Guru: <?php echo e($gurus->count()); ?></strong></p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/guru/pdf.blade.php ENDPATH**/ ?>