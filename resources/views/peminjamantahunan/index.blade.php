@extends('layouts.app')

@section('title', 'Peminjaman Tahunan')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Peminjaman Tahunan</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar peminjaman tahunan buku SMPN 02 Klakah
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
                                <span class="align-middle">Peminjaman Tahunan</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Peminjaman Tahunan</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex gap-2">
                        <a href="{{ route('peminjamantahunan.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                        <form action="{{ route('peminjamantahunan.hapussemua') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data peminjaman tahunan?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Semua Peminjaman
                            </button>
                        </form>
                    </div>
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                                <th>Buku</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjamans as $key => $peminjaman)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $peminjaman->siswa->name }}</td>
                                    <td>{{ $peminjaman->tanggal_pinjam }}</td>
                                    <td>{{ $peminjaman->tanggal_kembali }}</td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $peminjaman->status === 'dipinjam' ? 'warning' : 'success' }}">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <ul class="mb-0 pl-3">
                                            @foreach ($peminjaman->details as $detail)
                                            <li>
                                                <div class="mb-1">
                                                    [{{ $detail->kodeBuku->kode_buku ?? '???' }}]
                                                    {{ $detail->kodeBuku->buku->judul ?? '-' }}
                                                </div>
                                            </li>
                                            @endforeach

                                        </ul>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('peminjamantahunan.show', $peminjaman->id) }}"
                                                class="btn btn-secondary"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('peminjamantahunan.edit', $peminjaman->id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('peminjamantahunan.destroy', $peminjaman->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin hapus data ini?')"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-danger">Belum ada data peminjaman.</td>
                                </tr>
                            @endforelse
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
