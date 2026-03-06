

<?php $__env->startSection('title', 'Edit Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('guru.index')); ?>">Guru</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h3 class="card-title">Form Edit Guru</h3>
                </div>
                <form action="<?php echo e(route('guru.update', $guru->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="nip" name="nip" value="<?php echo e(old('nip', $guru->nip)); ?>">
                            <?php $__errorArgs = ['nip'];
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
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="nama" name="nama" value="<?php echo e(old('nama', $guru->nama)); ?>" required>
                            <?php $__errorArgs = ['nama'];
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
                            <label for="tambahantugas">Tambahan Tugas</label>
                            <select class="form-control select2 <?php $__errorArgs = ['tambahantugas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="tambahantugas" name="tambahantugas" style="width: 100%;">
                                <option value="">-- Pilih Tambahan Tugas --</option>
                                <option value="Wali Kelas 7A" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7A' ? 'selected' : ''); ?>>Wali Kelas 7A</option>
                                <option value="Wali Kelas 7B" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7B' ? 'selected' : ''); ?>>Wali Kelas 7B</option>
                                <option value="Wali Kelas 7C" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7C' ? 'selected' : ''); ?>>Wali Kelas 7C</option>
                                <option value="Wali Kelas 7D" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7D' ? 'selected' : ''); ?>>Wali Kelas 7D</option>
                                <option value="Wali Kelas 7E" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7E' ? 'selected' : ''); ?>>Wali Kelas 7E</option>
                                <option value="Wali Kelas 7F" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7F' ? 'selected' : ''); ?>>Wali Kelas 7F</option>
                                <option value="Wali Kelas 7G" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7G' ? 'selected' : ''); ?>>Wali Kelas 7G</option>
                                <option value="Wali Kelas 8A" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8A' ? 'selected' : ''); ?>>Wali Kelas 8A</option>
                                <option value="Wali Kelas 8B" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8B' ? 'selected' : ''); ?>>Wali Kelas 8B</option>
                                <option value="Wali Kelas 8C" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8C' ? 'selected' : ''); ?>>Wali Kelas 8C</option>
                                <option value="Wali Kelas 8D" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8D' ? 'selected' : ''); ?>>Wali Kelas 8D</option>
                                <option value="Wali Kelas 8E" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8E' ? 'selected' : ''); ?>>Wali Kelas 8E</option>
                                <option value="Wali Kelas 8F" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8F' ? 'selected' : ''); ?>>Wali Kelas 8F</option>
                                <option value="Wali Kelas 8G" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8G' ? 'selected' : ''); ?>>Wali Kelas 8G</option>
                                <option value="Wali Kelas 9A" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9A' ? 'selected' : ''); ?>>Wali Kelas 9A</option>
                                <option value="Wali Kelas 9B" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9B' ? 'selected' : ''); ?>>Wali Kelas 9B</option>
                                <option value="Wali Kelas 9C" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9C' ? 'selected' : ''); ?>>Wali Kelas 9C</option>
                                <option value="Wali Kelas 9D" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9D' ? 'selected' : ''); ?>>Wali Kelas 9D</option>
                                <option value="Wali Kelas 9E" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9E' ? 'selected' : ''); ?>>Wali Kelas 9E</option>
                                <option value="Wali Kelas 9F" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9F' ? 'selected' : ''); ?>>Wali Kelas 9F</option>
                                <option value="Wali Kelas 9G" <?php echo e(old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9G' ? 'selected' : ''); ?>>Wali Kelas 9G</option>
                            </select>
                            <?php $__errorArgs = ['tambahantugas'];
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
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="keterangan" name="keterangan" rows="3"><?php echo e(old('keterangan', $guru->keterangan)); ?></textarea>
                            <?php $__errorArgs = ['keterangan'];
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
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo e(route('guru.index')); ?>" class="btn btn-secondary">
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
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Tambahan Tugas --',
                allowClear: true
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/guru/edit.blade.php ENDPATH**/ ?>