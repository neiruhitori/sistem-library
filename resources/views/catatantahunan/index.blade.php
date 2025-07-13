@extends('layouts.app')

@section('title', 'Catatan Tahunan')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Catatan Tahunan</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar catatan tahunan buku SMPN 02 Klakah
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Beranda</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info" style="font-size:1.1rem;">
                                <i class="fas fa-book-reader" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Catatan Tahunan</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-success').classList.remove('show'), 4000);
                </script>
            @endif
            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Catatan Tahunan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Jenis Denda</th>
                                <th>Jumlah</th>
                                <th>Keterangan</th>
                                <th>Tanggal</th>
                                <th>status</th>
                                <th>Aksi</th> {{-- Tambahkan ini --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catatans as $key => $catatan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $catatan->siswa->name }}</td>
                                    <td>{{ ucfirst($catatan->jenis_denda) }}</td>
                                    <td>Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}</td>
                                    <td>{{ $catatan->keterangan }}</td>
                                    <td>{{ $catatan->tanggal_denda }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $catatan->status === 'dibayar' ? 'success' : 'danger' }}">
                                            {{ $catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar' }}
                                        </span>

                                    </td>
                                    <td>
                                        <a href="{{ route('catatantahunan.show', $catatan->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(function() {
            $('#example1').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
            });
        });
    </script>
@endpush
