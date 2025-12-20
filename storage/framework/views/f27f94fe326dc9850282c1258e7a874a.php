<?php $__env->startSection('title', 'Tambah Siswa'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-plus text-primary"></i>
                        <span>Edit Siswa</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('siswa.index')); ?>"><i class="fas fa-users"></i>
                                Siswa</a></li>
                        <li class="breadcrumb-item active">Edit Siswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 700px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i> Form Edit Siswa</h3>
                </div>
                <form method="post" action="<?php echo e(route('siswa.update', $siswa->id)); ?>" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['nisn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="nisn" id="nisn" placeholder="Masukkan NISN Siswa"
                                    value="<?php echo e($siswa->nisn); ?>">
                                <?php $__errorArgs = ['nisn'];
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
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="name" id="name" placeholder="Masukkan Nama Siswa"
                                    value="<?php echo e($siswa->name); ?>">
                                <?php $__errorArgs = ['name'];
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
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select name="kelas" id="kelas"
                                    class="form-control <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                    <option selected disabled><?php echo e($siswa->kelas); ?></option>
                                    <?php $__currentLoopData = ['VII A', 'VII B', 'VII C', 'VII D', 'VII E', 'VII F', 'VII G', 'VIII A', 'VIII B', 'VIII C', 'VIII D', 'VIII E', 'VIII F', 'VIII G', 'IX A', 'IX B', 'IX C', 'IX D', 'IX E', 'IX F', 'IX G']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kelas); ?>" <?php echo e(old('kelas') == $kelas ? 'selected' : ''); ?>>
                                            <?php echo e($kelas); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['kelas'];
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
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('siswa.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Simpan Perubahan?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin merubah data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            Ubah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/siswa/edit.blade.php ENDPATH**/ ?>