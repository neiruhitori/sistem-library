

<?php $__env->startSection('title', 'Edit Buku Panduan Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Buku Panduan Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('bukupanduanguru.index')); ?>">Buku Panduan Guru</a></li>
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
                    <h3 class="card-title">Form Edit Buku Panduan Guru</h3>
                </div>
                <form action="<?php echo e(route('bukupanduanguru.update', $buku->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-3">
                                <i class="fas fa-info-circle"></i> Masukkan kode awal dan kode akhir untuk buku panduan guru. 
                                Anda dapat menambahkan lebih dari satu range kode. Minimal harus ada satu kode yang diisi.
                            </small>
                            <div id="kode-buku-container">
                                <?php if(old('kode_awal')): ?>
                                    <?php $__currentLoopData = old('kode_awal'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $kodeAwal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="kode-buku-item mb-3">
                                            <div class="card border-light shadow-sm">
                                                <div class="card-body py-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Awal</label>
                                                            <input type="text" name="kode_awal[]" class="form-control" 
                                                                value="<?php echo e($kodeAwal); ?>" placeholder="Contoh: 43898">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Akhir</label>
                                                            <input type="text" name="kode_akhir[]" class="form-control" 
                                                                value="<?php echo e(old('kode_akhir')[$index] ?? ''); ?>" placeholder="Contoh: 43903">
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="hapusKodeBuku(this)" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php elseif($buku->kodePanduanGuru->isNotEmpty()): ?>
                                    <?php $__currentLoopData = $buku->kodePanduanGuru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="kode-buku-item mb-3">
                                            <div class="card border-light shadow-sm">
                                                <div class="card-body py-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Awal</label>
                                                            <input type="text" name="kode_awal[]" class="form-control" 
                                                                value="<?php echo e($kode->kode_awal); ?>" placeholder="Contoh: 43898">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Akhir</label>
                                                            <input type="text" name="kode_akhir[]" class="form-control" 
                                                                value="<?php echo e($kode->kode_akhir); ?>" placeholder="Contoh: 43903">
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="hapusKodeBuku(this)" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="kode-buku-item mb-3">
                                        <div class="card border-light shadow-sm">
                                            <div class="card-body py-2">
                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <label class="small text-muted mb-1">Kode Awal</label>
                                                        <input type="text" name="kode_awal[]" class="form-control" 
                                                            placeholder="Contoh: 43898">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="small text-muted mb-1">Kode Akhir</label>
                                                        <input type="text" name="kode_akhir[]" class="form-control" 
                                                            placeholder="Contoh: 43903">
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="hapusKodeBuku(this)" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" 
                                onclick="tambahKodeBuku()">
                                <i class="fas fa-plus-circle"></i> Tambah Kode Buku Lagi
                            </button>

                            <?php $__errorArgs = ['kode_buku'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['kode_awal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['kode_akhir'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group mb-3">
                            <label for="penulis">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['penulis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="penulis" name="penulis" value="<?php echo e(old('penulis', $buku->penulis)); ?>" required>
                            <?php $__errorArgs = ['penulis'];
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
                            <label for="judul">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="judul" name="judul" value="<?php echo e(old('judul', $buku->judul)); ?>" required>
                            <?php $__errorArgs = ['judul'];
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
                                    <label for="penerbit">Penerbit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['penerbit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="penerbit" name="penerbit" value="<?php echo e(old('penerbit', $buku->penerbit)); ?>" required>
                                    <?php $__errorArgs = ['penerbit'];
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
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control <?php $__errorArgs = ['tahun'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="tahun" name="tahun" value="<?php echo e(old('tahun', $buku->tahun)); ?>" 
                                           min="1900" max="<?php echo e(date('Y') + 1); ?>" placeholder="Kosongkan jika tidak ada">
                                    <?php $__errorArgs = ['tahun'];
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
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="<?php echo e(route('bukupanduanguru.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Function to add new kode buku input pair
        function tambahKodeBuku() {
            const container = document.getElementById('kode-buku-container');
            const wrapper = document.createElement('div');
            wrapper.classList.add('kode-buku-item', 'mb-3');

            wrapper.innerHTML = `
                <div class="card border-light shadow-sm">
                    <div class="card-body py-2">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Awal</label>
                                <input type="text" name="kode_awal[]" class="form-control" 
                                    placeholder="Contoh: 43898">
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Akhir</label>
                                <input type="text" name="kode_akhir[]" class="form-control" 
                                    placeholder="Contoh: 43903">
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="hapusKodeBuku(this)" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(wrapper);
        }

        // Function to remove kode buku input pair
        function hapusKodeBuku(el) {
            const container = document.getElementById('kode-buku-container');
            const items = container.querySelectorAll('.kode-buku-item');
            
            // Prevent removing if only one item remains
            if (items.length > 1) {
                el.closest('.kode-buku-item').remove();
            } else {
                alert('Minimal harus ada satu kode buku!');
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/bukupanduanguru/edit.blade.php ENDPATH**/ ?>