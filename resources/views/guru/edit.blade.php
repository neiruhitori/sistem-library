@extends('layouts.app')

@section('title', 'Edit Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h3 class="card-title">Form Edit Guru</h3>
                </div>
                <form action="{{ route('guru.update', $guru->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="nip">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                   id="nip" name="nip" value="{{ old('nip', $guru->nip) }}">
                            @error('nip')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama', $guru->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="tambahantugas">Tambahan Tugas</label>
                            <select class="form-control select2 @error('tambahantugas') is-invalid @enderror" 
                                   id="tambahantugas" name="tambahantugas" style="width: 100%;">
                                <option value="">-- Pilih Tambahan Tugas --</option>
                                <option value="Wali Kelas 7A" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7A' ? 'selected' : '' }}>Wali Kelas 7A</option>
                                <option value="Wali Kelas 7B" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7B' ? 'selected' : '' }}>Wali Kelas 7B</option>
                                <option value="Wali Kelas 7C" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7C' ? 'selected' : '' }}>Wali Kelas 7C</option>
                                <option value="Wali Kelas 7D" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7D' ? 'selected' : '' }}>Wali Kelas 7D</option>
                                <option value="Wali Kelas 7E" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7E' ? 'selected' : '' }}>Wali Kelas 7E</option>
                                <option value="Wali Kelas 7F" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7F' ? 'selected' : '' }}>Wali Kelas 7F</option>
                                <option value="Wali Kelas 7G" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 7G' ? 'selected' : '' }}>Wali Kelas 7G</option>
                                <option value="Wali Kelas 8A" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8A' ? 'selected' : '' }}>Wali Kelas 8A</option>
                                <option value="Wali Kelas 8B" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8B' ? 'selected' : '' }}>Wali Kelas 8B</option>
                                <option value="Wali Kelas 8C" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8C' ? 'selected' : '' }}>Wali Kelas 8C</option>
                                <option value="Wali Kelas 8D" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8D' ? 'selected' : '' }}>Wali Kelas 8D</option>
                                <option value="Wali Kelas 8E" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8E' ? 'selected' : '' }}>Wali Kelas 8E</option>
                                <option value="Wali Kelas 8F" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8F' ? 'selected' : '' }}>Wali Kelas 8F</option>
                                <option value="Wali Kelas 8G" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 8G' ? 'selected' : '' }}>Wali Kelas 8G</option>
                                <option value="Wali Kelas 9A" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9A' ? 'selected' : '' }}>Wali Kelas 9A</option>
                                <option value="Wali Kelas 9B" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9B' ? 'selected' : '' }}>Wali Kelas 9B</option>
                                <option value="Wali Kelas 9C" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9C' ? 'selected' : '' }}>Wali Kelas 9C</option>
                                <option value="Wali Kelas 9D" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9D' ? 'selected' : '' }}>Wali Kelas 9D</option>
                                <option value="Wali Kelas 9E" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9E' ? 'selected' : '' }}>Wali Kelas 9E</option>
                                <option value="Wali Kelas 9F" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9F' ? 'selected' : '' }}>Wali Kelas 9F</option>
                                <option value="Wali Kelas 9G" {{ old('tambahantugas', $guru->tambahantugas) == 'Wali Kelas 9G' ? 'selected' : '' }}>Wali Kelas 9G</option>
                            </select>
                            @error('tambahantugas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                                      id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $guru->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Tambahan Tugas --',
                allowClear: true
            });
        });
    </script>
@endpush
