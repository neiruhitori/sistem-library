

<?php $__env->startSection('title', isset($penandatangan) ? 'Edit Penandatangan' : 'Tambah Penandatangan'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-tie text-primary"></i>
                        <span><?php echo e(isset($penandatangan) ? 'Edit' : 'Tambah'); ?> Penandatangan</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('penandatangan.index')); ?>"><i class="fas fa-user-tie"></i> Penandatangan</a></li>
                        <li class="breadcrumb-item active"><?php echo e(isset($penandatangan) ? 'Edit' : 'Tambah'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 600px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-tie"></i> Form <?php echo e(isset($penandatangan) ? 'Edit' : 'Tambah'); ?> Penandatangan</h3>
                </div>
                <form method="POST" action="<?php echo e(isset($penandatangan) ? route('penandatangan.update', $penandatangan->id) : route('penandatangan.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <?php if(isset($penandatangan)): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                            <select class="form-control <?php $__errorArgs = ['jabatan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="jabatan" id="jabatan" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="kepala_perpustakaan" <?php echo e(old('jabatan', $penandatangan->jabatan ?? '') == 'kepala_perpustakaan' ? 'selected' : ''); ?>>
                                    Kepala Perpustakaan
                                </option>
                                <option value="kepala_sekolah" <?php echo e(old('jabatan', $penandatangan->jabatan ?? '') == 'kepala_sekolah' ? 'selected' : ''); ?>>
                                    Kepala Sekolah
                                </option>
                            </select>
                            <?php $__errorArgs = ['jabatan'];
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

                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nama'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                name="nama" id="nama" placeholder="Masukkan nama penandatangan" 
                                value="<?php echo e(old('nama', $penandatangan->nama ?? '')); ?>" required>
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

                        <div class="form-group">
                            <label for="nip">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nip'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                name="nip" id="nip" placeholder="Masukkan NIP" 
                                value="<?php echo e(old('nip', $penandatangan->nip ?? '')); ?>" required>
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

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                    <?php echo e(old('is_active', $penandatangan->is_active ?? false) ? 'checked' : ''); ?>>
                                <label class="custom-control-label" for="is_active">
                                    Aktifkan sebagai penandatangan utama
                                </label>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Jika dicentang, penandatangan lain dengan jabatan yang sama akan dinonaktifkan
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="<?php echo e(route('penandatangan.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/penandatangan/form.blade.php ENDPATH**/ ?>