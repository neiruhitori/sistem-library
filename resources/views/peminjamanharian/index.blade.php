@extends('layouts.app')

@section('title', 'Peminjaman Harian')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Peminjaman Harian</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar peminjaman harian buku SMPN 02 Klakah
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
                                <span class="align-middle">Peminjaman Harian</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Peminjaman Harian</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex gap-2">
                        <a href="{{ route('peminjamanharian.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Peminjaman
                        </a>
                        <form action="{{ route('peminjamanharian.hapussemua') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data peminjaman harian?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                {{ $userPeminjamanCount == 0 ? 'disabled' : '' }}
                                {{ $userPeminjamanCount == 0 ? 'title="Tidak ada data peminjaman untuk dihapus"' : '' }}>
                                <i class="fas fa-trash-alt"></i> Hapus Semua Peminjaman
                                @if($userPeminjamanCount > 0)
                                    <span class="badge badge-light ml-1">{{ $userPeminjamanCount }}</span>
                                @endif
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
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('peminjamanharian.index') }}',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error loading data:', error);
                        alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                    { data: 'nama_siswa', name: 'siswa.name', width: '15%' },
                    { data: 'tanggal_pinjam', name: 'tanggal_pinjam', width: '12%' },
                    { data: 'tanggal_kembali', name: 'tanggal_kembali', width: '12%' },
                    { data: 'status_badge', name: 'status', orderable: false, width: '10%' },
                    { data: 'buku_list', name: 'buku_list', orderable: false, searchable: false, width: '31%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '15%' }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                order: [[2, 'desc']], // Default sort by tanggal_pinjam descending
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Memproses...',
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Belum ada data peminjaman",
                    zeroRecords: "Data tidak ditemukan"
                },
                drawCallback: function(settings) {
                    // Re-initialize any tooltips or popovers if needed
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });
    </script>
@endpush
