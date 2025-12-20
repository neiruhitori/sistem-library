<?php $__env->startSection('title', 'Detail Catatan Denda'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-info" style="font-size: 2rem">
                        <i class="fas fa-info-circle"></i> Detail Catatan Denda
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary"><i class="fas fa-home"></i> Beranda</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('catatanharian.index')); ?>">
                                <span class="badge badge-primary"><i class="fas fa-book-reader"></i> Catatan Harian</span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info"><i class="fas fa-eye"></i> Detail</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3 class="card-title"><i class="fas fa-book"></i> Detail Catatan Denda</h3>
            </div>
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
            <?php if(session('info')): ?>
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i> <?php echo e(session('info')); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success').classList.remove('show'), 4000);
                </script>
            <?php endif; ?>
            <div class="card-body">
                <h5 class="mb-3">📌 Informasi Siswa</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Nama:</strong>
                        <?php echo e($catatan->siswa->name ?? 'Siswa tidak ditemukan'); ?></li>
                    <li class="list-group-item"><strong>NISN:</strong> <?php echo e($catatan->siswa->nisn ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Kelas:</strong>
                        <?php echo e($catatan->siswa->kelas ?? 'Data siswa tidak ditemukan'); ?></li>
                </ul>

                <h5 class="mb-3">💸 Informasi Denda</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Jenis Denda:</strong> <?php echo e(ucfirst($catatan->jenis_denda)); ?></li>
                    <li class="list-group-item"><strong>Jumlah:</strong>
                        Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?></li>
                    <li class="list-group-item"><strong>Tanggal Denda:</strong>
                        <?php echo e(\Carbon\Carbon::parse($catatan->tanggal_denda)->translatedFormat('d F Y')); ?></li>
                    <li class="list-group-item"><strong>Keterangan:</strong> <?php echo e($catatan->keterangan ?? '-'); ?></li>
                    <li class="list-group-item">
                        <strong>Ditangani oleh:</strong> 
                        <?php echo e($catatan->handledByUser->name ?? 'Tidak diketahui'); ?>

                        <?php if($catatan->handledByUser && $catatan->handledByUser->nip): ?>
                            (NIP: <?php echo e($catatan->handledByUser->nip); ?>)
                        <?php endif; ?>
                    </li>
                    <?php if($catatan->status === 'dibayar'): ?>
                        <li class="list-group-item">
                            <strong>Tanggal Bayar:</strong>
                            <?php echo e(\Carbon\Carbon::parse($catatan->tanggal_bayar)->translatedFormat('d F Y')); ?>

                        </li>
                    <?php endif; ?>
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="badge badge-<?php echo e($catatan->status === 'dibayar' ? 'success' : 'danger'); ?>">
                            <?php echo e($catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar'); ?>

                        </span>
                    </li>
                </ul>
                <?php if($catatan->referensi_id && $catatan->peminjaman): ?>
                    <h4 class="mt-4">📚 Buku yang Didenda</h4>
                    <?php
                        $detail = $catatan->peminjaman->details->where('id', $catatan->referensi_id)->first();
                    ?>

                    <?php if($detail): ?>
                        <div class="card h-100 shadow-sm mb-4">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <?php if($detail->kodeBuku && $detail->kodeBuku->buku && $detail->kodeBuku->buku->foto): ?>
                                        <img src="<?php echo e(asset('storage/' . $detail->kodeBuku->buku->foto)); ?>"
                                            alt="Sampul Buku" class="img-fluid rounded-start">
                                    <?php else: ?>
                                        <img src="<?php echo e(asset('default-cover.png')); ?>" alt="No Cover"
                                            class="img-fluid rounded-start">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title mb-2">
                                            <?php echo e($detail->kodeBuku->buku->judul ?? '-'); ?>

                                        </h5>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>Kode Buku:</strong>
                                                <?php echo e($detail->kodeBuku->kode_buku ?? '-'); ?>

                                            </small>
                                        </p>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>Penulis:</strong>
                                                <?php echo e($detail->kodeBuku->buku->penulis ?? '-'); ?>

                                            </small>
                                        </p>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>Tahun Terbit:</strong>
                                                <?php echo e($detail->kodeBuku->buku->tahun_terbit ?? '-'); ?>

                                            </small>
                                        </p>

                                        <p class="card-text">
                                            <small class="text-muted">
                                                <strong>Keterangan:</strong>
                                                <?php echo e($detail->kodeBuku->buku->description ?? '-'); ?>

                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <a href="<?php echo e(route('catatanharian.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <?php if($catatan->status === 'belum_dibayar'): ?>
                            <button class="btn btn-success" data-toggle="modal" data-target="#confirmModal">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </button>
                        <?php endif; ?>
                    </div>
                    <div>
                        <a href="<?php echo e(route('catatanharian.export', $catatan->id)); ?>" target="_blank"
                            class="btn btn-primary">
                            <i class="fas fa-file-pdf"></i> Cetak PDF
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Pembayaran -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="fas fa-exclamation-circle"></i> Konfirmasi Pembayaran Cash
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin pembayaran <strong>tunai</strong> sebesar<br>
                    <span class="text-primary">Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?></span> sudah dilakukan?
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="<?php echo e(route('catatanharian.processPayment', $catatan->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Sudah Dibayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/catatanharian/show.blade.php ENDPATH**/ ?>