<?php $__env->startSection('title', 'Detail Peminjaman Harian'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary" style="font-size: 2rem">
                        <i class="fas fa-book-reader"></i>
                        Deatil Peminjaman Harian
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><span class="badge badge-primary"><i
                                        class="fas fa-home"></i> Beranda</span></a></li>
                        <li class="breadcrumb-item"><a href="/peminjamanharian"><span class="badge badge-primary"><i
                                        class="fas fa-book-reader"></i> Peminjaman Harian</span></a></li>
                        <li class="breadcrumb-item active"><span class="badge badge-info"><i class="fas fa-plus"></i>
                                Detail</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h3 class="card-title"><i class="fas fa-book-reader"></i> Detail Peminjaman Harian</h3>
            </div>
            <div class="card-body">
                <h5 class="mb-3">📌 Informasi Siswa</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Nama:</strong> <?php echo e($peminjaman->siswa->name); ?></li>
                    <li class="list-group-item"><strong>NISN:</strong> <?php echo e($peminjaman->siswa->nisn ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Kelas:</strong> <?php echo e($peminjaman->siswa->kelas); ?></li>
                    <li class="list-group-item"><strong>Absen:</strong> <?php echo e($peminjaman->siswa->absen ?? '-'); ?></li>
                    <li class="list-group-item"><strong>Jenis Kelamin:</strong> <?php echo e($peminjaman->siswa->jenis_kelamin == 'L' ? 'Laki-laki' : ($peminjaman->siswa->jenis_kelamin == 'P' ? 'Perempuan' : '-')); ?></li>
                    <li class="list-group-item"><strong>Agama:</strong> <?php echo e($peminjaman->siswa->agama ?? '-'); ?></li>
                </ul>

                <h5 class="mb-3">🗓️ Informasi Peminjaman</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Tanggal Pinjam:</strong>
                        <?php echo e(\Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y')); ?></li>
                    <li class="list-group-item"><strong>Tanggal Kembali:</strong>
                        <?php echo e(\Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d F Y')); ?></li>
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="badge badge-<?php echo e($peminjaman->status === 'dipinjam' ? 'warning' : 'success'); ?>">
                            <?php echo e(ucfirst($peminjaman->status)); ?>

                        </span>
                    </li>
                </ul>

                <h4>Detail Buku yang Dipinjam</h4>
                <div class="row">
                    <?php $__currentLoopData = $peminjaman->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        <?php if($detail->kodeBuku && $detail->kodeBuku->buku && $detail->kodeBuku->buku->foto): ?>
                                            <?php
                                                $fotoPath = $detail->kodeBuku->buku->foto;
                                                // Jika path sudah include 'sampulbuku/', gunakan langsung dengan asset()
                                                // Jika tidak, tambahkan 'sampulbuku/' prefix
                                                if (str_starts_with($fotoPath, 'sampulbuku/')) {
                                                    $fotoUrl = asset($fotoPath);
                                                } else {
                                                    $fotoUrl = asset('sampulbuku/' . $fotoPath);
                                                }
                                            ?>
                                            <img src="<?php echo e($fotoUrl); ?>"
                                                alt="Sampul Buku" class="img-fluid rounded-start">
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center bg-secondary rounded-start" style="height: 100%; min-height: 200px;">
                                                <i class="fas fa-book" style="font-size: 3rem; color: #fff;"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title mb-2">
                                                <?php echo e($detail->kodeBuku->buku->judul ?? '-'); ?>

                                            </h5>

                                            <p class="card-text mb-1">
                                                <small class="text-muted">
                                                    <strong>Penulis:</strong> <?php echo e($detail->kodeBuku->buku->penulis ?? '-'); ?>

                                                </small>
                                            </p>

                                            <p class="card-text">
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
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>


                <h5 class="mb-3">📚 Daftar Buku yang Dipinjam</h5>
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Status</th>
                            <th>Tanggal Dikembalikan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $peminjaman->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($detail->kodeBuku->kode_buku ?? '???'); ?></td>
                                <td><?php echo e($detail->kodeBuku->buku->judul ?? '-'); ?></td>
                                <td>
                                    <span
                                        class="badge badge-<?php echo e($detail->status === 'dipinjam' ? 'warning' : ($detail->status === 'dikembalikan' ? 'success' : 'danger')); ?>">
                                        <?php echo e(ucfirst($detail->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php echo e($detail->tanggal_dikembalikan ? \Carbon\Carbon::parse($detail->tanggal_dikembalikan)->translatedFormat('d F Y') : '-'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="<?php echo e(route('peminjamanharian.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/peminjamanharian/show.blade.php ENDPATH**/ ?>