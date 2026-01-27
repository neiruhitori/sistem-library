<?php $__env->startSection('title', 'Catatan Tahunan'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Catatan Tahunan</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar catatan tahunan buku SMPN 02 Klakah
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
                                <i class="fas fa-book-reader" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Catatan Tahunan</span>
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
                    <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success').classList.remove('show'), 4000);
                </script>
            <?php endif; ?>
            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Catatan Tahunan</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Status -->
                    <div class="mb-3">
                        <form action="<?php echo e(route('catatantahunan.index')); ?>" method="GET" class="form-inline">
                            <label for="status" class="mr-2">Filter Status:</label>
                            <select name="status" id="status" class="form-control mr-2" style="width: 200px;">
                                <option value="">Semua Status</option>
                                <option value="dibayar" <?php echo e(request('status') == 'dibayar' ? 'selected' : ''); ?>>Lunas</option>
                                <option value="belum_dibayar" <?php echo e(request('status') == 'belum_dibayar' ? 'selected' : ''); ?>>Belum Bayar</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <?php if(request('status')): ?>
                                <a href="<?php echo e(route('catatantahunan.index')); ?>" class="btn btn-secondary btn-sm ml-2">
                                    <i class="fas fa-times"></i> Reset
                                </a>
                            <?php endif; ?>
                        </form>
                    </div>
                    
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Denda</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>status</th>
                                <th>Aksi</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $catatans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $catatan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($key + 1); ?></td>
                                    <td><?php echo e($catatan->siswa->name); ?></td>
                                    <td><?php echo e(ucfirst($catatan->jenis_denda)); ?></td>
                                    <td>Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?></td>
                                    <td><?php echo e($catatan->keterangan); ?></td>
                                    <td><?php echo e($catatan->tanggal_denda); ?></td>
                                    <td>
                                        <span
                                            class="badge badge-<?php echo e($catatan->status === 'dibayar' ? 'success' : 'danger'); ?>">
                                            <?php echo e($catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar'); ?>

                                        </span>

                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('catatantahunan.show', $catatan->id)); ?>"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/catatantahunan/index.blade.php ENDPATH**/ ?>