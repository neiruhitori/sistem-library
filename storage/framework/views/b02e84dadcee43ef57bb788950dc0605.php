<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Catatan Denda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop {
            text-align: center;
        }

        .kop img {
            height: 70px;
        }

        .kop .info {
            margin-top: -70px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }

        .badge-success {
            background-color: green;
        }

        .badge-danger {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="kop">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td width="80" style="border: none;">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" alt="smp"
                        style="height: 80px;">
                </td>
                <td style="border: none; text-align: center; vertical-align: middle;">
                    <strong style="font-size: 14px;">PEMERINTAH KABUPATEN LUMAJANG</strong><br>
                    <strong style="font-size: 14px;">DINAS PENDIDIKAN</strong><br>
                    <strong style="font-size: 18px;">SMP NEGERI 02 KLAKAH</strong><br>
                    <span style="font-size: 12px;">
                        Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356
                    </span>
                </td>
                <td width="80" style="border: none;">
                    <img src="<?php echo e(public_path('AdminLTE-3.2.0/dist/img/lumajang.png')); ?>" alt="kabupaten"
                        style="height: 80px;">
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <h3 style="text-align: center; margin-top: 10px;">Detail Catatan Denda</h3>

    <table>
        <tr>
            <th width="30%">Nama Siswa</th>
            <td><?php echo e($catatan->siswa->name); ?></td>
        </tr>
        <tr>
            <th>NISN</th>
            <td><?php echo e($catatan->siswa->nisn); ?></td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td><?php echo e($catatan->siswa->kelas); ?></td>
        </tr>
        <tr>
            <th>Absen</th>
            <td><?php echo e($catatan->siswa->absen ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td><?php echo e($catatan->siswa->jenis_kelamin ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Agama</th>
            <td><?php echo e($catatan->siswa->agama ?? '-'); ?></td>
        </tr>
        <tr>
            <th>Jenis Denda</th>
            <td><?php echo e(ucfirst($catatan->jenis_denda)); ?></td>
        </tr>
        <tr>
            <th>Jumlah Denda</th>
            <td><b>Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?></b></td>
        </tr>
        <tr>
            <th>Tanggal Denda</th>
            <td><?php echo e(\Carbon\Carbon::parse($catatan->tanggal_denda)->translatedFormat('d F Y')); ?></td>
        </tr>
        <?php if($catatan->status === 'dibayar'): ?>
            <tr>
                <th>Tanggal Bayar</th>
                <td><?php echo e(\Carbon\Carbon::parse($catatan->tanggal_bayar)->translatedFormat('d F Y')); ?></td>
            </tr>
        <?php endif; ?>
        <tr>
            <th>Status</th>
            <td>
                <b><?php echo e($catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar'); ?></b>
            </td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?php echo e($catatan->keterangan ?? '-'); ?></td>
        </tr>
    </table>
    <?php if($catatan->peminjaman && $catatan->peminjaman->details->count()): ?>
        <h4 style="margin-top: 30px;">Detail Buku Terkait</h4>
        <?php
            $detail = $catatan->peminjaman->details->where('id', $catatan->referensi_id)->first();
        ?>
        <?php if($detail): ?>
            <div style="margin-top: 10px; padding: 15px; border: 1px solid #ddd; background-color: #f9f9f9;">
                <p style="margin: 5px 0;"><strong>Judul</strong> : <?php echo e($detail->kodeBuku->buku->judul ?? '-'); ?></p>
                <p style="margin: 5px 0;"><strong>Kode Buku</strong> : <?php echo e($detail->kodeBuku->kode_buku ?? '-'); ?></p>
                <p style="margin: 5px 0;"><strong>Penulis</strong> : <?php echo e($detail->kodeBuku->buku->penulis ?? '-'); ?></p>
                <p style="margin: 5px 0;"><strong>Tahun</strong> : <?php echo e($detail->kodeBuku->buku->tahun_terbit ?? '-'); ?></p>
                <p style="margin: 5px 0;"><strong>ISBN</strong> : <?php echo e($detail->kodeBuku->buku->isbn ?? '-'); ?></p>
                <p style="margin: 5px 0;"><strong>Kelas Buku</strong> : <?php echo e($detail->kodeBuku->buku->kelas ?? '-'); ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <div class="ttd">
        <p>Kepala Perpustakaan<br>SMPN 02 Klakah</p>
        <br><br><br>
        <p>
            <strong><u><?php echo e($kepalaPerpustakaan->nama ?? 'Tidak diketahui'); ?></u></strong><br>
            NIP. <?php echo e($kepalaPerpustakaan->nip ?? '-'); ?>

        </p>
    </div>
</body>

</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/catatanharian/pdf.blade.php ENDPATH**/ ?>