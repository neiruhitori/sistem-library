@extends('layouts.app')

@section('title', 'Detail Peminjaman Harian')

@section('contents')
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
                    <li class="list-group-item"><strong>Nama:</strong> {{ $peminjaman->siswa->name }}</li>
                    <li class="list-group-item"><strong>NISN:</strong> {{ $peminjaman->siswa->nisn ?? '-' }}</li>
                    <li class="list-group-item"><strong>Kelas:</strong> {{ $peminjaman->siswa->kelas }}</li>
                </ul>

                <h5 class="mb-3">🗓️ Informasi Peminjaman</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Tanggal Pinjam:</strong>
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->translatedFormat('d F Y') }}</li>
                    <li class="list-group-item"><strong>Tanggal Kembali:</strong>
                        {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->translatedFormat('d F Y') }}</li>
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $peminjaman->status === 'dipinjam' ? 'warning' : 'success' }}">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    </li>
                </ul>

                <h4>Detail Buku yang Dipinjam</h4>
                <div class="row">
                    @foreach ($peminjaman->details as $detail)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-4">
                                        @if ($detail->kodeBuku && $detail->kodeBuku->buku && $detail->kodeBuku->buku->foto)
                                            <img src="{{ asset('storage/' . $detail->kodeBuku->buku->foto) }}"
                                                alt="Sampul Buku" class="img-fluid rounded-start">
                                        @else
                                            <img src="{{ asset('default-cover.png') }}" alt="No Cover"
                                                class="img-fluid rounded-start">
                                        @endif
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title mb-2">
                                                {{ $detail->kodeBuku->buku->judul ?? '-' }}
                                            </h5>

                                            <p class="card-text mb-1">
                                                <small class="text-muted">
                                                    <strong>Penulis:</strong> {{ $detail->kodeBuku->buku->penulis ?? '-' }}
                                                </small>
                                            </p>

                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <strong>Tahun Terbit:</strong>
                                                    {{ $detail->kodeBuku->buku->tahun_terbit ?? '-' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        @foreach ($peminjaman->details as $index => $detail)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $detail->kodeBuku->kode_buku ?? '???' }}</td>
                                <td>{{ $detail->kodeBuku->buku->judul ?? '-' }}</td>
                                <td>
                                    <span
                                        class="badge badge-{{ $detail->status === 'dipinjam' ? 'warning' : ($detail->status === 'dikembalikan' ? 'success' : 'danger') }}">
                                        {{ ucfirst($detail->status) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $detail->tanggal_dikembalikan ? \Carbon\Carbon::parse($detail->tanggal_dikembalikan)->translatedFormat('d F Y') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    <a href="{{ route('peminjamanharian.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
