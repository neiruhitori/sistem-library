

<?php $__env->startSection('title', 'Peminjaman Khusus Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Peminjaman Khusus Guru</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar peminjaman buku panduan guru SMPN 02 Klakah
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home"></i> Beranda
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info" style="font-size:1.1rem;">
                                <i class="fas fa-book-reader"></i> Peminjaman Guru
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

                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success')?.classList.remove('show'), 4000);
                </script>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-error')?.classList.remove('show'), 5000);
                </script>
            <?php endif; ?>

            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Peminjaman Khusus Guru</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex gap-2">
                        <a href="<?php echo e(route('peminjamanguru.create')); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                        <form action="<?php echo e(route('peminjamanguru.hapussemua')); ?>" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data peminjaman guru?')"
                            class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" 
                                <?php echo e($userPeminjamanCount == 0 ? 'disabled' : ''); ?>

                                <?php echo e($userPeminjamanCount == 0 ? 'title="Tidak ada data peminjaman untuk dihapus"' : ''); ?>>
                                <i class="fas fa-trash-alt"></i> Hapus Semua Peminjaman
                                <?php if($userPeminjamanCount > 0): ?>
                                    <span class="badge badge-light ml-1"><?php echo e($userPeminjamanCount); ?></span>
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Guru</th>
                                <th>NIP</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
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
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route('peminjamanguru.index')); ?>',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error loading data:', error);
                        alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_guru',
                        name: 'guru.nama'
                    },
                    {
                        data: 'nip',
                        name: 'guru.nip'
                    },
                    {
                        data: 'tanggal_pinjam',
                        name: 'tanggal_pinjam'
                    },
                    {
                        data: 'tanggal_kembali',
                        name: 'tanggal_kembali'
                    },
                    {
                        data: 'status_badge',
                        name: 'status',
                        orderable: false
                    },
                    {
                        data: 'buku_list',
                        name: 'buku_list',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [3, 'desc']
                ],
                pageLength: 10,
                responsive: true,
                language: {
                    processing: "Memuat...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia",
                    paginate: {
                        first: "Pertama",
                        previous: "Sebelumnya",
                        next: "Selanjutnya",
                        last: "Terakhir"
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/peminjamanguru/index.blade.php ENDPATH**/ ?>