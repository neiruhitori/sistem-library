@extends('layouts.app')

@section('title', isset($buku) ? 'Edit Buku' : 'Tambah Buku')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book{{ isset($buku) ? '-open' : '' }} text-primary"></i>
                        <span>{{ isset($buku) ? 'Edit Buku' : 'Tambah Buku' }}</span>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i> Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('buku.harian', ['tipe' => $tipe]) }}"><i
                                    class="fas fa-book"></i> Buku {{ ucfirst($tipe) }}</a></li>
                        <li class="breadcrumb-item active">{{ isset($buku) ? 'Edit' : 'Tambah' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-book"></i> Form {{ isset($buku) ? 'Edit' : 'Tambah' }} Buku</h3>
                </div>
                <form method="post" action="{{ isset($buku) ? route('buku.update', $buku->id) : route('buku.store') }}"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @if (isset($buku))
                        @method('PUT')
                    @endif

                    <div class="card-body">
                        <input type="hidden" name="tipe" value="{{ $tipe }}">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="judul" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    name="judul" id="judul" placeholder="Masukkan Judul Buku"
                                    value="{{ old('judul', $buku->judul ?? '') }}">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="penulis" class="form-label">Penulis</label>
                                <input type="text" class="form-control @error('penulis') is-invalid @enderror"
                                    name="penulis" id="penulis" placeholder="Masukkan Nama Penulis"
                                    value="{{ old('penulis', $buku->penulis ?? '') }}">
                                @error('penulis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($tipe === 'tahunan')
                            <div class="col-md-6">
                                <label for="kelas" class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select class="form-control @error('kelas') is-invalid @enderror" name="kelas" id="kelas">
                                    <option value="">-- Pilih Kelas --</option>
                                    <option value="7" {{ old('kelas', $buku->kelas ?? '') == '7' ? 'selected' : '' }}>Kelas 7</option>
                                    <option value="8" {{ old('kelas', $buku->kelas ?? '') == '8' ? 'selected' : '' }}>Kelas 8</option>
                                    <option value="9" {{ old('kelas', $buku->kelas ?? '') == '9' ? 'selected' : '' }}>Kelas 9</option>
                                </select>
                                @error('kelas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Buku ini akan muncul di peminjaman untuk kelas yang dipilih</small>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <label for="penerbit_id" class="form-label">Penerbit</label>
                                <select class="form-control @error('penerbit_id') is-invalid @enderror" name="penerbit_id" id="penerbit_id">
                                    <option value="">-- Pilih Penerbit --</option>
                                    @foreach($penerbits as $penerbit)
                                        <option value="{{ $penerbit->id }}" {{ old('penerbit_id', $buku->penerbit_id ?? '') == $penerbit->id ? 'selected' : '' }}>
                                            {{ $penerbit->penerbit }} - {{ $penerbit->nama_barang }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('penerbit_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">Kode Buku <span class="text-danger">*</span></label>
                                <small class="text-muted d-block mb-3">
                                    <i class="fas fa-info-circle"></i> Masukkan kode awal dan kode akhir yang akan digabungkan menjadi kode buku. 
                                    <strong>Contoh:</strong> Kode Awal "BK" + Kode Akhir "001" = <strong>"BK - 001"</strong>. Boleh mengisi salah satu saja.
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
                                                                    value="{{ $kodeAwal }}" placeholder="Contoh: BK">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Akhir</label>
                                                                <input type="text" name="kode_akhir[]" class="form-control" 
                                                                    value="{{ old('kode_akhir')[$index] ?? '' }}" placeholder="Contoh: 001">
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
                                    @elseif(isset($buku) && $buku->kodeBuku->isNotEmpty())
                                        @foreach ($buku->kodeBuku as $kodeBuku)
                                            @php
                                                // Split kode_buku by ' - ' to get kode_awal and kode_akhir
                                                $parts = explode(' - ', $kodeBuku->kode_buku);
                                                $kodeAwal = $parts[0] ?? '';
                                                $kodeAkhir = $parts[1] ?? '';
                                            @endphp
                                            <div class="kode-buku-item mb-3">
                                                <div class="card border-light shadow-sm">
                                                    <div class="card-body py-2">
                                                        <div class="row align-items-center">
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Awal</label>
                                                                <input type="text" name="kode_awal[]" class="form-control" 
                                                                    value="{{ $kodeAwal }}" placeholder="Contoh: BK">
                                                            </div>
                                                            <div class="col-md-5">
                                                                <label class="small text-muted mb-1">Kode Akhir</label>
                                                                <input type="text" name="kode_akhir[]" class="form-control" 
                                                                    value="{{ $kodeAkhir }}" placeholder="Contoh: 001">
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
                                                                placeholder="Contoh: BK">
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="small text-muted mb-1">Kode Akhir</label>
                                                            <input type="text" name="kode_akhir[]" class="form-control" 
                                                                placeholder="Contoh: 001">
                                                        </div>
                                                        <div class="col-md-2 text-center">
                                                            <label class="small text-muted mb-1 d-block">&nbsp;</label>
                                                            <button type="button" class="btn btn-danger btn-sm" 
                                                                onclick="hapusKodeBuku(this)" title="Hapus range ini">
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

                            <div class="col-md-6">
                                <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
                                <input type="number" min="1900" max="{{ date('Y') }}"
                                    class="form-control @error('tahun_terbit') is-invalid @enderror" name="tahun_terbit"
                                    id="tahun_terbit" placeholder="Masukkan Tahun Terbit"
                                    value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}">
                                @error('tahun_terbit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                    rows="3" placeholder="Masukkan deskripsi buku">{{ old('description', $buku->description ?? '') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="foto" class="form-label">Foto Buku</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    name="foto" id="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if (isset($buku) && $buku->foto)
                                    <div class="mt-2">
                                        <img src="{{ str_starts_with($buku->foto ?? '', 'sampulbuku/') ? asset($buku->foto) : asset('storage/' . ($buku->foto ?? 'default.jpg')) }}" alt="Foto Buku"
                                            style="max-height: 150px;">
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('buku.' . $tipe, ['tipe' => $tipe]) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary"  data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> {{ isset($buku) ? 'Update' : 'Simpan' }} Buku
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ isset($buku) ? 'Update' : 'Simpan' }} Buku?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin {{ isset($buku) ? 'Update' : 'Simpan' }} data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            {{ isset($buku) ? 'Update' : 'Simpan' }}
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
    {{-- Select2 CSS --}}
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    {{-- Select2 JS --}}
    <script src="{{ asset('AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        // Wait for DOM and jQuery to be fully loaded
        $(document).ready(function() {
            console.log('Initializing Select2...');
            
            // Initialize Select2 for penerbit dropdown
            $('#penerbit_id').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Penerbit --',
                allowClear: true,
                width: '100%'
            });
            
            console.log('Select2 initialized');
        });

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
                                    placeholder="Contoh: BK">
                            </div>
                            <div class="col-md-5">
                                <label class="small text-muted mb-1">Kode Akhir</label>
                                <input type="text" name="kode_akhir[]" class="form-control" 
                                    placeholder="Contoh: 001">
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
