@extends('layouts.app')

@section('title', isset($penandatangan) ? 'Edit Penandatangan' : 'Tambah Penandatangan')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-tie text-primary"></i>
                        <span>{{ isset($penandatangan) ? 'Edit' : 'Tambah' }} Penandatangan</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('penandatangan.index') }}"><i class="fas fa-user-tie"></i> Penandatangan</a></li>
                        <li class="breadcrumb-item active">{{ isset($penandatangan) ? 'Edit' : 'Tambah' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 600px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-tie"></i> Form {{ isset($penandatangan) ? 'Edit' : 'Tambah' }} Penandatangan</h3>
                </div>
                <form method="POST" action="{{ isset($penandatangan) ? route('penandatangan.update', $penandatangan->id) : route('penandatangan.store') }}">
                    @csrf
                    @if(isset($penandatangan))
                        @method('PUT')
                    @endif
                    
                    <div class="card-body">
                        <div class="form-group">
                            <label for="jabatan">Jabatan <span class="text-danger">*</span></label>
                            <select class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" id="jabatan" required>
                                <option value="">-- Pilih Jabatan --</option>
                                <option value="kepala_perpustakaan" {{ old('jabatan', $penandatangan->jabatan ?? '') == 'kepala_perpustakaan' ? 'selected' : '' }}>
                                    Kepala Perpustakaan
                                </option>
                                <option value="kepala_sekolah" {{ old('jabatan', $penandatangan->jabatan ?? '') == 'kepala_sekolah' ? 'selected' : '' }}>
                                    Kepala Sekolah
                                </option>
                            </select>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                name="nama" id="nama" placeholder="Masukkan nama penandatangan" 
                                value="{{ old('nama', $penandatangan->nama ?? '') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nip">NIP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                name="nip" id="nip" placeholder="Masukkan NIP" 
                                value="{{ old('nip', $penandatangan->nip ?? '') }}" required>
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                    {{ old('is_active', $penandatangan->is_active ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">
                                    Aktifkan sebagai penandatangan utama
                                </label>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle"></i> 
                                Jika dicentang, penandatangan lain dengan jabatan yang sama akan dinonaktifkan
                            </small>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('penandatangan.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
