@extends('layouts.app')

@section('contents')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Detail Siswa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item">Kelas</li>
                    <li class="breadcrumb-item"><a href="{{ route('kelas.index', $kelas) }}">{{ $namaKelas }}</a></li>
                    <li class="breadcrumb-item active">{{ $siswa->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Profil Siswa -->
        <div class="row">
            <div class="col-md-4">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <div class="profile-user-img img-fluid img-circle mx-auto d-block" style="width: 100px; height: 100px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 32px; margin-bottom: 15px;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>

                        <h3 class="profile-username text-center">{{ $siswa->name }}</h3>

                        <p class="text-muted text-center">
                            <span class="badge badge-primary">{{ $siswa->nisn ?? 'N/A' }}</span>
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Kelas</b> 
                                <span class="float-right">{{ $siswa->kelas }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>NISN</b> 
                                <span class="float-right">{{ $siswa->nisn ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Terdaftar</b> 
                                <span class="float-right">{{ $siswa->created_at->format('d F Y') }}</span>
                            </li>
                        </ul>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('kelas.index', $kelas) }}" class="btn btn-secondary btn-block">
                                    <i class="fas fa-arrow-left mr-1"></i>
                                    Kembali
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('kelas.cetak-detail-pdf', [$kelas, $siswa->id]) }}" class="btn btn-danger btn-block" target="_blank">
                                    <i class="fas fa-file-pdf mr-1"></i>
                                    Cetak PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Riwayat Peminjaman -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-2"></i>
                            Riwayat Peminjaman
                        </h3>
                    </div>
                    
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="peminjamanTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="harian-tab" data-toggle="tab" href="#harian" role="tab" aria-controls="harian" aria-selected="true">
                                    <i class="fas fa-calendar-day mr-1"></i>
                                    Peminjaman Harian
                                    <span class="badge badge-primary ml-1">{{ $peminjamanHarian->sum(function($p) { return $p->details->count(); }) }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tahunan-tab" data-toggle="tab" href="#tahunan" role="tab" aria-controls="tahunan" aria-selected="false">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Peminjaman Tahunan
                                    <span class="badge badge-info ml-1">{{ $peminjamanTahunan->sum(function($p) { return $p->details->count(); }) }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="denda-tab" data-toggle="tab" href="#denda" role="tab" aria-controls="denda" aria-selected="false">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Aktivitas Denda
                                    <span class="badge badge-warning ml-1">{{ $catatanDenda->count() }}</span>
                                </a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content" id="peminjamanTabsContent">
                            <!-- Peminjaman Harian -->
                            <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
                                <div class="mt-3">
                                    @if($peminjamanHarian->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Buku</th>
                                                        <th>Kode Buku</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($peminjamanHarian as $ph)
                                                        @foreach($ph->details as $detail)
                                                        <tr>
                                                            <td>
                                                                <small>
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ $ph->created_at->format('d/m/Y H:i') }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $detail->kodeBuku->buku->judul ?? 'N/A' }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $detail->kodeBuku->buku->penulis ?? 'N/A' }}</small>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-secondary">{{ $detail->kodeBuku->kode_buku ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                @if($ph->status == 'dipinjam')
                                                                    <span class="badge badge-warning">Dipinjam</span>
                                                                @elseif($ph->status == 'selesai')
                                                                    <span class="badge badge-success">Selesai</span>
                                                                @else
                                                                    <span class="badge badge-secondary">{{ ucfirst($ph->status) }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-book fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">Belum ada riwayat peminjaman harian</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Peminjaman Tahunan -->
                            <div class="tab-pane fade" id="tahunan" role="tabpanel" aria-labelledby="tahunan-tab">
                                <div class="mt-3">
                                    @if($peminjamanTahunan->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Buku</th>
                                                        <th>Kode Buku</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($peminjamanTahunan as $pt)
                                                        @foreach($pt->details as $detail)
                                                        <tr>
                                                            <td>
                                                                <small>
                                                                    <i class="fas fa-calendar mr-1"></i>
                                                                    {{ $pt->created_at->format('d/m/Y H:i') }}
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <strong>{{ $detail->kodeBuku->buku->judul ?? 'N/A' }}</strong>
                                                                <br>
                                                                <small class="text-muted">{{ $detail->kodeBuku->buku->penulis ?? 'N/A' }}</small>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-secondary">{{ $detail->kodeBuku->kode_buku ?? 'N/A' }}</span>
                                                            </td>
                                                            <td>
                                                                @if($pt->status == 'dipinjam')
                                                                    <span class="badge badge-warning">Dipinjam</span>
                                                                @elseif($pt->status == 'selesai')
                                                                    <span class="badge badge-success">Selesai</span>
                                                                @else
                                                                    <span class="badge badge-secondary">{{ ucfirst($pt->status) }}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-book fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">Belum ada riwayat peminjaman tahunan</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Aktivitas Denda -->
                            <div class="tab-pane fade" id="denda" role="tabpanel" aria-labelledby="denda-tab">
                                <div class="mt-3">
                                    @if($catatanDenda->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-sm table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Jumlah Denda</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($catatanDenda as $denda)
                                                    <tr>
                                                        <td>
                                                            <small>
                                                                <i class="fas fa-calendar mr-1"></i>
                                                                {{ $denda->created_at->format('d/m/Y H:i') }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <strong>{{ $denda->keterangan ?? 'Denda keterlambatan' }}</strong>
                                                            <br>
                                                            <small class="text-muted">{{ $denda->keterangan_detail ?? 'Pengembalian terlambat' }}</small>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-danger">Rp {{ number_format($denda->jumlah ?? 0, 0, ',', '.') }}</span>
                                                        </td>
                                                        <td>
                                                            @if($denda->status == 'dibayar')
                                                                <span class="badge badge-success">Lunas</span>
                                                            @else
                                                                <span class="badge badge-warning">Belum Lunas</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                            <p class="text-muted">Tidak ada aktivitas denda</p>
                                            <small class="text-success">Siswa ini tidak memiliki catatan denda</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<style>
.profile-user-img {
    border-radius: 50%;
}

.card {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
}

.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
}

.nav-tabs .nav-link.active {
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
}

.table th {
    border-top: none;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}
</style>
@endpush
@endsection
