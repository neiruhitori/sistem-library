@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-user-plus text-primary"></i>
                        <span>Detail Siswa</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('siswa.index') }}"><i class="fas fa-users"></i>
                                Siswa</a></li>
                        <li class="breadcrumb-item active">Detail Siswa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 700px;">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-user-plus"></i> Form Detail Siswa</h3>
                    {{-- <div>
                        <a href="{{ route('siswa.print.card', $siswa->id) }}" 
                           class="btn btn-success btn-sm" 
                           target="_blank">
                            <i class="fas fa-id-card"></i> Cetak Card ID
                        </a>
                        <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                    </div> --}}
                </div>
                <form method="post" action="#" autocomplete="off">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                    name="nisn" id="nisn" placeholder="Masukkan NISN Siswa"
                                    value="{{ $siswa->nisn }}" disabled>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Masukkan Nama Siswa"
                                    value="{{ $siswa->name }}" disabled>

                            </div>
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" placeholder="Masukkan Nama Siswa"
                                    value="{{ $siswa->kelas }}" disabled>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection