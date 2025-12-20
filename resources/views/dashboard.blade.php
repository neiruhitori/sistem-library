@extends('layouts.app')

@section('contents')
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
                            {{ \App\Models\Siswa::count() }}
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
                        <span class="info-box-number">{{ $data['totalBuku'] }}</span>
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
                        <span class="info-box-number">{{ $data['peminjamanHariIni'] }}</span>
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
                        <span class="info-box-number">{{ $data['dendaAktif'] }}</span>
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
                            @php
                                $recentActivities = collect();
                                
                                // Ambil peminjaman terbaru dari controller
                                if($recentPeminjaman && $recentPeminjaman->count() > 0) {
                                    $recentPeminjamanData = $recentPeminjaman->map(function($item) {
                                        $bukuTitles = $item->details->map(function($detail) {
                                            return $detail->kodeBuku->buku->judul ?? 'Buku tidak ditemukan';
                                        })->join(', ');
                                        
                                        // Tentukan tipe peminjaman berdasarkan class model
                                        $tipePeminjaman = class_basename($item) === 'PeminjamanHarian' ? 'Harian' : 'Tahunan';
                                        
                                        return [
                                            'type' => 'peminjaman',
                                            'icon' => 'fas fa-hand-holding',
                                            'color' => class_basename($item) === 'PeminjamanHarian' ? 'bg-success' : 'bg-primary',
                                            'title' => 'Peminjaman ' . $tipePeminjaman,
                                            'description' => $item->siswa->name . ' meminjam buku ' . $tipePeminjaman . ': ' . ($bukuTitles ?: 'Tidak ada buku'),
                                            'time' => $item->created_at->diffForHumans(),
                                            'created_at' => $item->created_at
                                        ];
                                    });
                                } else {
                                    $recentPeminjamanData = collect();
                                }
                                
                                // Ambil siswa baru dari controller (yang aman untuk di-map)
                                if($newSiswa && $newSiswa->count() > 0) {
                                    $newSiswaData = $newSiswa->map(function($item) {
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
                                } else {
                                    $newSiswaData = collect();
                                }
                                
                                $recentActivities = $recentPeminjamanData->merge($newSiswaData)
                                    ->sortByDesc('created_at')->take(5);
                            @endphp

                            @forelse($recentActivities as $activity)
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $activity['time'] }}</span>
                                    <h3 class="timeline-header">
                                        <span class="badge {{ $activity['color'] }}">
                                            <i class="{{ $activity['icon'] }}"></i>
                                        </span>
                                        {{ $activity['title'] }}
                                    </h3>
                                    <div class="timeline-body">
                                        {{ $activity['description'] }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center text-muted">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada aktivitas terbaru</p>
                                </div>
                            @endforelse
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
                                    @forelse($topBorrowers as $index => $borrower)
                                        <tr>
                                            <td>
                                                @if($index == 0)
                                                    <span class="badge badge-warning"><i class="fas fa-crown"></i> #{{ $index + 1 }}</span>
                                                @elseif($index == 1)
                                                    <span class="badge badge-secondary"><i class="fas fa-medal"></i> #{{ $index + 1 }}</span>
                                                @elseif($index == 2)
                                                    <span class="badge badge-warning"><i class="fas fa-medal"></i> #{{ $index + 1 }}</span>
                                                @else
                                                    <span class="badge badge-light">#{{ $index + 1 }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $borrower->siswa->name }}</td>
                                            <td><span class="badge badge-info">{{ $borrower->siswa->kelas }}</span></td>
                                            <td>
                                                <span class="badge badge-success">{{ $borrower->total_peminjaman }} buku</span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada data peminjaman bulan ini
                                            </td>
                                        </tr>
                                    @endforelse
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
                                <a href="{{ route('siswa.create') }}" class="btn btn-info btn-block">
                                    <i class="fas fa-user-plus"></i><br>
                                    Tambah Siswa
                                </a>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bukuModal">
                                    <i class="fas fa-book-medical"></i><br>
                                    Tambah Buku
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-warning btn-block" data-toggle="modal" data-target="#peminjamanModal">
                                    <i class="fas fa-hand-holding"></i><br>
                                    Peminjaman
                                </button>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('siswa.export.pdf') }}" class="btn btn-danger btn-block">
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
                        @forelse($overdueBooks as $overdue)
                            <div class="p-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        @php
                                            $bukuTitles = $overdue->details->map(function($detail) {
                                                return $detail->kodeBuku->buku->judul ?? 'Buku tidak ditemukan';
                                            })->join(', ');
                                        @endphp
                                        <strong>{{ $bukuTitles ?: 'Buku tidak ditemukan' }}</strong><br>
                                        <small class="text-muted">{{ $overdue->siswa->name ?? 'Siswa tidak ditemukan' }} - {{ $overdue->siswa->kelas ?? '' }}</small><br>
                                        <small class="text-danger">
                                            <i class="fas fa-clock"></i>
                                            @php
                                                $tglKembali = \Carbon\Carbon::parse($overdue->tanggal_kembali);
                                                $tglSekarang = now();
                                                $selisihHari = $tglKembali->copy()->startOfDay()->diffInDays($tglSekarang->copy()->startOfDay());
                                            @endphp
                                            (Terlambat {{ $selisihHari }} Hari)
                                        </small>
                                    </div>
                                    <span class="badge badge-danger">Overdue</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                                <p>Tidak ada buku yang terlambat!</p>
                            </div>
                        @endforelse
                    </div>
                    @if($overdueBooks->count() > 0)
                        <div class="card-footer text-center">
                            <a href="{{ route('peminjamanharian.index') }}" class="btn btn-sm btn-danger">
                                Lihat Semua Keterlambatan
                            </a>
                        </div>
                    @endif
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
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @forelse($popularBooks as $popular)
                                <li class="item">
                                    <div class="product-img">
                                        <div class="bg-primary rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-book text-white"></i>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">
                                            {{ $popular->kodeBuku->buku->judul ?? 'Buku tidak ditemukan' }}
                                            <span class="badge badge-success float-right">{{ $popular->total_peminjaman }}x</span>
                                        </a>
                                        <span class="product-description">
                                            {{ $popular->kodeBuku->buku->pengarang ?? '' }} - {{ $popular->kodeBuku->buku->penerbit ?? '' }}
                                        </span>
                                    </div>
                                </li>
                            @empty
                                <li class="item text-center text-muted py-3">
                                    <i class="fas fa-inbox fa-2x mb-2"></i>
                                    <p>Belum ada data peminjaman</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    @if($popularBooks->count() > 0)
                        <div class="card-footer text-center">
                            <a href="{{ route('buku.harian') }}" class="btn btn-sm btn-primary">Lihat Semua Buku</a>
                        </div>
                    @endif
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
                                <span class="info-box-number">{{ now()->format('d M Y') }}</span>
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
                                <span class="info-box-number">{{ Auth::user()->name }}</span>
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

<!-- Modal Tambah Buku -->
<div class="modal fade" id="bukuModal" tabindex="-1" role="dialog" aria-labelledby="bukuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bukuModalLabel">
                    <i class="fas fa-book-medical text-success mr-2"></i>
                    Pilih Jenis Buku
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Pilih jenis buku yang ingin ditambahkan:</p>
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('buku.create') }}?tipe=harian" class="btn btn-success btn-block btn-lg">
                            <i class="fas fa-calendar-day fa-2x mb-2"></i><br>
                            <strong>Buku Harian</strong><br>
                            <small>Peminjaman per hari</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('buku.create') }}?tipe=tahunan" class="btn btn-primary btn-block btn-lg">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i><br>
                            <strong>Buku Tahunan</strong><br>
                            <small>Peminjaman per tahun</small>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Peminjaman -->
<div class="modal fade" id="peminjamanModal" tabindex="-1" role="dialog" aria-labelledby="peminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="peminjamanModalLabel">
                    <i class="fas fa-hand-holding text-warning mr-2"></i>
                    Pilih Jenis Peminjaman
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-3">Pilih jenis peminjaman yang ingin dilakukan:</p>
                <div class="row">
                    <div class="col-6">
                        <a href="{{ route('peminjamanharian.create') }}" class="btn btn-warning btn-block btn-lg">
                            <i class="fas fa-calendar-day fa-2x mb-2"></i><br>
                            <strong>Peminjaman Harian</strong><br>
                            <small>Untuk peminjaman harian</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('peminjamantahunan.create') }}" class="btn btn-info btn-block btn-lg">
                            <i class="fas fa-calendar-alt fa-2x mb-2"></i><br>
                            <strong>Peminjaman Tahunan</strong><br>
                            <small>Untuk peminjaman tahunan</small>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

@php
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
@endphp

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
                    data: {!! json_encode($peminjamanHarianData) !!},
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.1
                }, {
                    label: 'Peminjaman Tahunan',
                    data: {!! json_encode($peminjamanTahunanData) !!},
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
        @if(isset($kelasStats) && count($kelasStats) > 0)
        new Chart(kelasCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode(array_keys($kelasStats)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($kelasStats)) !!},
                    backgroundColor: [
                        '#FF6384',
                        '#36A2EB', 
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                        '#FF9F40',
                        '#FF6384',
                        '#C9CBCF',
                        '#4BC0C0',
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56'
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
        @else
        // Tampilkan pesan jika tidak ada data
        kelasCtx.getContext('2d').font = '16px Arial';
        kelasCtx.getContext('2d').fillText('Belum ada data siswa', 10, 50);
        @endif
    }
});
</script>
@endsection
