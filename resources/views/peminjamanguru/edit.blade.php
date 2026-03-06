@extends('layouts.app')

@section('title', 'Edit Peminjaman Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Peminjaman Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('peminjamanguru.index') }}">Peminjaman Guru</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                <div class="card-header bg-warning text-white">
                    <h3 class="card-title">Form Edit Peminjaman Guru</h3>
                </div>
                <form action="{{ route('peminjamanguru.update', $peminjaman->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="guru_id">Pilih Guru <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('guru_id') is-invalid @enderror" 
                                    id="guru_id" name="guru_id" required style="width: 100%;">
                                <option value="">-- Pilih Guru --</option>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" 
                                        {{ old('guru_id', $peminjaman->guru_id) == $guru->id ? 'selected' : '' }}>
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
                                           value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}" required>
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
                                           value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}" required>
                                    @error('tanggal_kembali')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="dipinjam" {{ old('status', $peminjaman->status) == 'dipinjam' ? 'selected' : '' }}>
                                    Dipinjam
                                </option>
                                <option value="selesai" {{ old('status', $peminjaman->status) == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label>Daftar Buku yang Dipinjam</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-light">
                                        <tr>
                                            <th width="25%">Kode Buku</th>
                                            <th width="40%">Judul</th>
                                            <th width="35%">Status <span class="text-danger">*</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($peminjaman->details as $detail)
                                        <tr>
                                            <td>
                                                <span class="badge badge-info">
                                                    [{{ $detail->kodePanduanGuru->kode_awal ?? '-' }} - {{ $detail->kodePanduanGuru->kode_akhir ?? '-' }}]
                                                </span>
                                            </td>
                                            <td>
                                                {{ $detail->bukuPanduanGuru->judul ?? '-' }}
                                                <br><small class="text-muted">{{ $detail->bukuPanduanGuru->penulis ?? '' }}</small>
                                            </td>
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[{{ $detail->id }}]" 
                                                           id="status_dipinjam_{{ $detail->id }}"
                                                           value="dipinjam" 
                                                           {{ old('detail_status.' . $detail->id, $detail->status) == 'dipinjam' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_dipinjam_{{ $detail->id }}">
                                                        <span class="badge badge-warning">Dipinjam</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[{{ $detail->id }}]" 
                                                           id="status_dikembalikan_{{ $detail->id }}"
                                                           value="dikembalikan" 
                                                           {{ old('detail_status.' . $detail->id, $detail->status) == 'dikembalikan' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_dikembalikan_{{ $detail->id }}">
                                                        <span class="badge badge-success">Dikembalikan</span>
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" 
                                                           name="detail_status[{{ $detail->id }}]" 
                                                           id="status_hilang_{{ $detail->id }}"
                                                           value="hilang" 
                                                           {{ old('detail_status.' . $detail->id, $detail->status) == 'hilang' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="status_hilang_{{ $detail->id }}">
                                                        <span class="badge badge-danger">Hilang</span>
                                                    </label>
                                                </div>
                                                @if($detail->tanggal_dikembalikan)
                                                    <small class="text-muted d-block mt-1">
                                                        <i class="fas fa-calendar"></i> Dikembalikan: {{ $detail->tanggal_dikembalikan }}
                                                    </small>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <small class="form-text text-muted">
                                <i class="fas fa-info-circle"></i> Ubah status untuk setiap buku yang dikembalikan atau hilang
                            </small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Peminjaman
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
</script>
@endpush
