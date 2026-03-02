<?php $__env->startSection('title', 'Pengembalian Harian'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Pengembalian Harian</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar pengembalian harian buku SMPN 02 Klakah
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
                                <span class="align-middle">Pengembalian Harian</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Pengembalian Harian</h3>
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
                                            onclick="openModalPengembalian('<?php echo e(route('pengembalianharian.update', $detail->id)); ?>')">
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
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> <strong>Info:</strong> Sistem akan otomatis menghitung denda keterlambatan jika melewati tanggal kembali.
                                        </div>
                                        <select name="kondisi_buku" id="kondisiBukuSelect" class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="baik">Baik (Kondisi Normal)</option>
                                            <option value="rusak">Rusak (Denda Rp 10.000)</option>
                                            <option value="hilang">Hilang (Denda Rp 50.000)</option>
                                        </select>

                                        <!-- Sub-pilihan untuk jenis kerusakan -->
                                        <div id="jenisKerusakanWrapper" style="display: none; margin-top: 15px;">
                                            <label for="jenisKerusakanSelect"><strong>Pilih Jenis Kerusakan:</strong></label>
                                            <select name="jenis_kerusakan" id="jenisKerusakanSelect" class="form-control">
                                                <option value="">-- Pilih Jenis Kerusakan --</option>
                                                <option value="Corat-coret">Corat-coret</option>
                                                <option value="Sobek halaman">Sobek halaman</option>
                                                <option value="Cover rusak">Cover rusak</option>
                                                <option value="Jilid lepas">Jilid lepas</option>
                                                <option value="Basah/Terkena air">Basah/Terkena air</option>
                                                <option value="Rusak parah (tidak bisa dipinjam)">Rusak parah (tidak bisa dipinjam)</option>
                                            </select>
                                        </div>
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
            const jenisKerusakanWrapper = document.getElementById('jenisKerusakanWrapper');
            const jenisKerusakanSelect = document.getElementById('jenisKerusakanSelect');

            select.addEventListener('change', function() {
                if (select.value === 'rusak') {
                    // Tampilkan pilihan jenis kerusakan
                    jenisKerusakanWrapper.style.display = 'block';
                    jenisKerusakanSelect.required = true;
                    submitButton.setAttribute('disabled', true);
                } else {
                    // Sembunyikan pilihan jenis kerusakan
                    jenisKerusakanWrapper.style.display = 'none';
                    jenisKerusakanSelect.required = false;
                    jenisKerusakanSelect.value = '';
                    
                    if (select.value !== '') {
                        submitButton.removeAttribute('disabled');
                    } else {
                        submitButton.setAttribute('disabled', true);
                    }
                }
            });

            // Validasi untuk jenis kerusakan
            jenisKerusakanSelect.addEventListener('change', function() {
                if (jenisKerusakanSelect.value !== '' && select.value === 'rusak') {
                    submitButton.removeAttribute('disabled');
                } else {
                    submitButton.setAttribute('disabled', true);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/pengembalianharian/index.blade.php ENDPATH**/ ?>