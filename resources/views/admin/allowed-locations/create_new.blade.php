@extends('layouts.app')

@section('title', 'Tambah Lokasi Akses')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-plus-circle text-success" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Tambah Lokasi Akses</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Tambahkan lokasi baru yang diizinkan
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
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.allowed-locations.index') }}">
                                <span class="badge badge-info" style="font-size:1.1rem;">
                                    <i class="fas fa-map-marker-alt" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Lokasi Akses</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-success" style="font-size:1.1rem;">
                                <i class="fas fa-plus" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Tambah</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
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
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            @endif

            <div class="card mx-auto mt-3 shadow" style="max-width: 98%;">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title"><i class="fas fa-plus-circle"></i> Form Tambah Lokasi Akses</h3>
                </div>
                <form action="{{ route('admin.allowed-locations.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lokasi *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" 
                                       placeholder="Contoh: SMPN 02 Klakah">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="radius_meters" class="form-label">Radius (meter) *</label>
                                <input type="number" class="form-control @error('radius_meters') is-invalid @enderror" 
                                       id="radius_meters" name="radius_meters" value="{{ old('radius_meters', 200) }}" 
                                       min="1" max="5000" placeholder="200">
                                @error('radius_meters')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Jarak maksimum yang diizinkan dari lokasi (1-5000 meter)</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude *</label>
                                <input type="text" class="form-control @error('latitude') is-invalid @enderror" 
                                       id="latitude" name="latitude" value="{{ old('latitude') }}" 
                                       placeholder="-8.076389" step="any">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude *</label>
                                <input type="text" class="form-control @error('longitude') is-invalid @enderror" 
                                       id="longitude" name="longitude" value="{{ old('longitude') }}" 
                                       placeholder="113.746111" step="any">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Deskripsi lokasi...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="is_active">Status Aktif</label>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fas fa-lightbulb text-warning"></i> Cara Mendapatkan Koordinat</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-map-marker-alt text-info"></i> Gunakan Lokasi Saat Ini</h6>
                                        <button type="button" class="btn btn-info btn-sm" onclick="getCurrentLocation()">
                                            <i class="fas fa-crosshairs"></i> Ambil Lokasi Saat Ini
                                        </button>
                                        <small class="form-text text-muted">Pastikan Anda berada di lokasi yang ingin didaftarkan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-secondary">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-map text-secondary"></i> Dari Google Maps</h6>
                                        <ol class="small mb-0">
                                            <li>Buka Google Maps</li>
                                            <li>Cari lokasi yang diinginkan</li>
                                            <li>Klik kanan pada lokasi</li>
                                            <li>Koordinat akan muncul di bagian atas</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('admin.allowed-locations.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#saveModal">
                            <i class="fas fa-save"></i> Simpan Lokasi
                        </button>

                        <!-- Modal Konfirmasi Save -->
                        <div class="modal fade" id="saveModal" tabindex="-1" aria-labelledby="saveModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="saveModalLabel">Konfirmasi Simpan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menyimpan lokasi akses baru ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i> Ya, Simpan
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

@push('scripts')
<script>
function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung geolocation');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            alert('Koordinat berhasil diambil!');
        },
        function(error) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            alert('Gagal mendapatkan lokasi: ' + error.message);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
</script>
@endpush
