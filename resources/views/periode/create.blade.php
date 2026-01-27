@extends('layouts.app')

@section('title', 'Tambah Periode Tahun Ajaran')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Tambah Periode</span>
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
                            <a href="{{ route('periode.index') }}">
                                <span class="badge badge-info" style="font-size:1.1rem;">
                                    <i class="fas fa-calendar-alt"></i> Periode
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
                        <i class="fas fa-edit"></i> Form Tambah Periode Tahun Ajaran
                    </h3>
                </div>
                <form action="{{ route('periode.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tahun_ajaran">
                                        Tahun Ajaran <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                                           id="tahun_ajaran"
                                           name="tahun_ajaran" 
                                           placeholder="Contoh: 2024/2025"
                                           value="{{ old('tahun_ajaran') }}"
                                           required>
                                    @error('tahun_ajaran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: YYYY/YYYY (Contoh: 2024/2025)
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="semester">
                                        Semester <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('semester') is-invalid @enderror" 
                                            id="semester"
                                            name="semester" 
                                            required>
                                        <option value="">-- Pilih Semester --</option>
                                        <option value="Ganjil" {{ old('semester') == 'Ganjil' ? 'selected' : '' }}>
                                            Ganjil (Juli - Desember)
                                        </option>
                                        <option value="Genap" {{ old('semester') == 'Genap' ? 'selected' : '' }}>
                                            Genap (Januari - Juni)
                                        </option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai">
                                        Tanggal Mulai <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_mulai') is-invalid @enderror" 
                                           id="tanggal_mulai"
                                           name="tanggal_mulai" 
                                           value="{{ old('tanggal_mulai') }}"
                                           required>
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_selesai">
                                        Tanggal Selesai <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('tanggal_selesai') is-invalid @enderror" 
                                           id="tanggal_selesai"
                                           name="tanggal_selesai" 
                                           value="{{ old('tanggal_selesai') }}"
                                           required>
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active"
                                               value="1"
                                               {{ old('is_active') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">
                                            Set sebagai periode aktif
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i>
                                        Jika dicentang, periode lain akan otomatis menjadi tidak aktif
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('periode.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
