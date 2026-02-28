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

                            <?php if($tipe === 'tahunan'): ?>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-control <?php $__errorArgs = ['kelas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="kelas" id="kelas">
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="7" <?php echo e(old('kelas', $buku->kelas ?? '') == '7' ? 'selected' : ''); ?>>Kelas 7</option>
                                    <option value="8" <?php echo e(old('kelas', $buku->kelas ?? '') == '8' ? 'selected' : ''); ?>>Kelas 8</option>
                                    <option value="9" <?php echo e(old('kelas', $buku->kelas ?? '') == '9' ? 'selected' : ''); ?>>Kelas 9</option>
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
                                <small class="text-muted">Buku ini akan muncul di peminjaman untuk kelas yang dipilih</small>
                            </div>
                            <?php endif; ?>

                            <div class="col-md-6">
                                <label for="penerbit_id" class="form-label">Penerbit</label>
                                <select class="form-control <?php $__errorArgs = ['penerbit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="penerbit_id" id="penerbit_id">
                                    <option value="">-- Pilih Penerbit --</option>
                                    <?php $__currentLoopData = $penerbits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $penerbit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($penerbit->id); ?>" <?php echo e(old('penerbit_id', $buku->penerbit_id ?? '') == $penerbit->id ? 'selected' : ''); ?>>
                                            <?php echo e($penerbit->penerbit); ?> - <?php echo e($penerbit->nama_barang); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['penerbit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                                <small class="text-muted d-block mb-3">
                                    <i class="fas fa-info-circle"></i> Masukkan kode awal dan kode akhir yang akan digabungkan menjadi kode buku. 
                                    <strong>Contoh:</strong> Kode Awal "BK" + Kode Akhir "001" = <strong>"BK - 001"</strong>. Boleh mengisi salah satu saja.
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
                                                                    value="<?php echo e($kodeAwal); ?>" placeholder="Contoh: BK">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Akhir</label>
                                                                <input type="text" name="kode_akhir[]" class="form-control" 
                                                                    value="<?php echo e(old('kode_akhir')[$index] ?? ''); ?>" placeholder="Contoh: 001">
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
                                    <?php elseif(isset($buku) && $buku->kodeBuku->isNotEmpty()): ?>
                                        <?php $__currentLoopData = $buku->kodeBuku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kodeBuku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                // Split kode_buku by ' - ' to get kode_awal and kode_akhir
                                                $parts = explode(' - ', $kodeBuku->kode_buku);
                                                $kodeAwal = $parts[0] ?? '';
                                                $kodeAkhir = $parts[1] ?? '';
                                            ?>
                                            <div class="kode-buku-item mb-3">
                                                <div class="card border-light shadow-sm">
                                                    <div class="card-body py-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Awal</label>
                                                                <input type="text" name="kode_awal[]" class="form-control" 
                                                                    value="<?php echo e($kodeAwal); ?>" placeholder="Contoh: BK">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Akhir</label>
                                                                <input type="text" name="kode_akhir[]" class="form-control" 
                                                                    value="<?php echo e($kodeAkhir); ?>" placeholder="Contoh: 001">
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
                                                                placeholder="Contoh: BK">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Akhir</label>
                                                            <input type="text" name="kode_akhir[]" class="form-control" 
                                                                placeholder="Contoh: 001">
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="hapusKodeBuku(this)" title="Hapus range ini">
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
                                        <img src="<?php echo e(str_starts_with($buku->foto ?? '', 'sampulbuku/') ? asset($buku->foto) : asset('storage/' . ($buku->foto ?? 'default.jpg'))); ?>" alt="Foto Buku"
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
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">

    
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js')); ?>"></script>

    <script>
        // Wait for DOM and jQuery to be fully loaded
        $(document).ready(function() {
            console.log('Initializing Select2...');
            
            // Initialize Select2 for penerbit dropdown
            $('#penerbit_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Penerbit --',
                allowClear: true,
                width: '100%'
            });
            
            console.log('Select2 initialized');
        });

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
                                    placeholder="Contoh: BK">
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Akhir</label>
                                <input type="text" name="kode_akhir[]" class="form-control" 
                                    placeholder="Contoh: 001">
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/buku/form.blade.php ENDPATH**/ ?>