@extends('layouts.app')

@section('title', 'Tambah Buku Panduan Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Buku Panduan Guru</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bukupanduanguru.index') }}">Buku Panduan Guru</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Form Tambah Buku Panduan Guru</h3>
                </div>
                <form action="{{ route('bukupanduanguru.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                            <small class="text-muted d-block mb-3">
                                <i class="fas fa-info-circle"></i> Masukkan kode awal dan kode akhir untuk buku panduan guru. 
                                Anda dapat menambahkan lebih dari satu range kode. Minimal harus ada satu kode yang diisi.
                            </small>
                            <div id="kode-buku-container">
                                @if (old('kode_awal'))
                                    @foreach (old('kode_awal') as $index => $kodeAwal)
                                        <div class="kode-buku-item mb-3">
                                            <div class="card border-light shadow-sm">
                                                <div class="card-body py-2">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Awal</label>
                                                            <input type="text" name="kode_awal[]" class="form-control" 
                                                                value="{{ $kodeAwal }}" placeholder="Contoh: 43898">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Akhir</label>
                                                            <input type="text" name="kode_akhir[]" class="form-control" 
                                                                value="{{ old('kode_akhir')[$index] ?? '' }}" placeholder="Contoh: 43903">
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="hapusKodeBuku(this)" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="kode-buku-item mb-3">
                                        <div class="card border-light shadow-sm">
                                            <div class="card-body py-2">
                                                <div class="row align-items-center">
                                                    <div class="col-md-5">
                                                        <label class="small text-muted mb-1">Kode Awal</label>
                                                        <input type="text" name="kode_awal[]" class="form-control" 
                                                            placeholder="Contoh: 43898">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label class="small text-muted mb-1">Kode Akhir</label>
                                                        <input type="text" name="kode_akhir[]" class="form-control" 
                                                            placeholder="Contoh: 43903">
                                                    </div>
                                                    <div class="col-md-2 text-center">
                                                        <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                        <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="hapusKodeBuku(this)" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <button type="button" class="btn btn-sm btn-primary" 
                                onclick="tambahKodeBuku()">
                                <i class="fas fa-plus-circle"></i> Tambah Kode Buku Lagi
                            </button>

                            @error('kode_buku')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @error('kode_awal')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            @error('kode_akhir')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="penulis">Penulis <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('penulis') is-invalid @enderror" 
                                   id="penulis" name="penulis" value="{{ old('penulis') }}" 
                                   placeholder="Nama penulis" required>
                            @error('penulis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="judul">Judul Buku <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}" 
                                   placeholder="Judul buku panduan guru" required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="penerbit">Penerbit <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('penerbit') is-invalid @enderror" 
                                           id="penerbit" name="penerbit" value="{{ old('penerbit') }}" 
                                           placeholder="Nama penerbit" required>
                                    @error('penerbit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="tahun">Tahun</label>
                                    <input type="number" class="form-control @error('tahun') is-invalid @enderror" 
                                           id="tahun" name="tahun" value="{{ old('tahun') }}" 
                                           min="1900" max="{{ date('Y') + 1 }}" placeholder="Kosongkan jika tidak ada">
                                    @error('tahun')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('bukupanduanguru.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Function to add new kode buku input pair
        function tambahKodeBuku() {
            const container = document.getElementById('kode-buku-container');
            const wrapper = document.createElement('div');
            wrapper.classList.add('kode-buku-item', 'mb-3');

            wrapper.innerHTML = `
                <div class="card border-light shadow-sm">
                    <div class="card-body py-2">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Awal</label>
                                <input type="text" name="kode_awal[]" class="form-control" 
                                    placeholder="Contoh: 43898">
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Akhir</label>
                                <input type="text" name="kode_akhir[]" class="form-control" 
                                    placeholder="Contoh: 43903">
                            </div>
                            <div class="col-md-2 text-center">
                                <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="hapusKodeBuku(this)" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            container.appendChild(wrapper);
        }

        // Function to remove kode buku input pair
        function hapusKodeBuku(el) {
            const container = document.getElementById('kode-buku-container');
            const items = container.querySelectorAll('.kode-buku-item');
            
            // Prevent removing if only one item remains
            if (items.length > 1) {
                el.closest('.kode-buku-item').remove();
            } else {
                alert('Minimal harus ada satu kode buku!');
            }
        }
    </script>
@endpush
