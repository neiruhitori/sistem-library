

<?php $__env->startSection('title', 'Detail Buku Panduan Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Buku Panduan Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('bukupanduanguru.index')); ?>">Buku Panduan Guru</a></li>
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
                    <h3 class="card-title">Informasi Buku Panduan Guru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Kode Buku</th>
                            <td>
                                <?php if($buku->kodePanduanGuru && $buku->kodePanduanGuru->count() > 0): ?>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $buku->kodePanduanGuru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge badge-primary mr-2 mb-1" style="font-size: 14px;">
                                                [<?php echo e($kode->kode_awal ?? '-'); ?> - <?php echo e($kode->kode_akhir ?? '-'); ?>]
                                                <small class="text-white">(<?php echo e(ucfirst($kode->status)); ?>)</small>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada kode</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td><?php echo e($buku->penulis); ?></td>
                        </tr>
                        <tr>
                            <th>Judul Buku</th>
                            <td><?php echo e($buku->judul); ?></td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td><?php echo e($buku->penerbit); ?></td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td><?php echo e($buku->tahun); ?></td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td>
                                <span class="badge badge-success" style="font-size: 14px;">
                                    <?php echo e($buku->kodePanduanGuru->where('status', 'tersedia')->count()); ?>

                                </span>
                                dari total 
                                <span class="badge badge-info" style="font-size: 14px;">
                                    <?php echo e($buku->kodePanduanGuru->count()); ?>

                                </span>
                                kode buku
                            </td>
                        </tr>
                        <tr>
                            <th>Ditambahkan</th>
                            <td><?php echo e($buku->created_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td><?php echo e($buku->updated_at->format('d/m/Y H:i')); ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="<?php echo e(route('bukupanduanguru.edit', $buku->id)); ?>" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="<?php echo e(route('bukupanduanguru.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/bukupanduanguru/show.blade.php ENDPATH**/ ?>