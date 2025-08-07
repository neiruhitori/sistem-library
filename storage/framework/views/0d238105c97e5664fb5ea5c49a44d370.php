<?php $__env->startSection('contents'); ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">
                    <i class="fas fa-book-open text-primary mr-2"></i>
                    Dashboard Perpustakaan
                </h1>
                <p class="text-muted">Sistem Informasi Perpustakaan SMPN 02 Klakah</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">
                        <i class="fas fa-home"></i> Dashboard
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Siswa</span>
                        <span class="info-box-number">
                            <?php echo e(\App\Models\Siswa::count()); ?>

                            <small>siswa</small>
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1">
                        <i class="fas fa-book"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Buku</span>
                        <span class="info-box-number"><?php echo e(\App\Models\Buku::count()); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1">
                        <i class="fas fa-hand-holding"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Peminjaman Hari Ini</span>
                        <span class="info-box-number"><?php echo e(\App\Models\PeminjamanHarianDetail::whereDate('created_at', today())->count()); ?></span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1">
                        <i class="fas fa-exclamation-triangle"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Denda Aktif</span>
                        <span class="info-box-number"><?php echo e(\App\Models\CatatanDenda::where('status', 'belum_lunas')->count()); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Statistik Peminjaman Bulanan
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="peminjamanChart" height="180" style="height: 180px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-pie mr-1"></i>
                            Distribusi Kelas
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="kelasChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <!-- RECENT ACTIVITIES -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-clock mr-1"></i>
                            Aktivitas Terbaru
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <?php
                                $recentActivities = collect();
                                
                                // Ambil peminjaman terbaru
                                $recentPeminjaman = \App\Models\PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku'])
                                    ->latest()
                                    ->take(3)
                                    ->get()
                                    ->map(function($item) {
                                        $bukuTitles = $item->details->map(function($detail) {
                                            return $detail->kodeBuku->buku->judul ?? 'Buku tidak ditemukan';
                                        })->join(', ');
                                        
                                        return [
                                            'type' => 'peminjaman',
                                            'icon' => 'fas fa-hand-holding',
                                            'color' => 'bg-success',
                                            'title' => 'Peminjaman Buku',
                                            'description' => $item->siswa->name . ' meminjam buku: ' . ($bukuTitles ?: 'Tidak ada buku'),
                                            'time' => $item->created_at->diffForHumans(),
                                            'created_at' => $item->created_at
                                        ];
                                    });
                                
                                // Ambil siswa baru
                                $newSiswa = \App\Models\Siswa::latest()
                                    ->take(2)
                                    ->get()
                                    ->map(function($item) {
                                        return [
                                            'type' => 'siswa',
                                            'icon' => 'fas fa-user-plus',
                                            'color' => 'bg-info',
                                            'title' => 'Siswa Baru Terdaftar',
                                            'description' => $item->name . ' dari kelas ' . $item->kelas,
                                            'time' => $item->created_at->diffForHumans(),
                                            'created_at' => $item->created_at
                                        ];
                                    });
                                
                                $recentActivities = $recentPeminjaman->merge($newSiswa)
                                    ->sortByDesc('created_at')
                                    ->take(5);
                            ?>

                            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> <?php echo e($activity['time']); ?></span>
                                    <h3 class="timeline-header">
                                        <span class="badge <?php echo e($activity['color']); ?>">
                                            <i class="<?php echo e($activity['icon']); ?>"></i>
                                        </span>
                                        <?php echo e($activity['title']); ?>

                                    </h3>
                                    <div class="timeline-body">
                                        <?php echo e($activity['description']); ?>

                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada aktivitas terbaru</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- TOP BORROWERS -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-trophy mr-1"></i>
                            Peminjam Terbanyak Bulan Ini
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0">
                                <thead>
                                    <tr>
                                        <th>Ranking</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Peminjaman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $topBorrowers = \App\Models\PeminjamanHarian::with('siswa')
                                            ->whereMonth('created_at', now()->month)
                                            ->whereYear('created_at', now()->year)
                                            ->selectRaw('siswas_id, COUNT(*) as total_peminjaman')
                                            ->groupBy('siswas_id')
                                            ->orderByDesc('total_peminjaman')
                                            ->limit(5)
                                            ->get();
                                    ?>
                                    
                                    <?php $__empty_1 = true; $__currentLoopData = $topBorrowers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $borrower): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td>
                                                <?php if($index == 0): ?>
                                                    <span class="badge badge-warning"><i class="fas fa-crown"></i> #<?php echo e($index + 1); ?></span>
                                                <?php elseif($index == 1): ?>
                                                    <span class="badge badge-secondary"><i class="fas fa-medal"></i> #<?php echo e($index + 1); ?></span>
                                                <?php elseif($index == 2): ?>
                                                    <span class="badge badge-warning"><i class="fas fa-medal"></i> #<?php echo e($index + 1); ?></span>
                                                <?php else: ?>
                                                    <span class="badge badge-light">#<?php echo e($index + 1); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($borrower->siswa->name); ?></td>
                                            <td><span class="badge badge-info"><?php echo e($borrower->siswa->kelas); ?></span></td>
                                            <td>
                                                <span class="badge badge-success"><?php echo e($borrower->total_peminjaman); ?> buku</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada data peminjaman bulan ini
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <!-- QUICK ACTIONS -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt mr-1"></i>
                            Aksi Cepat
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <a href="<?php echo e(route('siswa.create')); ?>" class="btn btn-info btn-block">
                                    <i class="fas fa-user-plus"></i><br>
                                    Tambah Siswa
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo e(route('buku.create')); ?>" class="btn btn-success btn-block">
                                    <i class="fas fa-book-medical"></i><br>
                                    Tambah Buku
                                </a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <a href="<?php echo e(route('peminjamanharian.create')); ?>" class="btn btn-warning btn-block">
                                    <i class="fas fa-hand-holding"></i><br>
                                    Peminjaman
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="<?php echo e(route('siswa.export.pdf')); ?>" class="btn btn-danger btn-block">
                                    <i class="fas fa-file-pdf"></i><br>
                                    Export PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OVERDUE BOOKS -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            Buku Terlambat
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php
                            $overdueBooks = \App\Models\PeminjamanHarian::with(['siswa', 'details.kodeBuku.buku'])
                                ->whereDate('tanggal_kembali', '<', now())
                                ->where('status', 'dipinjam')
                                ->limit(5)
                                ->get();
                        ?>

                        <?php $__empty_1 = true; $__currentLoopData = $overdueBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $overdue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <?php
                                            $bukuTitles = $overdue->details->map(function($detail) {
                                                return $detail->kodeBuku->buku->judul ?? 'Buku tidak ditemukan';
                                            })->join(', ');
                                        ?>
                                        <strong><?php echo e($bukuTitles ?: 'Buku tidak ditemukan'); ?></strong><br>
                                        <small class="text-muted"><?php echo e($overdue->siswa->name ?? 'Siswa tidak ditemukan'); ?> - <?php echo e($overdue->siswa->kelas ?? ''); ?></small><br>
                                        <small class="text-danger">
                                            <i class="fas fa-clock"></i>
                                            Terlambat <?php echo e(now()->diffInDays($overdue->tanggal_kembali)); ?> hari
                                        </small>
                                    </div>
                                    <span class="badge badge-danger">Overdue</span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                                <p>Tidak ada buku yang terlambat!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if($overdueBooks->count() > 0): ?>
                        <div class="card-footer text-center">
                            <a href="<?php echo e(route('peminjamanharian.index')); ?>" class="btn btn-sm btn-danger">
                                Lihat Semua Keterlambatan
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- POPULAR BOOKS -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-fire mr-1"></i>
                            Buku Populer
                        </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <?php
                            $popularBooks = \App\Models\PeminjamanHarianDetail::with('kodeBuku.buku')
                                ->selectRaw('kode_bukus_id, COUNT(*) as total_peminjaman')
                                ->groupBy('kode_bukus_id')
                                ->orderByDesc('total_peminjaman')
                                ->limit(5)
                                ->get();
                        ?>

                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            <?php $__empty_1 = true; $__currentLoopData = $popularBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $popular): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <li class="item">
                                    <div class="product-img">
                                        <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-book text-white"></i>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">
                                            <?php echo e($popular->kodeBuku->buku->judul ?? 'Buku tidak ditemukan'); ?>

                                            <span class="badge badge-success float-right"><?php echo e($popular->total_peminjaman); ?>x</span>
                                        </a>
                                        <span class="product-description">
                                            <?php echo e($popular->kodeBuku->buku->pengarang ?? ''); ?> - <?php echo e($popular->kodeBuku->buku->penerbit ?? ''); ?>

                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <li class="item text-center text-muted py-3">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada data peminjaman</p>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <?php if($popularBooks->count() > 0): ?>
                        <div class="card-footer text-center">
                            <a href="<?php echo e(route('buku.harian')); ?>" class="btn btn-sm btn-primary">Lihat Semua Buku</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- SYSTEM INFO -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-info-circle mr-1"></i>
                            Informasi Sistem
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fas fa-calendar"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Hari Ini</span>
                                <span class="info-box-number"><?php echo e(now()->format('d M Y')); ?></span>
                            </div>
                        </div>
                        
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-server"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Status Server</span>
                                <span class="info-box-number text-success">Online</span>
                            </div>
                        </div>

                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fas fa-user-shield"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Login Sebagai</span>
                                <span class="info-box-number"><?php echo e(Auth::user()->name); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!--/. container-fluid -->
</section>

<?php
    // Prepare data for charts
    $peminjamanHarianData = [];
    $peminjamanTahunanData = [];
    
    for ($month = 1; $month <= 12; $month++) {
        $peminjamanHarianData[] = \App\Models\PeminjamanHarianDetail::whereMonth('created_at', $month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $peminjamanTahunanData[] = \App\Models\PeminjamanTahunanDetail::whereMonth('created_at', $month)
            ->whereYear('created_at', now()->year)
            ->count();
    }
    
    $kelasStats = \App\Models\Siswa::selectRaw('kelas, COUNT(*) as total')
        ->groupBy('kelas')
        ->pluck('total', 'kelas')
        ->toArray();
?>

<script>
// Chart untuk peminjaman bulanan
document.addEventListener('DOMContentLoaded', function() {
    // Peminjaman Chart
    const peminjamanCtx = document.getElementById('peminjamanChart');
    if (peminjamanCtx) {
        new Chart(peminjamanCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Peminjaman Harian',
                    data: <?php echo json_encode($peminjamanHarianData); ?>,
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Peminjaman Tahunan',
                    data: <?php echo json_encode($peminjamanTahunanData); ?>,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.1)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Kelas Chart
    const kelasCtx = document.getElementById('kelasChart');
    if (kelasCtx) {
        new Chart(kelasCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($kelasStats)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($kelasStats)); ?>,
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/dashboard.blade.php ENDPATH**/ ?>