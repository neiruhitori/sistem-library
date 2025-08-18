@extends('layouts.app')

@section('title', 'Kelola Lokasi Akses')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-map-marker-alt text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Kelola Lokasi Akses</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar Lokasi yang Diizinkan
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Dashboard</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-info" style="font-size:1.1rem;">
                                <i class="fas fa-map-marker-alt" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Lokasi Akses</span>
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
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            @endif

            {{-- Card dan konten lainnya di bawah sini --}}
            <div class="card mx-auto mt-3 shadow" style="max-width: 98%;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> DataTable Kelola Lokasi Akses</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.allowed-locations.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus"></i> Tambah Lokasi
                        </a>
                        <button type="button" class="btn btn-outline-light btn-sm" onclick="testCurrentLocation()">
                            <i class="fas fa-crosshairs"></i> Test Lokasi Saat Ini
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($locations->count() > 0)
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lokasi</th>
                                    <th>Koordinat</th>
                                    <th>Radius</th>
                                    <th>Status</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($locations as $index => $location)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $location->name }}</strong>
                                        </td>
                                        <td>
                                            <div class="coordinate-display mb-1">
                                                <strong>Lat:</strong> {{ number_format($location->latitude, 6) }}
                                            </div>
                                            <div class="coordinate-display mb-2">
                                                <strong>Lng:</strong> {{ number_format($location->longitude, 6) }}
                                            </div>
                                            <a href="https://maps.google.com/?q={{ $location->latitude }},{{ $location->longitude }}" 
                                               target="_blank" class="btn btn-info btn-xs">
                                                <i class="fas fa-map-marker-alt"></i> Maps
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $location->radius_meters }}m</span>
                                        </td>
                                        <td class="text-center">
                                            @if($location->is_active)
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-secondary">Non-aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $location->description ?? '-' }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="{{ route('admin.allowed-locations.edit', $location) }}" 
                                                   type="button" class="btn btn-warning" title="Edit Lokasi">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.allowed-locations.toggle-status', $location) }}" 
                                                      method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn {{ $location->is_active ? 'btn-secondary' : 'btn-success' }}"
                                                            onclick="return confirm('Yakin ingin mengubah status?')"
                                                            title="{{ $location->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                        <i class="fas {{ $location->is_active ? 'fa-pause' : 'fa-play' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.allowed-locations.destroy', $location) }}" 
                                                      method="POST" class="d-inline"
                                                      onsubmit="return confirm('Yakin ingin menghapus lokasi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger m-0" title="Hapus Lokasi">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-4">
                            <p class="text-muted">Belum ada lokasi yang dikonfigurasi.</p>
                            <a href="{{ route('admin.allowed-locations.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Lokasi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Test Result Modal -->
    <div class="modal fade" id="testResultModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hasil Test Lokasi</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" id="testResultContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.coordinate-display {
    font-family: 'Courier New', monospace;
    font-size: 11px;
    background: #f8f9fa;
    padding: 2px 4px;
    border-radius: 3px;
    border: 1px solid #dee2e6;
    display: inline-block;
    margin-bottom: 2px;
}
</style>
@endpush

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

    <!-- DataTable Configuration -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": false,
                "paging": true,
                "pageLength": 25,
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                "language": {
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "search": "Cari:",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir", 
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
        });
    </script>

    <!-- Test Location Script -->
    <script>
    function testCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Browser tidak mendukung geolocation');
            return;
        }

        const loadingBtn = `<button class="btn btn-info btn-sm" disabled>
            <i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...
        </button>`;
        
        // Show loading state
        $('.card-tools button[onclick="testCurrentLocation()"]').replaceWith(loadingBtn);

        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                $.ajax({
                    url: '{{ route("admin.allowed-locations.test") }}',
                    method: 'POST',
                    data: {
                        latitude: lat,
                        longitude: lng,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showTestResult(response);
                    },
                    error: function() {
                        alert('Gagal melakukan test lokasi');
                    },
                    complete: function() {
                        // Restore button
                        location.reload();
                    }
                });
            },
            function(error) {
                alert('Gagal mendapatkan lokasi: ' + error.message);
                location.reload();
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }

    function showTestResult(response) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <h5>Lokasi Anda:</h5>
                    <p><strong>Latitude:</strong> ${response.user_coordinates.latitude}</p>
                    <p><strong>Longitude:</strong> ${response.user_coordinates.longitude}</p>
                    <a href="https://maps.google.com/?q=${response.user_coordinates.latitude},${response.user_coordinates.longitude}" 
                       target="_blank" class="btn btn-sm btn-info">
                        <i class="fas fa-map"></i> Lihat di Maps
                    </a>
                </div>
                <div class="col-md-6">
                    <h5>Status Akses:</h5>
                    <span class="badge badge-${response.is_access_allowed ? 'success' : 'danger'} p-2">
                        ${response.is_access_allowed ? 'DIIZINKAN' : 'DITOLAK'}
                    </span>
                </div>
            </div>
            <hr>
            <h5>Detail Jarak ke Lokasi:</h5>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Lokasi</th>
                            <th>Jarak</th>
                            <th>Radius</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>`;
        
        response.results.forEach(function(result) {
            content += `
                <tr class="${result.is_allowed ? 'table-success' : 'table-danger'}">
                    <td>${result.location.name}</td>
                    <td>${result.distance}m</td>
                    <td>${result.radius}m</td>
                    <td>
                        <span class="badge badge-${result.is_allowed ? 'success' : 'danger'}">
                            ${result.is_allowed ? 'Dalam Jangkauan' : 'Diluar Jangkauan'}
                        </span>
                    </td>
                </tr>`;
        });
        
        content += `
                    </tbody>
                </table>
            </div>`;
        
        $('#testResultContent').html(content);
        $('#testResultModal').modal('show');
    }
    </script>
@endpush
