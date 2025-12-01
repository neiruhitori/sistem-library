<?php $__env->startSection('title', 'Pengembalian Tahunan'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Pengembalian Tahunan</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar pengembalian tahunan buku SMPN 02 Klakah
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
                                <span class="align-middle">Pengembalian Tahunan</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Pengembalian Tahunan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($detail->peminjaman->siswa->name); ?></td>
                                    <td><?php echo e($detail->kodeBuku->kode_buku ?? '-'); ?></td>
                                    <td><?php echo e($detail->kodeBuku->buku->judul ?? '-'); ?></td>
                                    <td><?php echo e($detail->peminjaman->tanggal_pinjam); ?></td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="openModalPengembalian('<?php echo e(route('pengembaliantahunan.update', $detail->id)); ?>')">
                                            <i class="fas fa-check"></i> Kembalikan
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <!-- Tambahkan di paling bawah halaman, sebelum </body> -->
                    <div class="modal fade" id="modalKondisiBuku" tabindex="-1" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" id="formPengembalian">
                                <?php echo csrf_field(); ?>
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Pengembalian Buku</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Pilih kondisi buku saat dikembalikan:</p>
                                        <select name="kondisi_buku" id="kondisiBukuSelect" class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="baik">Baik</option>
                                            <option value="terlambat">Terlambat</option>
                                            <option value="hilang">Hilang</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" id="submitPengembalian"
                                            disabled>Kembalikan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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
    <script>
        function openModalPengembalian(url) {
            const form = document.getElementById('formPengembalian');
            form.action = url;
            const modal = new bootstrap.Modal(document.getElementById('modalKondisiBuku'));
            modal.show();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('kondisiBukuSelect');
            const submitButton = document.getElementById('submitPengembalian');

            select.addEventListener('change', function() {
                if (select.value !== '') {
                    submitButton.removeAttribute('disabled');
                } else {
                    submitButton.setAttribute('disabled', true);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/pengembaliantahunan/index.blade.php ENDPATH**/ ?>