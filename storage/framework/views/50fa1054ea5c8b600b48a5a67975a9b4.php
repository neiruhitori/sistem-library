

<?php $__env->startSection('title', 'Data Buku Panduan Guru'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Buku Panduan Guru</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Identitas Buku Panduan Guru
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
                                <i class="fas fa-book"></i> Buku Panduan Guru
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
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list"></i> Daftar Buku Panduan Guru
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="<?php echo e(route('bukupanduanguru.create')); ?>" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Buku
                            </a>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                            
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3 d-flex gap-2">
                        <a href="<?php echo e(route('bukupanduanguru.create')); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                        <form action="<?php echo e(route('bukupanduanguru.hapussemua')); ?>" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data buku panduan guru?')"
                            class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-danger" 
                                <?php echo e($userBukuCount == 0 ? 'disabled' : ''); ?>

                                <?php echo e($userBukuCount == 0 ? 'title="Tidak ada data buku untuk dihapus"' : ''); ?>>
                                <i class="fas fa-trash-alt"></i> Hapus Semua Data
                                <?php if($userBukuCount > 0): ?>
                                    <span class="badge badge-light ml-1"><?php echo e($userBukuCount); ?></span>
                                <?php endif; ?>
                            </button>
                        </form>
                    </div>

                    <table id="bukuPanduanGuruTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Penulis</th>
                                <th>Judul</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?php echo e(route('bukupanduanguru.import')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title">Import Data Buku Panduan Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control" id="file" name="file" 
                                   accept=".xlsx,.xls" required>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <a href="<?php echo e(route('bukupanduanguru.download.template')); ?>" class="alert-link">
                                Download template Excel
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Styling untuk buku yang tidak aktif */
        .row-inactive {
            position: relative;
            background: repeating-linear-gradient(
                45deg,
                #ffffff,
                #ffffff 10px,
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

        /* Pastikan kolom Aksi tetap jelas (tidak kena efek opacity) */
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
            pointer-events: none;
            z-index: 1;
            white-space: nowrap;
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#bukuPanduanGuruTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route("bukupanduanguru.index")); ?>',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error loading data:', error);
                        alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                    { data: 'kode', name: 'kode', orderable: false, width: '15%' },
                    { data: 'penulis', name: 'penulis', width: '15%' },
                    { data: 'judul', name: 'judul', width: '22%' },
                    { data: 'penerbit', name: 'penerbit', width: '12%' },
                    { data: 'tahun', name: 'tahun', width: '6%' },
                    { data: 'stok', name: 'stok', orderable: false, searchable: false, width: '6%' },
                    { data: 'status', name: 'status', orderable: false, searchable: false, width: '8%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '14%' }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                order: [[1, 'asc']],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Memproses...',
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Belum ada data buku panduan guru",
                    zeroRecords: "Data tidak ditemukan"
                },
                createdRow: function(row, data, dataIndex) {
                    // Tambahkan class row-inactive jika buku tidak aktif
                    if (!data.is_active) {
                        $(row).addClass('row-inactive');
                    }
                },
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/bukupanduanguru/index.blade.php ENDPATH**/ ?>