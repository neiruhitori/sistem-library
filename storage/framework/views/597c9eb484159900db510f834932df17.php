

<?php $__env->startSection('title', 'Edit Peminjaman Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Peminjaman Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('peminjamanguru.index')); ?>">Peminjaman Guru</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <?php if($errors->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e($errors->first('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h3 class="card-title">Form Edit Peminjaman Guru</h3>
                </div>
                <form action="<?php echo e(route('peminjamanguru.update', $peminjaman->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="guru_id">Pilih Guru <span class="text-danger">*</span></label>
                            <select class="form-control select2 <?php $__errorArgs = ['guru_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="guru_id" name="guru_id" required style="width: 100%;">
                                <option value="">-- Pilih Guru --</option>
                                <?php $__currentLoopData = $gurus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $guru): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($guru->id); ?>" 
                                        <?php echo e(old('guru_id', $peminjaman->guru_id) == $guru->id ? 'selected' : ''); ?>>
                                        <?php echo e($guru->nama); ?> <?php echo e($guru->nip ? '(' . $guru->nip . ')' : ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['guru_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_pinjam">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_pinjam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="<?php echo e(old('tanggal_pinjam', $peminjaman->tanggal_pinjam)); ?>" required>
                                    <?php $__errorArgs = ['tanggal_pinjam'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_kembali">Tanggal Kembali <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control <?php $__errorArgs = ['tanggal_kembali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="tanggal_kembali" name="tanggal_kembali" 
                                           value="<?php echo e(old('tanggal_kembali', $peminjaman->tanggal_kembali)); ?>" required>
                                    <?php $__errorArgs = ['tanggal_kembali'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="status" name="status" required>
                                <option value="dipinjam" <?php echo e(old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : ''); ?>>
                                    Dipinjam
                                </option>
                                <option value="selesai" <?php echo e(old('status', $peminjaman->status) == 'selesai' ? 'selected' : ''); ?>>
                                    Selesai
                                </option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label>Daftar Buku yang Dipinjam</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="25%">Kode Buku</th>
                                            <th width="40%">Judul</th>
                                            <th width="35%">Status <span class="text-danger">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $peminjaman->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">
                                                    [<?php echo e($detail->kodePanduanGuru->kode_awal ?? '-'); ?> - <?php echo e($detail->kodePanduanGuru->kode_akhir ?? '-'); ?>]
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo e($detail->bukuPanduanGuru->judul ?? '-'); ?>

                                                <br><small class="text-muted"><?php echo e($detail->bukuPanduanGuru->penulis ?? ''); ?></small>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[<?php echo e($detail->id); ?>]" 
                                                           id="status_dipinjam_<?php echo e($detail->id); ?>"
                                                           value="dipinjam" 
                                                           <?php echo e(old('detail_status.' . $detail->id, $detail->status) == 'dipinjam' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="status_dipinjam_<?php echo e($detail->id); ?>">
                                                        <span class="badge badge-warning">Dipinjam</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[<?php echo e($detail->id); ?>]" 
                                                           id="status_dikembalikan_<?php echo e($detail->id); ?>"
                                                           value="dikembalikan" 
                                                           <?php echo e(old('detail_status.' . $detail->id, $detail->status) == 'dikembalikan' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="status_dikembalikan_<?php echo e($detail->id); ?>">
                                                        <span class="badge badge-success">Dikembalikan</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[<?php echo e($detail->id); ?>]" 
                                                           id="status_hilang_<?php echo e($detail->id); ?>"
                                                           value="hilang" 
                                                           <?php echo e(old('detail_status.' . $detail->id, $detail->status) == 'hilang' ? 'checked' : ''); ?>>
                                                    <label class="form-check-label" for="status_hilang_<?php echo e($detail->id); ?>">
                                                        <span class="badge badge-danger">Hilang</span>
                                                    </label>
                                                </div>
                                                <?php if($detail->tanggal_dikembalikan): ?>
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-calendar"></i> Dikembalikan: <?php echo e($detail->tanggal_dikembalikan); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Ubah status untuk setiap buku yang dikembalikan atau hilang
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Peminjaman
                        </button>
                        <a href="<?php echo e(route('peminjamanguru.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')); ?>"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for guru selection
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Guru --',
            allowClear: true
        });

        // Initialize Select2 for multiple book selection
        $('.select2-multiple').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Buku Panduan Guru --',
            allowClear: true
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/peminjamanguru/edit.blade.php ENDPATH**/ ?>