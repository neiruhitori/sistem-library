

<?php $__env->startSection('title', 'Detail Peminjaman Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Peminjaman Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('peminjamanguru.index')); ?>">Peminjaman Guru</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Informasi Peminjaman</h3>
                </div>
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-user-tie"></i> Data Guru</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Nama Guru</th>
                            <td><?php echo e($peminjaman->guru->nama); ?></td>
                        </tr>
                        <tr>
                            <th>NIP</th>
                            <td><?php echo e($peminjaman->guru->nip ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Tambahan Tugas</th>
                            <td><?php echo e($peminjaman->guru->tambahantugas ?? '-'); ?></td>
                        </tr>
                    </table>

                    <h5 class="mt-4 mb-3"><i class="fas fa-calendar-alt"></i> Data Peminjaman</h5>
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Tanggal Pinjam</th>
                            <td><?php echo e(\Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y')); ?></td>
                        </tr>
                        <tr>
                            <th>Tanggal Kembali</th>
                            <td><?php echo e(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y')); ?></td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                <?php if($peminjaman->status == 'dipinjam'): ?>
                                    <span class="badge badge-warning">Dipinjam</span>
                                <?php else: ?>
                                    <span class="badge badge-success">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Tanggal</th>
                            <td><?php echo e($peminjaman->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>

                    <h5 class="mt-4 mb-3"><i class="fas fa-book"></i> Daftar Buku yang Dipinjam</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Kode</th>
                                    <th width="25%">Penulis</th>
                                    <th width="30%">Judul Buku</th>
                                    <th width="13%">Penerbit</th>
                                    <th width="12%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $peminjaman->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <span class="badge badge-info">
                                                [<?php echo e($detail->kodePanduanGuru->kode_awal ?? '-'); ?> - <?php echo e($detail->kodePanduanGuru->kode_akhir ?? '-'); ?>]
                                            </span>
                                        </td>
                                        <td><?php echo e($detail->bukuPanduanGuru->penulis ?? '-'); ?></td>
                                        <td><?php echo e($detail->bukuPanduanGuru->judul ?? '-'); ?></td>
                                        <td><?php echo e($detail->bukuPanduanGuru->penerbit ?? '-'); ?></td>
                                        <td>
                                            <?php if($detail->status == 'dipinjam'): ?>
                                                <span class="badge badge-warning">Dipinjam</span>
                                            <?php elseif($detail->status == 'dikembalikan'): ?>
                                                <span class="badge badge-success">Dikembalikan</span>
                                                <?php if($detail->tanggal_dikembalikan): ?>
                                                    <br><small class="text-muted"><?php echo e(\Carbon\Carbon::parse($detail->tanggal_dikembalikan)->format('d/m/Y')); ?></small>
                                                <?php endif; ?>
                                            <?php elseif($detail->status == 'hilang'): ?>
                                                <span class="badge badge-danger">Hilang</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo e(route('peminjamanguru.edit', $peminjaman->id)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo e(route('peminjamanguru.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/peminjamanguru/show.blade.php ENDPATH**/ ?>