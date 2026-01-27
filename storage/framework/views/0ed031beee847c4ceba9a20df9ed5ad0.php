<?php $__env->startSection('title', 'Data Buku'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Buku <?php echo e(ucfirst($tipe)); ?></span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar buku <?php echo e($tipe); ?> SMPN 02 Klakah
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Beranda</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info" style="font-size:1.1rem;">
                                <i class="fas fa-book" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Buku <?php echo e(ucfirst($tipe)); ?></span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-error');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-session-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-session-error');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000);
                </script>
            <?php endif; ?>

            
            <?php if(session('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="alert-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo e(session('warning')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-warning');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000);
                </script>
            <?php endif; ?>

            
            <?php if(session('removeAll')): ?>
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="alert-removeall">
                    <i class="fas fa-trash-alt"></i>
                    <?php echo e(session('removeAll')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-removeall');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            <div class="card mx-auto mt-3 mb-5 shadow" style="max-width: 98%;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> DataTable Buku <?php echo e(ucfirst($tipe)); ?></h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="<?php echo e(route('buku.create', ['tipe' => $tipe])); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                        <form action="<?php echo e(route('buku.hapussemua')); ?>" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data buku <?php echo e($tipe); ?>?')"
                            style="display: inline;">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <input type="hidden" name="tipe" value="<?php echo e($tipe); ?>">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Semua Buku
                            </button>
                        </form>
                    </div>
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Sampul</th>
                                <th>Kode Buku</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>
                                <?php if($tipe == 'tahunan'): ?>
                                    <th>Kelas</th>
                                <?php endif; ?>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $bukus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $buku): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="<?php echo e(!$buku->is_active ? 'row-inactive' : ''); ?>">
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($buku->judul); ?></td>
                                    <td>
                                        <?php if($buku->foto): ?>
                                            <img src="<?php echo e(str_starts_with($buku->foto, 'sampulbuku/') ? asset($buku->foto) : asset('storage/' . $buku->foto)); ?>" alt="Sampul Buku"
                                                width="60">
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php $__currentLoopData = $buku->kodeBuku; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $detailHarian = $kode
                                                    ->detailPeminjamanHarian()
                                                    ->latest('updated_at')
                                                    ->first();
                                                $detailTahunan = $kode
                                                    ->detailPeminjamanTahunan()
                                                    ->latest('updated_at')
                                                    ->first();

                                                $last = collect([$detailHarian, $detailTahunan])
                                                    ->filter()
                                                    ->sortByDesc('updated_at')
                                                    ->first();

                                                $hilang = $last && $last->status === 'hilang';

                                                $badgeClass = $hilang
                                                    ? 'badge-secondary'
                                                    : ($kode->status === 'dipinjam'
                                                        ? 'badge-danger'
                                                        : 'badge-info');
                                            ?>


                                            <span class="badge <?php echo e($badgeClass); ?> mb-1 d-block">
                                                <?php echo e($kode->kode_buku); ?>

                                                <?php if($hilang): ?>
                                                    <br><small class="text-white fst-italic">(Hilang)</small>
                                                <?php endif; ?>
                                            </span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>


                                    <td><?php echo e($buku->penulis); ?></td>
                                    <td><?php echo e($buku->tahun_terbit); ?></td>
                                    <?php if($tipe == 'tahunan'): ?>
                                        <td>
                                            <?php if($buku->kelas): ?>
                                                <?php
                                                    $badgeColor = 'badge-info';
                                                    if($buku->kelas == '7') {
                                                        $badgeColor = 'badge-success';
                                                    } elseif($buku->kelas == '8') {
                                                        $badgeColor = 'badge-warning';
                                                    } elseif($buku->kelas == '9') {
                                                        $badgeColor = 'badge-danger';
                                                    }
                                                ?>
                                                <span class="badge <?php echo e($badgeColor); ?>"><?php echo e($buku->kelas); ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php echo e($buku->stok); ?>

                                        <?php if(!$buku->is_active): ?>
                                            <br><span class="badge badge-secondary badge-sm">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            // Cek apakah buku pernah dipinjam atau sedang dipinjam
                                            $peminjamanHarianCount = $buku->peminjamanHarianDetails()->count();
                                            $peminjamanTahunanCount = $buku->peminjamanTahunanDetails()->count();
                                            $kodeBukuDipinjam = $buku->kodeBuku()->where('status', 'dipinjam')->count();
                                            
                                            $canDelete = ($peminjamanHarianCount == 0 && $peminjamanTahunanCount == 0 && $kodeBukuDipinjam == 0);
                                            $hasHistory = ($peminjamanHarianCount > 0 || $peminjamanTahunanCount > 0);
                                        ?>
                                        
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('buku.show', $buku->id)); ?>" class="btn btn-secondary" title="Lihat Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('buku.edit', $buku->id)); ?>" class="btn btn-warning" title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if($canDelete): ?>
                                                
                                                <form action="<?php echo e(route('buku.destroy', $buku->id)); ?>" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-danger" title="Hapus buku">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                
                                                <form action="<?php echo e(route('buku.toggle-status', $buku->id)); ?>" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('<?php echo e($buku->is_active ? "Nonaktifkan buku ini? Buku tidak akan muncul dalam daftar peminjaman." : "Aktifkan kembali buku ini?"); ?>')">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" class="btn <?php echo e($buku->is_active ? 'btn-danger' : 'btn-success'); ?>" 
                                                        title="<?php echo e($buku->is_active ? 'Nonaktifkan buku (untuk arsip)' : 'Aktifkan kembali buku'); ?>">
                                                        <i class="fas fa-<?php echo e($buku->is_active ? 'ban' : 'check-circle'); ?>"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                        <?php if(!$canDelete): ?>
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> Tidak bisa dihapus karena untuk arsip
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Data buku <?php echo e($tipe); ?> belum
                                        tersedia.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <style>
        .row-inactive {
            position: relative;
            background: repeating-linear-gradient(
                45deg,
                #e9ecef,
                #e9ecef 10px,
                #dee2e6 10px,
                #dee2e6 20px
            ) !important;
        }
        .row-inactive:hover {
            background: repeating-linear-gradient(
                45deg,
                #f8f9fa,
                #f8f9fa 10px,
                #e9ecef 10px,
                #e9ecef 20px
            ) !important;
        }
        .row-inactive td {
            position: relative;
            opacity: 0.6;
        }
        .row-inactive:hover td {
            opacity: 0.75;
        }
        .row-inactive td:last-child {
            opacity: 1 !important;
            position: relative;
            z-index: 2;
        }
        .row-inactive::after {
            content: "NONAKTIF";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            font-size: 3rem;
            font-weight: 900;
            color: rgba(48, 53, 57, 0.3);
            white-space: nowrap;
            pointer-events: none;
            z-index: 1;
            letter-spacing: 10px;
            text-shadow: 1px 1px 2px rgba(100, 88, 88, 0.5);
        }
        
        /* Fix button alignment in btn-group */
        .btn-group form.d-inline {
            display: inline-block !important;
            margin: 0;
            padding: 0;
        }
        
        .btn-group .btn {
            float: none;
            margin: 0;
        }
    </style>
    <?php $__env->startPush('scripts'); ?>
        <!-- DataTables & Plugins -->
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js')); ?>"></script>
        <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js')); ?>"></script>
        <script>
            $(function() {
                $('#example1').DataTable({
                    responsive: true,
                    lengthChange: false,
                    autoWidth: false,
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/buku/index.blade.php ENDPATH**/ ?>