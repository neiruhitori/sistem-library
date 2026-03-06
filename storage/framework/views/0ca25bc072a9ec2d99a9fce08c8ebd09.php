

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-users-cog text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">User Management</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Manajemen Pengguna Sistem
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
                                <i class="fas fa-users-cog" style="font-size:1.2rem;"></i>
                                <span class="align-middle">User Management</span>
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

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list"></i> Daftar Pengguna
                            </h3>
                        </div>
                        
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <a href="<?php echo e(route('usermanagement.create')); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah User
                        </a>
                    </div>

                    <table id="userTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="transferModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="transferModalLabel">
                        <i class="fas fa-exchange-alt"></i> Transfer Jabatan Kepala Perpustakaan
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="transferForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Perhatian!</strong>
                            <br>Transfer jabatan akan:
                            <ul class="mb-0 mt-2">
                                <li>Menurunkan jabatan <strong id="currentKepalaName"></strong> menjadi <strong>Petugas Perpustakaan</strong></li>
                                <li>Memberikan jabatan <strong>Kepala Perpustakaan</strong> kepada user yang dipilih</li>
                                <li>User baru akan memiliki akses penuh ke User Management</li>
                            </ul>
                        </div>

                        <div class="form-group">
                            <label for="new_kepala_id">Transfer Jabatan Kepala Kepada: <span class="text-danger">*</span></label>
                            <select class="form-control" id="new_kepala_id" name="new_kepala_id" required>
                                <option value="">-- Pilih User --</option>
                                <?php $__currentLoopData = $otherUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $otherUser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($otherUser->id); ?>">
                                        <?php echo e($otherUser->name); ?>

                                        <?php if($otherUser->nip): ?>
                                            (NIP: <?php echo e($otherUser->nip); ?>)
                                        <?php endif; ?>
                                        - <?php echo e($otherUser->role); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i>
                                Pilih user yang akan menjadi Kepala Perpustakaan baru
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-exchange-alt"></i> Transfer Jabatan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 6px 12px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 24px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script>
        $(function() {
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '<?php echo e(route("usermanagement.index")); ?>',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error loading data:', error);
                        alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                    { data: 'nip_display', name: 'nip', width: '12%' },
                    { data: 'name', name: 'name', width: '20%' },
                    { data: 'email', name: 'email', width: '20%' },
                    { data: 'role_display', name: 'role', width: '15%' },
                    { data: 'created_at_display', name: 'created_at', width: '13%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%' }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                order: [[4, 'desc']],
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
                    emptyTable: "Belum ada data user",
                    zeroRecords: "Data tidak ditemukan"
                },
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });

            // Initialize Select2 for transfer modal
            $('#new_kepala_id').select2({
                dropdownParent: $('#transferModal'),
                placeholder: '-- Pilih User --',
                allowClear: true,
                width: '100%'
            });
        });

        // Handle Transfer Modal - Prepare data before modal opens
        $('#transferModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var userId = button.data('user-id');
            var userName = button.data('user-name');

            var modal = $(this);
            modal.find('#currentKepalaName').text(userName);
            modal.find('#transferForm').attr('action', '/usermanagement/' + userId + '/transfer-kepala');
            modal.find('#new_kepala_id').val('').trigger('change');
        });

        // Reset modal when closed and cleanup
        $('#transferModal').on('hidden.bs.modal', function () {
            $(this).find('#new_kepala_id').val('').trigger('change');
            $(this).find('#transferForm')[0].reset();
            
            // Force remove backdrop if exists
            $('.modal-backdrop').remove();
            $('body').removeClass('modal-open').css('padding-right', '');
        });

        // Handle Transfer Form Submit
        $('#transferForm').on('submit', function(e) {
            if (!confirm('Yakin ingin mentransfer jabatan Kepala Perpustakaan? Aksi ini tidak dapat dibatalkan!')) {
                e.preventDefault();
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/usermanagement/index.blade.php ENDPATH**/ ?>