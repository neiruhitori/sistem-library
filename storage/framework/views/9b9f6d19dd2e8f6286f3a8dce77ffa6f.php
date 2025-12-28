

<?php $__env->startSection('title', 'Data Penandatangan'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-tie text-primary"></i>
                        <span>Data Penandatangan</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item active">Penandatangan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title"><i class="fas fa-user-tie"></i> Daftar Penandatangan</h3>
                    <a href="<?php echo e(route('penandatangan.create')); ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-plus"></i> Tambah Penandatangan
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> 
                        <strong>Informasi:</strong> Hanya satu penandatangan yang dapat aktif untuk setiap jabatan. 
                        Penandatangan yang aktif akan digunakan dalam PDF.
                    </div>
                    
                    <h5 class="mt-4"><i class="fas fa-book-reader"></i> Kepala Perpustakaan</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $penandatangans->where('jabatan', 'kepala_perpustakaan'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td><?php echo e($item->nama); ?></td>
                                    <td><?php echo e($item->nip); ?></td>
                                    <td>
                                        <?php if($item->is_active): ?>
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><i class="fas fa-times"></i> Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="<?php echo e(route('penandatangan.toggle-active', $item->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm <?php echo e($item->is_active ? 'btn-warning' : 'btn-success'); ?>" 
                                                    title="<?php echo e($item->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                                    <i class="fas fa-<?php echo e($item->is_active ? 'toggle-off' : 'toggle-on'); ?>"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('penandatangan.edit', $item->id)); ?>" class="btn btn-sm btn-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('penandatangan.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data kepala perpustakaan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <h5 class="mt-5"><i class="fas fa-school"></i> Kepala Sekolah</h5>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama</th>
                                <th>NIP</th>
                                <th>Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $penandatangans->where('jabatan', 'kepala_sekolah'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($no++); ?></td>
                                    <td><?php echo e($item->nama); ?></td>
                                    <td><?php echo e($item->nip); ?></td>
                                    <td>
                                        <?php if($item->is_active): ?>
                                            <span class="badge badge-success"><i class="fas fa-check"></i> Aktif</span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><i class="fas fa-times"></i> Tidak Aktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <form action="<?php echo e(route('penandatangan.toggle-active', $item->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="btn btn-sm <?php echo e($item->is_active ? 'btn-warning' : 'btn-success'); ?>" 
                                                    title="<?php echo e($item->is_active ? 'Nonaktifkan' : 'Aktifkan'); ?>">
                                                    <i class="fas fa-<?php echo e($item->is_active ? 'toggle-off' : 'toggle-on'); ?>"></i>
                                                </button>
                                            </form>
                                            <a href="<?php echo e(route('penandatangan.edit', $item->id)); ?>" class="btn btn-sm btn-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?php echo e(route('penandatangan.destroy', $item->id)); ?>" method="POST" class="d-inline">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Yakin ingin menghapus?')" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data kepala sekolah</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/penandatangan/index.blade.php ENDPATH**/ ?>