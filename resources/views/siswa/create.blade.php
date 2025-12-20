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
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}"><i class="fas fa-users"></i>
                                Siswa</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 700px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-user-plus"></i> Form Tambah Siswa</h3>
                </div>
                <form method="post" action="{{ route('siswa.store') }}" autocomplete="off">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                    name="nisn" id="nisn" placeholder="Masukkan NISN Siswa"
                                    value="{{ old('nisn') }}">
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Masukkan Nama Siswa"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select name="kelas" id="kelas"
                                    class="form-control @error('kelas') is-invalid @enderror">
                                    <option selected disabled>Pilih Kelas</option>
                                    @foreach (['VII A', 'VII B', 'VII C', 'VII D', 'VII E', 'VII F', 'VII G', 'VIII A', 'VIII B', 'VIII C', 'VIII D', 'VIII E', 'VIII F', 'VIII G', 'IX A', 'IX B', 'IX C', 'IX D', 'IX E', 'IX F', 'IX G'] as $kelas)
                                        <option value="{{ $kelas }}" {{ old('kelas') == $kelas ? 'selected' : '' }}>
                                            {{ $kelas }}</option>
                                    @endforeach
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('siswa.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> Simpan Siswa
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Siswa?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menambah data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
