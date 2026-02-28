

<?php $__env->startSection('title', 'Data Periode Tahun Ajaran'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-calendar-alt text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Periode Tahun Ajaran</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Manajemen periode tahun ajaran sekolah
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Beranda</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info" style="font-size:1.1rem;">
                                <i class="fas fa-calendar-alt" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Periode</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-success');
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-error');
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">
                            <i class="fas fa-list"></i> Daftar Periode Tahun Ajaran
                        </h3>
                        <a href="<?php echo e(route('periode.create')); ?>" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Tambah Periode
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Semester</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($index + 1); ?></td>
                                        <td><?php echo e($periode->tahun_ajaran); ?></td>
                                        <td><?php echo e($periode->semester); ?></td>
                                        <td><?php echo e($periode->tanggal_mulai->format('d/m/Y')); ?></td>
                                        <td><?php echo e($periode->tanggal_selesai->format('d/m/Y')); ?></td>
                                        <td class="text-center">
                                            <?php if($periode->is_active): ?>
                                                <span class="badge badge-success">
                                                    <i class="fas fa-check-circle"></i> Aktif
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-times-circle"></i> Tidak Aktif
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <?php if(!$periode->is_active): ?>
                                                    <form action="<?php echo e(route('periode.set-active', $periode->id)); ?>" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PUT'); ?>
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-success"
                                                                onclick="return confirm('Aktifkan periode ini?')">
                                                            <i class="fas fa-check"></i> Aktifkan
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                                <a href="<?php echo e(route('periode.show', $periode->id)); ?>" 
                                                   class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i> Detail
                                                </a>
                                                
                                                <a href="<?php echo e(route('periode.edit', $periode->id)); ?>" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i> Edit
                                                </a>
                                                
                                                <?php if(!$periode->is_active): ?>
                                                    <form action="<?php echo e(route('periode.destroy', $periode->id)); ?>" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Yakin ingin menghapus periode ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada data periode tahun ajaran</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/periode/index.blade.php ENDPATH**/ ?>