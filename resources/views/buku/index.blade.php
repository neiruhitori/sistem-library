@extends('layouts.app')

@section('title', 'Data Buku')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Buku {{ ucfirst($tipe) }}</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar buku {{ $tipe }} SMPN 02 Klakah
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
                                <i class="fas fa-book" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Buku {{ ucfirst($tipe) }}</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            {{-- Alert sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert" id="alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-success');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            @endif

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
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
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-error');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            @endif

            {{-- Alert error dari session --}}
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-session-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-session-error');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000);
                </script>
            @endif

            {{-- Alert warning --}}
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="alert-warning">
                    <i class="fas fa-exclamation-circle"></i>
                    {{ session('warning') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-warning');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 5000);
                </script>
            @endif

            {{-- Alert hapus semua --}}
            @if (session('removeAll'))
                <div class="alert alert-warning alert-dismissible fade show mt-2" role="alert" id="alert-removeall">
                    <i class="fas fa-trash-alt"></i>
                    {{ session('removeAll') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-removeall');
                        if (alert) {
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            @endif

            <div class="card mx-auto mt-3 shadow" style="max-width: 98%;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> DataTable Buku {{ ucfirst($tipe) }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <a href="{{ route('buku.create', ['tipe' => $tipe]) }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Buku
                        </a>
                        <form action="{{ route('buku.hapussemua') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data buku {{ $tipe }}?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="tipe" value="{{ $tipe }}">
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Semua Buku
                            </button>
                        </form>

                    </div>
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Sampul</th>
                                <th>Kode Buku</th>
                                <th>Penulis</th>
                                <th>Tahun Terbit</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bukus as $key => $buku)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $buku->judul }}</td>
                                    <td>
                                        @if ($buku->foto)
                                            <img src="{{ str_starts_with($buku->foto, 'sampulbuku/') ? asset($buku->foto) : asset('storage/' . $buku->foto) }}" alt="Sampul Buku"
                                                width="60">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @foreach ($buku->kodeBuku as $kode)
                                            @php
                                                $detailHarian = $kode
                                                    ->detailPeminjamanHarian()
                                                    ->latest('updated_at')
                                                    ->first();
                                                $detailTahunan = $kode
                                                    ->detailPeminjamanTahunan()
                                                    ->latest('updated_at')
                                                    ->first();

                                                $last = collect([$detailHarian, $detailTahunan])
                                                    ->filter()
                                                    ->sortByDesc('updated_at')
                                                    ->first();

                                                $hilang = $last && $last->status === 'hilang';

                                                $badgeClass = $hilang
                                                    ? 'badge-secondary'
                                                    : ($kode->status === 'dipinjam'
                                                        ? 'badge-danger'
                                                        : 'badge-info');
                                            @endphp


                                            <span class="badge {{ $badgeClass }} mb-1 d-block">
                                                {{ $kode->kode_buku }}
                                                @if ($hilang)
                                                    <br><small class="text-white fst-italic">(Hilang)</small>
                                                @endif
                                            </span>
                                        @endforeach
                                    </td>


                                    <td>{{ $buku->penulis }}</td>
                                    <td>{{ $buku->tahun_terbit }}</td>
                                    <td>
                                        {{ $buku->stok }}
                                        @if (!$buku->is_active)
                                            <br><span class="badge badge-secondary badge-sm">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-secondary"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning"><i
                                                    class="fas fa-edit"></i></a>
                                            
                                            @php
                                                // Cek apakah buku pernah dipinjam atau sedang dipinjam
                                                $peminjamanHarianCount = $buku->peminjamanHarianDetails()->count();
                                                $peminjamanTahunanCount = $buku->peminjamanTahunanDetails()->count();
                                                $kodeBukuDipinjam = $buku->kodeBuku()->where('status', 'dipinjam')->count();
                                                
                                                $canDelete = ($peminjamanHarianCount == 0 && $peminjamanTahunanCount == 0 && $kodeBukuDipinjam == 0);
                                                $hasHistory = ($peminjamanHarianCount > 0 || $peminjamanTahunanCount > 0);
                                            @endphp
                                            
                                            @if ($canDelete)
                                                {{-- Buku bisa dihapus karena belum pernah dipinjam --}}
                                                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" title="Hapus buku">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Buku tidak bisa dihapus, tampilkan button toggle aktif/nonaktif --}}
                                                <form action="{{ route('buku.toggle-status', $buku->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('{{ $buku->is_active ? "Nonaktifkan buku ini? Buku tidak akan muncul dalam daftar peminjaman." : "Aktifkan kembali buku ini?" }}')">
                                                    @csrf
                                                    <button class="btn {{ $buku->is_active ? 'btn-danger' : 'btn-success' }}" 
                                                        title="{{ $buku->is_active ? 'Nonaktifkan buku (untuk arsip)' : 'Aktifkan kembali buku' }}">
                                                        <i class="fas fa-{{ $buku->is_active ? 'ban' : 'check-circle' }}"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                        @if (!$canDelete)
                                            <div class="mt-1">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> Tidak bisa dihapus karena untuk arsip
                                                </small>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-danger">Data buku {{ $tipe }} belum
                                        tersedia.</td>
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
    @push('scripts')
        <!-- DataTables & Plugins -->
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
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
