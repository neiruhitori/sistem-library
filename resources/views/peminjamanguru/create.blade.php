@extends('layouts.app')

@section('title', 'Tambah Peminjaman Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Peminjaman Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('peminjamanguru.index') }}">Peminjaman Guru</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first('error') }}
                    <button type="button" class="close" data-bs-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Form Peminjaman Buku Panduan Guru</h3>
                </div>
                <form action="{{ route('peminjamanguru.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="guru_id">Pilih Guru <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('guru_id') is-invalid @enderror" 
                                    id="guru_id" name="guru_id" required style="width: 100%;">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ old('guru_id') == $guru->id ? 'selected' : '' }}>
                                        {{ $guru->nama }} {{ $guru->nip ? '(' . $guru->nip . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('guru_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_pinjam">Tanggal Pinjam <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_pinjam') is-invalid @enderror" 
                                           id="tanggal_pinjam" name="tanggal_pinjam" 
                                           value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                                    @error('tanggal_pinjam')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tanggal_kembali">Tanggal Kembali <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('tanggal_kembali') is-invalid @enderror" 
                                           id="tanggal_kembali" name="tanggal_kembali" 
                                           value="{{ old('tanggal_kembali') }}" required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="kode_ids">Pilih Kode Buku <span class="text-danger">*</span></label>
                            <select class="form-control select2-multiple @error('kode_ids') is-invalid @enderror @error('kode_ids.*') is-invalid @enderror" 
                                    id="kode_ids" name="kode_ids[]" multiple required style="width: 100%;">
                                @foreach($kodes as $kode)
                                    <option value="{{ $kode['id'] }}" 
                                        {{ in_array($kode['id'], old('kode_ids', [])) ? 'selected' : '' }}>
                                        {{ $kode['display'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Hanya menampilkan kode yang tersedia (belum dipinjam)
                            </small>
                            @error('kode_ids')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('kode_ids.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Peminjaman
                        </button>
                        <a href="{{ route('peminjamanguru.index') }}" class="btn btn-secondary">
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
        // Initialize Select2 for guru selection
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Guru --',
            allowClear: true
        });

        // Initialize Select2 for multiple book selection
        $('.select2-multiple').select2({
            theme: 'bootstrap4',
            placeholder: '-- Pilih Buku Panduan Guru --',
            allowClear: true
        });
    });

    // Auto set tanggal kembali 1 tahun dari tanggal pinjam
    document.getElementById('tanggal_pinjam').addEventListener('change', function() {
        const tanggalPinjam = new Date(this.value);
        tanggalPinjam.setFullYear(tanggalPinjam.getFullYear() + 1);
        const tanggalKembali = tanggalPinjam.toISOString().split('T')[0];
        document.getElementById('tanggal_kembali').value = tanggalKembali;
    });
</script>
@endpush
