

<?php $__env->startSection('title', 'Data Siswa'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-users text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Siswa</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar seluruh siswa SMPN 02 Klakah
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
                                <i class="fas fa-users" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Siswa</span>
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
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            
            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-error');
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            <div class="card mx-auto mt-3 shadow" style="max-width: 98%;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data Siswa Per Periode</h3>
                </div>
                <div class="card-body">
                    
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form action="<?php echo e(route('siswa.index')); ?>" method="GET" id="filterForm">
                                <div class="form-group">
                                    <label for="periode_id">
                                        <i class="fas fa-filter"></i> Filter Periode Tahun Ajaran:
                                    </label>
                                    <select name="periode_id" id="periode_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">-- Pilih Periode --</option>
                                        <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($periode->id); ?>" 
                                                <?php echo e($selectedPeriode == $periode->id ? 'selected' : ''); ?>>
                                                <?php echo e($periode->nama_lengkap); ?>

                                                <?php if($periode->is_active): ?>
                                                    <span class="badge badge-success">(Aktif)</span>
                                                <?php endif; ?>
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <a href="<?php echo e(route('siswa.create')); ?>" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                        
                        <?php if($selectedPeriode): ?>
                            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                                <i class="fas fa-sync-alt"></i> Update Status Siswa
                            </button>
                        <?php endif; ?>
                        
                        <!-- Button Import Excel -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>

                        <!-- Modal Import -->
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="importModalLabel">
                                            <i class="fas fa-file-excel"></i> Import Data Siswa
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> 
                                            <strong>Petunjuk:</strong>
                                            <ul class="mb-0">
                                                <li>Pilih periode tahun ajaran tujuan import</li>
                                                <li>Download template Excel terlebih dahulu</li>
                                                <li>Isi data siswa sesuai format</li>
                                                <li>Upload kembali file yang sudah diisi</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <a href="<?php echo e(route('siswa.download.template')); ?>" class="btn btn-success btn-block">
                                                <i class="fas fa-download"></i> Download Template Excel
                                            </a>
                                        </div>
                                        
                                        <form action="<?php echo e(route('siswa.import')); ?>" method="POST"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            
                                            <div class="form-group">
                                                <label for="import_periode_id">
                                                    Periode Tahun Ajaran <span class="text-danger">*</span>
                                                </label>
                                                <select name="periode_id" id="import_periode_id" class="form-control" required>
                                                    <option value="">-- Pilih Periode --</option>
                                                    <?php $__currentLoopData = $periodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $periode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($periode->id); ?>" 
                                                            <?php echo e($periode->is_active ? 'selected' : ''); ?>>
                                                            <?php echo e($periode->nama_lengkap); ?>

                                                            <?php if($periode->is_active): ?>
                                                                (Aktif)
                                                            <?php endif; ?>
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <small class="form-text text-muted">
                                                    Data siswa akan diimport ke periode yang dipilih
                                                </small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="file">Pilih File Excel (.xls / .xlsx) <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="file" id="file"
                                                    accept=".xlsx,.xls" required>
                                            </div>
                                            
                                            <div class="modal-footer mt-3">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-upload"></i> Import
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <?php if($selectedPeriode): ?>
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Absen</th>
                                    <th>L/P</th>
                                    <th>Agama</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $siswaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $siswaPeriode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($siswaPeriode->siswa->nisn); ?></td>
                                        <td><?php echo e($siswaPeriode->siswa->name); ?></td>
                                        <td>
                                            <?php
                                                $kelas = strtoupper($siswaPeriode->kelas);
                                            ?>
                                            <?php if(Str::startsWith($kelas, '7')): ?>
                                                <span class="badge badge-success" style="font-size:1rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                            <?php elseif(Str::startsWith($kelas, '8')): ?>
                                                <span class="badge badge-warning" style="font-size:1rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                            <?php elseif(Str::startsWith($kelas, '9')): ?>
                                                <span class="badge badge-danger" style="font-size:1rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary" style="font-size:1rem;"><?php echo e($siswaPeriode->kelas); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($siswaPeriode->absen ?: '-'); ?></td>
                                        <td><?php echo e($siswaPeriode->siswa->jenis_kelamin ?: '-'); ?></td>
                                        <td><?php echo e($siswaPeriode->siswa->agama ?: '-'); ?></td>
                                        <td>
                                            <?php if($siswaPeriode->status == 'Aktif'): ?>
                                                <span class="badge badge-success"><?php echo e($siswaPeriode->status); ?></span>
                                            <?php elseif($siswaPeriode->status == 'Lulus'): ?>
                                                <span class="badge badge-info"><?php echo e($siswaPeriode->status); ?></span>
                                            <?php elseif($siswaPeriode->status == 'Pindah'): ?>
                                                <span class="badge badge-warning"><?php echo e($siswaPeriode->status); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge-secondary"><?php echo e($siswaPeriode->status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('siswa.show', $siswaPeriode->siswa->id)); ?>?periode_id=<?php echo e($selectedPeriode); ?>" 
                                                   class="btn btn-sm btn-secondary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('siswa.edit', $siswaPeriode->siswa->id)); ?>?periode_id=<?php echo e($selectedPeriode); ?>" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if(!empty($siswaPeriode->siswa->nisn)): ?>
                                                    <a href="<?php echo e(route('siswa.print.card', $siswaPeriode->siswa->id)); ?>" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Print Card PDF">
                                                        <i class="fas fa-id-card"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <form action="<?php echo e(route('siswa.destroy', $siswaPeriode->siswa->id)); ?>" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah kamu yakin ingin hapus?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button class="btn btn-sm btn-danger" title="Hapus Data">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada data siswa pada periode ini</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <p class="mb-0">Silakan pilih periode tahun ajaran terlebih dahulu untuk melihat data siswa</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php if($selectedPeriode): ?>
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="fas fa-sync-alt"></i> Update Status Siswa - 
                        <?php
                            $periodeObj = $periodes->where('id', $selectedPeriode)->first();
                        ?>
                        <?php echo e($periodeObj ? $periodeObj->nama_lengkap : ''); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bulkUpdateForm">
                        <?php echo csrf_field(); ?>
                        
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="filterKelas">
                                    <i class="fas fa-filter"></i> Filter Kelas:
                                </label>
                                <select id="filterKelas" class="form-control">
                                    <option value="">-- Semua Kelas --</option>
                                    <?php
                                        $kelasOptions = $siswaData->pluck('kelas')->unique()->sort();
                                    ?>
                                    <?php $__currentLoopData = $kelasOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kelas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($kelas); ?>"><?php echo e($kelas); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="newStatus">
                                    <i class="fas fa-tag"></i> Status Baru: <span class="text-danger">*</span>
                                </label>
                                <select id="newStatus" name="status" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Pindah">Pindah</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end gap-2">
                                <button type="button" id="selectAllModal" class="btn btn-secondary">
                                    <i class="fas fa-check-square"></i> Pilih Semua
                                </button>
                                <button type="button" id="unselectAllModal" class="btn btn-secondary">
                                    <i class="fas fa-square"></i> Batal Pilih
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Informasi:</strong> Centang siswa yang ingin diubah statusnya, pilih status baru, lalu klik "Update Status"
                        </div>

                        
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-bordered table-sm table-hover" id="modalSiswaTable">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="checkAllModal">
                                        </th>
                                        <th>No</th>
                                        <th>NISN</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Status Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $siswaData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $siswaPeriode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="siswa-row" data-kelas="<?php echo e($siswaPeriode->kelas); ?>">
                                            <td class="text-center">
                                                <input type="checkbox" name="siswa_periode_ids[]" 
                                                       value="<?php echo e($siswaPeriode->id); ?>" 
                                                       class="siswa-checkbox-modal">
                                            </td>
                                            <td><?php echo e($index + 1); ?></td>
                                            <td><?php echo e($siswaPeriode->siswa->nisn); ?></td>
                                            <td><?php echo e($siswaPeriode->siswa->name); ?></td>
                                            <td>
                                                <span class="badge badge-info"><?php echo e($siswaPeriode->kelas); ?></span>
                                            </td>
                                            <td>
                                                <?php if($siswaPeriode->status == 'Aktif'): ?>
                                                    <span class="badge badge-success"><?php echo e($siswaPeriode->status); ?></span>
                                                <?php elseif($siswaPeriode->status == 'Lulus'): ?>
                                                    <span class="badge badge-info"><?php echo e($siswaPeriode->status); ?></span>
                                                <?php elseif($siswaPeriode->status == 'Pindah'): ?>
                                                    <span class="badge badge-warning"><?php echo e($siswaPeriode->status); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary"><?php echo e($siswaPeriode->status); ?></span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <span id="selectedCountModal" class="badge badge-primary" style="font-size: 1rem;">
                                0 siswa dipilih
                            </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="button" id="submitBulkUpdate" class="btn btn-warning" disabled>
                        <i class="fas fa-sync-alt"></i> Update Status
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

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
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir", 
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                },
                "buttons": [
                    {
                        extend: 'print',
                        text: 'Print',
                        title: '',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function(win) {
                            $(win.document.body).prepend(`
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                    <img src="<?php echo e(asset('AdminLTE-3.2.0/dist/img/smp2.png')); ?>" style="height:90px;">
                                    <div style="text-align:center;flex:1;">
                                        <div style="font-size:18px;font-weight:bold;">PEMERINTAH KABUPATEN LUMAJANG<br>DINAS PENDIDIKAN</div>
                                        <div style="font-size:22px;font-weight:bold;">SMP NEGERI 02 KLAKAH</div>
                                        <div style="font-size:14px;">Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356</div>
                                    </div>
                                    <img src="<?php echo e(asset('AdminLTE-3.2.0/dist/img/lumajang.png')); ?>" style="height:90px;">
                                </div>
                                <hr>
                                <h3 class="text-center" style="margin-top:10px;">Daftar Siswa SMPN 02 Klakah</h3>
                            `);

                            $(win.document.body).append(`
                                <div style="width:100%;margin-top:40px;display:flex;justify-content:flex-end;">
                                    <div style="text-align:center;">
                                        <div>Kepala Perpustakaan<br>SMPN 02 Klakah</div>
                                        <br><br><br>
                                        <div style="font-weight:bold;text-decoration:underline;"><?php echo e(auth()->user()->name); ?></div>
                                        <div>NIP. <?php echo e(auth()->user()->nip); ?></div>
                                    </div>
                                </div>
                            `);

                            $(win.document.body).find('table')
                                .addClass('display')
                                .css('font-size', '14px');
                        }
                    },
                    {
                        text: 'PDF',
                        action: function(e, dt, node, config) {
                            var periodeId = $('#periode_id').val();
                            var url = '<?php echo e(route("siswa.export.pdf")); ?>';
                            if (periodeId) {
                                url += '?periode_id=' + periodeId;
                            }
                            window.open(url, '_blank');
                        },
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        title: 'Daftar Siswa SMPN 02 Klakah',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });

        // Modal Update Status Script
        const filterKelas = document.getElementById('filterKelas');
        const siswaRows = document.querySelectorAll('.siswa-row');
        const checkboxesModal = document.querySelectorAll('.siswa-checkbox-modal');
        const checkAllModal = document.getElementById('checkAllModal');
        const selectAllModalBtn = document.getElementById('selectAllModal');
        const unselectAllModalBtn = document.getElementById('unselectAllModal');
        const selectedCountModal = document.getElementById('selectedCountModal');
        const submitBulkUpdate = document.getElementById('submitBulkUpdate');
        const newStatusSelect = document.getElementById('newStatus');

        // Filter by kelas
        if (filterKelas) {
            filterKelas.addEventListener('change', function() {
                const selectedKelas = this.value;
                siswaRows.forEach(row => {
                    if (selectedKelas === '' || row.dataset.kelas === selectedKelas) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                        row.querySelector('.siswa-checkbox-modal').checked = false;
                    }
                });
                updateSelectedCountModal();
            });
        }

        function updateSelectedCountModal() {
            const checked = document.querySelectorAll('.siswa-checkbox-modal:checked').length;
            selectedCountModal.textContent = checked + ' siswa dipilih';
            submitBulkUpdate.disabled = checked === 0;
        }

        if (checkAllModal) {
            checkAllModal.addEventListener('change', function() {
                checkboxesModal.forEach(cb => {
                    if (cb.closest('.siswa-row').style.display !== 'none') {
                        cb.checked = this.checked;
                    }
                });
                updateSelectedCountModal();
            });
        }

        if (selectAllModalBtn) {
            selectAllModalBtn.addEventListener('click', function() {
                checkboxesModal.forEach(cb => {
                    if (cb.closest('.siswa-row').style.display !== 'none') {
                        cb.checked = true;
                    }
                });
                checkAllModal.checked = true;
                updateSelectedCountModal();
            });
        }

        if (unselectAllModalBtn) {
            unselectAllModalBtn.addEventListener('click', function() {
                checkboxesModal.forEach(cb => cb.checked = false);
                checkAllModal.checked = false;
                updateSelectedCountModal();
            });
        }

        checkboxesModal.forEach(cb => {
            cb.addEventListener('change', updateSelectedCountModal);
        });

        // Submit bulk update
        if (submitBulkUpdate) {
            submitBulkUpdate.addEventListener('click', function() {
                const checkedIds = Array.from(document.querySelectorAll('.siswa-checkbox-modal:checked'))
                    .map(cb => cb.value);
                const status = newStatusSelect.value;

                if (checkedIds.length === 0) {
                    alert('Silakan pilih minimal 1 siswa');
                    return;
                }

                if (!status) {
                    alert('Silakan pilih status baru');
                    return;
                }

                if (!confirm(`Yakin ingin mengubah status ${checkedIds.length} siswa menjadi "${status}"?`)) {
                    return;
                }

                // Show loading
                submitBulkUpdate.disabled = true;
                submitBulkUpdate.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                // Send AJAX request
                fetch('<?php echo e(route("siswa.bulk.update.status")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({
                        siswa_periode_ids: checkedIds,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Gagal: ' + data.message);
                        submitBulkUpdate.disabled = false;
                        submitBulkUpdate.innerHTML = '<i class="fas fa-sync-alt"></i> Update Status';
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error);
                    submitBulkUpdate.disabled = false;
                    submitBulkUpdate.innerHTML = '<i class="fas fa-sync-alt"></i> Update Status';
                });
            });
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/siswa/index.blade.php ENDPATH**/ ?>