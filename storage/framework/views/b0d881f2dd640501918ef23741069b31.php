<?php $__env->startSection('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book<?php echo e(isset($buku) ? '-open' : ''); ?> text-primary"></i>
                        <span><?php echo e(isset($buku) ? 'Edit Buku' : 'Tambah Buku'); ?></span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('buku.harian', ['tipe' => $tipe])); ?>"><i
                                    class="fas fa-book"></i> Buku <?php echo e(ucfirst($tipe)); ?></a></li>
                        <li class="breadcrumb-item active"><?php echo e(isset($buku) ? 'Edit' : 'Tambah'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-book"></i> Form <?php echo e(isset($buku) ? 'Edit' : 'Tambah'); ?> Buku</h3>
                </div>
                <form method="post" action="<?php echo e(isset($buku) ? route('buku.update', $buku->id) : route('buku.store')); ?>"
                    enctype="multipart/form-data" autocomplete="off">
                    <?php echo csrf_field(); ?>
                    <?php if(isset($buku)): ?>
                        <?php echo method_field('PUT'); ?>
                    <?php endif; ?>

                    <div class="card-body">
                        <input type="hidden" name="tipe" value="<?php echo e($tipe); ?>">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="judul" id="judul" placeholder="Masukkan Judul Buku"
                                    value="<?php echo e(old('judul', $buku->judul ?? '')); ?>">
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
                            <div class="col-md-6">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['penulis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="penulis" id="penulis" placeholder="Masukkan Nama Penulis"
                                    value="<?php echo e(old('penulis', $buku->penulis ?? '')); ?>">
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

                            <div class="col-12">
                                <label class="form-label">Kode Buku (bisa lebih dari satu)</label>
                                <div id="kode-buku-container">
                                    <?php if(old('kode_buku')): ?>
                                        <?php $__currentLoopData = old('kode_buku'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="<?php echo e($kode); ?>" placeholder="Kode Buku">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusKodeBuku(this)">❌</button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif(isset($buku)): ?>
                                        <?php $__currentLoopData = $buku->kodeBuku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="<?php echo e($kode->kode_buku); ?>" placeholder="Kode Buku">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusKodeBuku(this)">❌</button>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="input-group mb-2 kode-buku-item">
                                            <input type="text" name="kode_buku[]" class="form-control"
                                                placeholder="Kode Buku">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="hapusKodeBuku(this)">❌</button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                    onclick="tambahKodeBuku()">+ Tambah Kode</button>

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
                            </div>

                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" min="1900" max="<?php echo e(date('Y')); ?>"
                                    class="form-control <?php $__errorArgs = ['tahun_terbit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="tahun_terbit"
                                    id="tahun_terbit" placeholder="Masukkan Tahun Terbit"
                                    value="<?php echo e(old('tahun_terbit', $buku->tahun_terbit ?? '')); ?>">
                                <?php $__errorArgs = ['tahun_terbit'];
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
                                <label for="isbn" class="form-label">Kode ISBN</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['isbn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="isbn" id="isbn" placeholder="Masukkan Kode ISBN"
                                    value="<?php echo e(old('isbn', $buku->isbn ?? '')); ?>">
                                <?php $__errorArgs = ['isbn'];
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
                                <label for="kota_cetak" class="form-label">Kota Cetak</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['kota_cetak'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="kota_cetak" id="kota_cetak" placeholder="Masukkan Kota Cetak"
                                    value="<?php echo e(old('kota_cetak', $buku->kota_cetak ?? '')); ?>">
                                <?php $__errorArgs = ['kota_cetak'];
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

                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="description" id="description"
                                    rows="3" placeholder="Masukkan deskripsi buku"><?php echo e(old('description', $buku->description ?? '')); ?></textarea>
                                <?php $__errorArgs = ['description'];
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

                            <div class="col-12">
                                <label for="foto" class="form-label">Foto Buku</label>
                                <input type="file" class="form-control <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="foto" id="foto" accept="image/*">
                                <?php $__errorArgs = ['foto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <?php if(isset($buku) && $buku->foto): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo e(asset('storage/' . $buku->foto)); ?>" alt="Foto Buku"
                                            style="max-height: 150px;">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('buku.' . $tipe, ['tipe' => $tipe])); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> <?php echo e(isset($buku) ? 'Update' : 'Simpan'); ?> Buku
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo e(isset($buku) ? 'Update' : 'Simpan'); ?> Buku?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin <?php echo e(isset($buku) ? 'Update' : 'Simpan'); ?> data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            <?php echo e(isset($buku) ? 'Update' : 'Simpan'); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                
                <script>
                    function tambahKodeBuku() {
                        const container = document.getElementById('kode-buku-container');
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('input-group', 'mb-2', 'kode-buku-item');

                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'kode_buku[]';
                        input.placeholder = 'Kode Buku';
                        input.classList.add('form-control');

                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.classList.add('btn', 'btn-danger', 'btn-sm');
                        btn.textContent = '❌';
                        btn.onclick = function() {
                            wrapper.remove();
                        };

                        wrapper.appendChild(input);
                        wrapper.appendChild(btn);
                        container.appendChild(wrapper);
                    }

                    function hapusKodeBuku(el) {
                        el.closest('.kode-buku-item').remove();
                    }
                </script>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/buku/form.blade.php ENDPATH**/ ?>