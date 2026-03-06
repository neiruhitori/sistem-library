@extends('layouts.app')

@section('title', 'Tambah Penerimaan Barang')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Tambah Penerimaan Barang</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home"></i> Beranda
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('penerimaanbarang.index') }}">
                                <span class="badge badge-info" style="font-size:1.1rem;">
                                    <i class="fas fa-box"></i> Penerimaan Barang
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-secondary" style="font-size:1.1rem;">
                                <i class="fas fa-plus"></i> Tambah
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-edit"></i> Form Tambah Penerimaan Barang
                    </h3>
                </div>
                <form action="{{ route('penerimaanbarang.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_terima">
                                        Tanggal Terima Barang <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_terima') is-invalid @enderror" 
                                           id="tanggal_terima"
                                           name="tanggal_terima" 
                                           value="{{ old('tanggal_terima') }}"
                                           required>
                                    @error('tanggal_terima')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun">
                                        Tahun <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" 
                                           class="form-control @error('tahun') is-invalid @enderror" 
                                           id="tahun"
                                           name="tahun" 
                                           placeholder="Contoh: 2024"
                                           value="{{ old('tahun') }}"
                                           min="1900"
                                           max="{{ date('Y') + 1 }}"
                                           required>
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nama_barang">
                                        Nama Barang <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nama_barang') is-invalid @enderror" 
                                           id="nama_barang"
                                           name="nama_barang" 
                                           placeholder="Masukkan nama barang"
                                           value="{{ old('nama_barang') }}"
                                           required>
                                    @error('nama_barang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_pengarang">
                                        Nama Pengarang <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('nama_pengarang') is-invalid @enderror" 
                                           id="nama_pengarang"
                                           name="nama_pengarang" 
                                           placeholder="Masukkan nama pengarang"
                                           value="{{ old('nama_pengarang') }}"
                                           required>
                                    @error('nama_pengarang')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="penerbit">
                                        Penerbit <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('penerbit') is-invalid @enderror" 
                                           id="penerbit"
                                           name="penerbit" 
                                           placeholder="Masukkan nama penerbit"
                                           value="{{ old('penerbit') }}"
                                           required>
                                    @error('penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                                <a href="{{ route('penerimaanbarang.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
