@extends('layouts.app')

@section('title', 'Detail Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('guru.index') }}">Guru</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Informasi Guru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">NIP</th>
                            <td>{{ $guru->nip ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>{{ $guru->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tambahan Tugas</th>
                            <td>{{ $guru->tambahantugas ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $guru->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Ditambahkan</th>
                            <td>{{ $guru->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $guru->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('guru.edit', $guru->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('guru.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
