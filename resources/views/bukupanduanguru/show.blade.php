@extends('layouts.app')

@section('title', 'Detail Buku Panduan Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Buku Panduan Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bukupanduanguru.index') }}">Buku Panduan Guru</a></li>
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
                    <h3 class="card-title">Informasi Buku Panduan Guru</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="25%">Kode Buku</th>
                            <td>
                                @if($buku->kodePanduanGuru && $buku->kodePanduanGuru->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($buku->kodePanduanGuru as $index => $kode)
                                            <span class="badge badge-primary mr-2 mb-1" style="font-size: 14px;">
                                                [{{ $kode->kode_awal ?? '-' }} - {{ $kode->kode_akhir ?? '-' }}]
                                                <small class="text-white">({{ ucfirst($kode->status) }})</small>
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted">Tidak ada kode</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Penulis</th>
                            <td>{{ $buku->penulis }}</td>
                        </tr>
                        <tr>
                            <th>Judul Buku</th>
                            <td>{{ $buku->judul }}</td>
                        </tr>
                        <tr>
                            <th>Penerbit</th>
                            <td>{{ $buku->penerbit }}</td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $buku->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td>
                                <span class="badge badge-success" style="font-size: 14px;">
                                    {{ $buku->kodePanduanGuru->where('status', 'tersedia')->count() }}
                                </span>
                                dari total 
                                <span class="badge badge-info" style="font-size: 14px;">
                                    {{ $buku->kodePanduanGuru->count() }}
                                </span>
                                kode buku
                            </td>
                        </tr>
                        <tr>
                            <th>Ditambahkan</th>
                            <td>{{ $buku->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $buku->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="card-footer">
                    <a href="{{ route('bukupanduanguru.edit', $buku->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('bukupanduanguru.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
