<?php $__env->startSection('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book<?php echo e(isset($buku) ? '-open' : ''); ?> text-primary"></i>
                        <span>Detail Buku</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo e(route('buku.harian', ['tipe' => $tipe])); ?>"><i
                                    class="fas fa-book"></i> Buku <?php echo e(ucfirst($tipe)); ?></a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-book"></i> Form Detail Buku</h3>
                </div>
                <form method="post" action="#" enctype="multipart/form-data" autocomplete="off">
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
                                    value="<?php echo e(old('judul', $buku->judul ?? '')); ?>" disabled>
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
                                    value="<?php echo e(old('penulis', $buku->penulis ?? '')); ?>" disabled>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Kode Buku</label>
                                <div id="kode-buku-container">
                                    <?php if(old('kode_buku')): ?>
                                        <?php $__currentLoopData = old('kode_buku'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="<?php echo e($kode); ?>" placeholder="Kode Buku" disabled>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php elseif(isset($buku)): ?>
                                        <?php $__currentLoopData = $buku->kodeBuku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="<?php echo e($kode->kode_buku); ?>" placeholder="Kode Buku" disabled>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <div class="input-group mb-2 kode-buku-item">
                                            <input type="text" name="kode_buku[]" class="form-control"
                                                placeholder="Kode Buku" disabled>
                                        </div>
                                    <?php endif; ?>
                                </div>
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
                                    value="<?php echo e(old('tahun_terbit', $buku->tahun_terbit ?? '')); ?>" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="isbn" class="form-label">Kode ISBN</label>
                                <input type="text" class="form-control" name="isbn" id="isbn" 
                                    placeholder="Tidak ada kode ISBN"
                                    value="<?php echo e(old('isbn', $buku->isbn ?? '')); ?>" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="kota_cetak" class="form-label">Kota Cetak</label>
                                <input type="text" class="form-control" name="kota_cetak" id="kota_cetak" 
                                    placeholder="Tidak ada kota cetak"
                                    value="<?php echo e(old('kota_cetak', $buku->kota_cetak ?? '')); ?>" disabled>
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
                                    rows="3" placeholder="Masukkan deskripsi buku" disabled><?php echo e(old('description', $buku->description ?? '')); ?></textarea>
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label">Foto Buku</label>
                                <?php if(isset($buku) && $buku->foto): ?>
                                    <div class="mt-2">
                                        <img src="<?php echo e(asset('storage/' . $buku->foto)); ?>" alt="Foto Buku"
                                            style="max-height: 150px;" disabled>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/buku/show.blade.php ENDPATH**/ ?>