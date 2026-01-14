@extends('layouts.app')

@section('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book{{ isset($buku) ? '-open' : '' }} text-primary"></i>
                        <span>Detail Buku</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buku.harian', ['tipe' => $tipe]) }}"><i
                                    class="fas fa-book"></i> Buku {{ ucfirst($tipe) }}</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-book"></i> Form Detail Buku</h3>
                </div>
                <form method="post" action="#" enctype="multipart/form-data" autocomplete="off">
                    <div class="card-body">
                        <input type="hidden" name="tipe" value="{{ $tipe }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    name="judul" id="judul" placeholder="Masukkan Judul Buku"
                                    value="{{ old('judul', $buku->judul ?? '') }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                    name="penulis" id="penulis" placeholder="Masukkan Nama Penulis"
                                    value="{{ old('penulis', $buku->penulis ?? '') }}" disabled>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Kode Buku</label>
                                <div id="kode-buku-container">
                                    @if (old('kode_buku'))
                                        @foreach (old('kode_buku') as $kode)
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="{{ $kode }}" placeholder="Kode Buku" disabled>
                                            </div>
                                        @endforeach
                                    @elseif(isset($buku))
                                        @foreach ($buku->kodeBuku as $kode)
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="{{ $kode->kode_buku }}" placeholder="Kode Buku" disabled>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 kode-buku-item">
                                            <input type="text" name="kode_buku[]" class="form-control"
                                                placeholder="Kode Buku" disabled>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" min="1900" max="{{ date('Y') }}"
                                    class="form-control @error('tahun_terbit') is-invalid @enderror" name="tahun_terbit"
                                    id="tahun_terbit" placeholder="Masukkan Tahun Terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="isbn" class="form-label">Kode ISBN</label>
                                <input type="text" class="form-control" name="isbn" id="isbn" 
                                    placeholder="Tidak ada kode ISBN"
                                    value="{{ old('isbn', $buku->isbn ?? '') }}" disabled>
                            </div>

                            <div class="col-md-6">
                                <label for="kota_cetak" class="form-label">Kota Cetak</label>
                                <input type="text" class="form-control" name="kota_cetak" id="kota_cetak" 
                                    placeholder="Tidak ada kota cetak"
                                    value="{{ old('kota_cetak', $buku->kota_cetak ?? '') }}" disabled>
                            </div>

                            @if($tipe == 'tahunan')
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas Buku</label>
                                <input type="text" class="form-control" name="kelas" id="kelas" 
                                    placeholder="Tidak ada kelas"
                                    value="{{ old('kelas', $buku->kelas ?? '-') }}" disabled>
                            </div>
                            @endif

                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                    rows="3" placeholder="Masukkan deskripsi buku" disabled>{{ old('description', $buku->description ?? '') }}</textarea>
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label">Foto Buku</label>
                                @if (isset($buku) && $buku->foto)
                                    <div class="mt-2">
                                        <img src="{{ str_starts_with($buku->foto, 'sampulbuku/') ? asset($buku->foto) : asset('storage/' . $buku->foto) }}" alt="Foto Buku"
                                            style="max-height: 150px;" disabled>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
