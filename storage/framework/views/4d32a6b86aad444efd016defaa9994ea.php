<?php $__env->startSection('title', 'Tambah Peminjaman Tahunan'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary" style="font-size: 2rem">
                        <i class="fas fa-book-reader"></i>
                        Tambah Peminjaman Tahunan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><span class="badge badge-primary"><i
                                        class="fas fa-home"></i> Beranda</span></a></li>
                        <li class="breadcrumb-item"><a href="/peminjamantahunan"><span class="badge badge-primary"><i
                                        class="fas fa-book-reader"></i> Peminjaman Tahunan</span></a></li>
                        <li class="breadcrumb-item active"><span class="badge badge-info"><i class="fas fa-plus"></i>
                                Tambah</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Form Tambah Peminjaman Tahunan</h3>
                </div>
                <form method="POST" action="<?php echo e(route('peminjamantahunan.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="siswas_id" class="form-label">Nama Siswa</label>
                                <select name="siswas_id" id="siswas_id" class="form-control select2">
                                    <option value="">-- Pilih Siswa --</option>
                                    <?php $__currentLoopData = $siswas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siswa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($siswa->id); ?>">
                                            <?php echo e($siswa->name); ?> - <?php echo e($siswa->nisn ?? 'Belum ada NISN'); ?> -
                                            <?php echo e($siswa->kelas); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam">
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Pilih Buku (Kode Buku)</label>
                                <div id="kode-buku-container">
                                    <div class="input-group mb-2 kode-buku-item">
                                        <select name="kode_buku[]" class="form-control select2-single">
                                            <option value="">-- Pilih Kode Buku --</option>
                                            <?php $__currentLoopData = $kode_bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($kode->id); ?>"
                                                    <?php echo e($kode->status == 'dipinjam' ? 'disabled' : ''); ?>>
                                                    <?php echo e($kode->kode_buku); ?> - <?php echo e($kode->buku->judul ?? '-'); ?>

                                                    <?php echo e($kode->status == 'dipinjam' ? '(Masih Dipinjam)' : ''); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                    onclick="tambahKodeBuku()">
                                    + Tambah Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('peminjamantahunan.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Buat Pinjaman?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menyimpan data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <?php $__env->startPush('styles'); ?>
                    <style>
                        select option[disabled] {
                            color: red;
                            font-style: italic;
                        }
                    </style>
                <?php $__env->stopPush(); ?>
                <?php $__env->startPush('scripts'); ?>
                    <!-- Select2 -->
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('.select2').select2();
                            $('.select2-single').select2();
                        });

                        function tambahKodeBuku() {
                            const container = document.getElementById('kode-buku-container');
                            const group = document.createElement('div');
                            group.classList.add('input-group', 'mb-2', 'kode-buku-item');

                            group.innerHTML = `
                <select name="kode_buku[]" class="form-control select2-single">
                    <option value="">-- Pilih Kode Buku --</option>
                    <?php $__currentLoopData = $kode_bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kode->id); ?>"><?php echo e($kode->kode_buku); ?> - <?php echo e($kode->buku->judul ?? '-'); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.kode-buku-item').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                            container.appendChild(group);
                            $(group).find('.select2-single').select2();
                        }
                    </script>
                <?php $__env->stopPush(); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/peminjamantahunan/create.blade.php ENDPATH**/ ?>