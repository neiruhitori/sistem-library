@extends('layouts.app')

@section('title', 'Detail Catatan Denda')

@section('contents')
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
                            <a href="{{ route('catatantahunan.index') }}">
                                <span class="badge badge-primary"><i class="fas fa-book-reader"></i> Catatan Tahunan</span>
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
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success').classList.remove('show'), 4000);
                </script>
            @endif
            @if (session('info'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('info') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success').classList.remove('show'), 4000);
                </script>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-error').classList.remove('show'), 6000);
                </script>
            @endif
            <div class="card-body">
                <h5 class="mb-3">📌 Informasi Siswa</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Nama:</strong>
                        {{ $catatan->siswa->name ?? 'Siswa tidak ditemukan' }}</li>
                    <li class="list-group-item"><strong>NISN:</strong> {{ $catatan->siswa->nisn ?? '-' }}</li>
                    <li class="list-group-item"><strong>Kelas:</strong>
                        {{ $catatan->siswa->kelas ?? 'Data siswa tidak ditemukan' }}</li>
                </ul>

                <h5 class="mb-3">💸 Informasi Denda</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><strong>Jenis Denda:</strong> {{ ucfirst($catatan->jenis_denda) }}</li>
                    <li class="list-group-item"><strong>Jumlah:</strong>
                        Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}</li>
                    <li class="list-group-item"><strong>Tanggal Denda:</strong>
                        {{ \Carbon\Carbon::parse($catatan->tanggal_denda)->translatedFormat('d F Y') }}</li>
                    <li class="list-group-item"><strong>Keterangan:</strong> {{ $catatan->keterangan ?? '-' }}</li>
                    <li class="list-group-item">
                        <strong>Ditangani oleh:</strong> 
                        {{ $catatan->handledByUser->name ?? 'Tidak diketahui' }}
                        @if($catatan->handledByUser && $catatan->handledByUser->nip)
                            (NIP: {{ $catatan->handledByUser->nip }})
                        @endif
                    </li>
                    @if ($catatan->status === 'dibayar')
                        <li class="list-group-item">
                            <strong>Tanggal Bayar:</strong>
                            {{ \Carbon\Carbon::parse($catatan->tanggal_bayar)->translatedFormat('d F Y') }}
                        </li>
                    @endif
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="badge badge-{{ $catatan->status === 'dibayar' ? 'success' : 'danger' }}">
                            {{ $catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar' }}
                        </span>
                    </li>
                </ul>
                @if ($catatan->referensi_id && $catatan->peminjamantahunan)
                    <h4 class="mt-4">📚 Buku yang Didenda</h4>
                    @php
                        $detail = $catatan->peminjamantahunan->details->where('id', $catatan->referensi_id)->first();
                    @endphp

                    @if ($detail)
                        <div class="card h-100 shadow-sm mb-4">
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
                                                <strong>Kode Buku:</strong>
                                                {{ $detail->kodeBuku->kode_buku ?? '-' }}
                                            </small>
                                        </p>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>Penulis:</strong>
                                                {{ $detail->kodeBuku->buku->penulis ?? '-' }}
                                            </small>
                                        </p>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>Tahun Terbit:</strong>
                                                {{ $detail->kodeBuku->buku->tahun_terbit ?? '-' }}
                                            </small>
                                        </p>

                                        <p class="card-text mb-1">
                                            <small class="text-muted">
                                                <strong>ISBN:</strong>
                                                {{ $detail->kodeBuku->buku->isbn ?? '-' }}
                                            </small>
                                        </p>

                                        <p class="card-text">
                                            <small class="text-muted">
                                                <strong>Keterangan:</strong>
                                                {{ $detail->kodeBuku->buku->description ?? '-' }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <a href="{{ route('catatantahunan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        @if ($catatan->status === 'belum_dibayar')
                            <button class="btn btn-success" data-toggle="modal" data-target="#confirmModal">
                                <i class="fas fa-credit-card"></i> Bayar Sekarang
                            </button>
                        @endif
                    </div>
                    <div>
                        <a href="{{ route('catatantahunan.export', $catatan->id) }}" target="_blank"
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
                    <span class="text-primary">Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}</span> sudah dilakukan?
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="{{ route('catatantahunan.processPayment', $catatan->id) }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Sudah Dibayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
