

<?php $__env->startSection('title', 'Detail Siswa'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user text-primary"></i>
                        <span>Detail Siswa</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('siswa.index')); ?>"><i class="fas fa-users"></i> Siswa</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-user"></i> Detail Data Siswa</h3>
                    <div>
                        <?php if(!empty($siswa->nisn)): ?>
                            <a href="<?php echo e(route('siswa.print.card', $siswa->id)); ?>" 
                               class="btn btn-success btn-sm" 
                               target="_blank">
                                <i class="fas fa-id-card"></i> Cetak Kartu
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('siswa.edit', $siswa->id)); ?>?periode_id=<?php echo e($selectedPeriode); ?>" 
                           class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="mb-3"><i class="fas fa-user-circle"></i> Data Identitas Siswa</h5>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">NISN</label>
                                <p class="form-control-static"><?php echo e($siswa->nisn ?: '-'); ?></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Nama Lengkap</label>
                                <p class="form-control-static"><?php echo e($siswa->name); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Jenis Kelamin</label>
                                <p class="form-control-static">
                                    <?php if($siswa->jenis_kelamin == 'L'): ?>
                                        <span class="badge badge-info">Laki-laki</span>
                                    <?php elseif($siswa->jenis_kelamin == 'P'): ?>
                                        <span class="badge badge-pink">Perempuan</span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Agama</label>
                                <p class="form-control-static"><?php echo e($siswa->agama ?: '-'); ?></p>
                            </div>
                        </div>
                    </div>

                    <?php if($siswaPeriode): ?>
                        <hr>
                        <h5 class="mb-3"><i class="fas fa-school"></i> Data Kelas (<?php echo e($siswaPeriode->periode->nama_lengkap); ?>)</h5>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Kelas</label>
                                    <p class="form-control-static">
                                        <?php
                                            $kelas = strtoupper($siswaPeriode->kelas);
                                        ?>
                                        <?php if(Str::startsWith($kelas, '7')): ?>
                                            <span class="badge badge-success" style="font-size:1.2rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                        <?php elseif(Str::startsWith($kelas, '8')): ?>
                                            <span class="badge badge-warning" style="font-size:1.2rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                        <?php elseif(Str::startsWith($kelas, '9')): ?>
                                            <span class="badge badge-danger" style="font-size:1.2rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary" style="font-size:1.2rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">No. Absen</label>
                                    <p class="form-control-static"><?php echo e($siswaPeriode->absen ?: '-'); ?></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">Status</label>
                                    <p class="form-control-static">
                                        <?php if($siswaPeriode->status == 'Aktif'): ?>
                                            <span class="badge badge-success"><?php echo e($siswaPeriode->status); ?></span>
                                        <?php elseif($siswaPeriode->status == 'Lulus'): ?>
                                            <span class="badge badge-info"><?php echo e($siswaPeriode->status); ?></span>
                                        <?php elseif($siswaPeriode->status == 'Pindah'): ?>
                                            <span class="badge badge-warning"><?php echo e($siswaPeriode->status); ?></span>
                                        <?php else: ?>
                                            <span class="badge badge-secondary"><?php echo e($siswaPeriode->status); ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            Siswa ini belum memiliki data kelas pada periode yang dipilih.
                        </div>
                    <?php endif; ?>

                    <?php if($siswa->siswaPeriodes->count() > 0): ?>
                        <hr>
                        <h5 class="mb-3"><i class="fas fa-history"></i> Riwayat Kelas</h5>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-primary">
                                    <tr>
                                        <th>Periode</th>
                                        <th>Kelas</th>
                                        <th>Absen</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $siswa->siswaPeriodes()->with('periode')->orderBy('created_at', 'DESC')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $riwayat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($riwayat->periode->nama_lengkap); ?></td>
                                            <td>
                                                <?php
                                                    $kelas = strtoupper($riwayat->kelas);
                                                ?>
                                                <?php if(Str::startsWith($kelas, '7')): ?>
                                                    <span class="badge badge-success"><?php echo e($riwayat->kelas); ?></span>
                                                <?php elseif(Str::startsWith($kelas, '8')): ?>
                                                    <span class="badge badge-warning"><?php echo e($riwayat->kelas); ?></span>
                                                <?php elseif(Str::startsWith($kelas, '9')): ?>
                                                    <span class="badge badge-danger"><?php echo e($riwayat->kelas); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary"><?php echo e($riwayat->kelas); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($riwayat->absen ?: '-'); ?></td>
                                            <td>
                                                <?php if($riwayat->status == 'Aktif'): ?>
                                                    <span class="badge badge-success"><?php echo e($riwayat->status); ?></span>
                                                <?php elseif($riwayat->status == 'Lulus'): ?>
                                                    <span class="badge badge-info"><?php echo e($riwayat->status); ?></span>
                                                <?php elseif($riwayat->status == 'Pindah'): ?>
                                                    <span class="badge badge-warning"><?php echo e($riwayat->status); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary"><?php echo e($riwayat->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="<?php echo e(route('siswa.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/siswa/show.blade.php ENDPATH**/ ?>