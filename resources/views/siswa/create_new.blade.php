@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-plus text-primary"></i>
                        <span>Tambah Siswa</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}"><i class="fas fa-users"></i> Siswa</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
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

            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i> Form Tambah Siswa</h3>
                </div>
                <form method="POST" action="{{ route('siswa.store') }}" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <h5 class="mb-3"><i class="fas fa-user-circle"></i> Data Identitas Siswa</h5>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="nisn">NISN (Nomor Induk Siswa Nasional) <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('nisn') is-invalid @enderror"
                                           name="nisn" 
                                           id="nisn" 
                                           placeholder="Masukkan NISN (contoh: 0061234567 / 1234567890)"
                                           value="{{ old('nisn') }}"
                                           required>
                                    @error('nisn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Format: NIS Sekolah / NISN Nasional atau hanya salah satu
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" 
                                           id="name" 
                                           placeholder="Masukkan Nama Lengkap Siswa"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" 
                                            id="jenis_kelamin"
                                            class="form-control @error('jenis_kelamin') is-invalid @enderror"
                                            required>
                                        <option value="">-- Pilih Jenis Kelamin --</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jenis_kelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agama">Agama</label>
                                    <select name="agama" 
                                            id="agama"
                                            class="form-control @error('agama') is-invalid @enderror">
                                        <option value="">-- Pilih Agama --</option>
                                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                    </select>
                                    @error('agama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr>
                        <h5 class="mb-3"><i class="fas fa-school"></i> Data Kelas (Periode Tahun Ajaran)</h5>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="periode_id">Periode Tahun Ajaran <span class="text-danger">*</span></label>
                                    <select name="periode_id" 
                                            id="periode_id"
                                            class="form-control @error('periode_id') is-invalid @enderror"
                                            required>
                                        <option value="">-- Pilih Periode Tahun Ajaran --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id }}" 
                                                {{ (old('periode_id') == $periode->id || ($periodeAktif && $periodeAktif->id == $periode->id && !old('periode_id'))) ? 'selected' : '' }}>
                                                {{ $periode->nama_lengkap }}
                                                @if ($periode->is_active)
                                                    (Aktif)
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('periode_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kelas">Kelas <span class="text-danger">*</span></label>
                                    <select name="kelas" 
                                            id="kelas"
                                            class="form-control @error('kelas') is-invalid @enderror"
                                            required>
                                        <option value="">-- Pilih Kelas --</option>
                                        @foreach (['7A', '7B', '7C', '7D', '7E', '7F', '7G', '7H', '8A', '8B', '8C', '8D', '8E', '8F', '8G', '8H', '9A', '9B', '9C', '9D', '9E', '9F', '9G', '9H'] as $kelas)
                                            <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>
                                                {{ $kelas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kelas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="absen">No. Absen</label>
                                    <input type="text" 
                                           class="form-control @error('absen') is-invalid @enderror"
                                           name="absen" 
                                           id="absen" 
                                           placeholder="Masukkan No. Absen (opsional)"
                                           value="{{ old('absen') }}">
                                    @error('absen')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select name="status" 
                                            id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        <option value="Pindah" {{ old('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
