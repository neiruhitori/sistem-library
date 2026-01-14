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

                            <div class="col-12">
                                <label class="form-label">Kode Buku (bisa lebih dari satu)</label>
                                <div id="kode-buku-container">
                                    @if (old('kode_buku'))
                                        @foreach (old('kode_buku') as $kode)
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="{{ $kode }}" placeholder="Kode Buku">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusKodeBuku(this)">❌</button>
                                            </div>
                                        @endforeach
                                    @elseif(isset($buku))
                                        @foreach ($buku->kodeBuku as $kode)
                                            <div class="input-group mb-2 kode-buku-item">
                                                <input type="text" name="kode_buku[]" class="form-control"
                                                    value="{{ $kode->kode_buku }}" placeholder="Kode Buku">
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="hapusKodeBuku(this)">❌</button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="input-group mb-2 kode-buku-item">
                                            <input type="text" name="kode_buku[]" class="form-control"
                                                placeholder="Kode Buku">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="hapusKodeBuku(this)">❌</button>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" class="btn btn-sm btn-outline-primary mt-1"
                                    onclick="tambahKodeBuku()">+ Tambah Kode</button>

                                @error('kode_buku')
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

                            <div class="col-md-6">
                                <label for="isbn" class="form-label">Kode ISBN</label>
                                <input type="text" class="form-control @error('isbn') is-invalid @enderror"
                                    name="isbn" id="isbn" placeholder="Masukkan Kode ISBN"
                                    value="{{ old('isbn', $buku->isbn ?? '') }}">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="kota_cetak" class="form-label">Kota Cetak</label>
                                <input type="text" class="form-control @error('kota_cetak') is-invalid @enderror"
                                    name="kota_cetak" id="kota_cetak" placeholder="Masukkan Kota Cetak"
                                    value="{{ old('kota_cetak', $buku->kota_cetak ?? '') }}">
                                @error('kota_cetak')
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
                {{-- Tambahkan script untuk dynamic input kode buku --}}
                <script>
                    function tambahKodeBuku() {
                        const container = document.getElementById('kode-buku-container');
                        const wrapper = document.createElement('div');
                        wrapper.classList.add('input-group', 'mb-2', 'kode-buku-item');

                        const input = document.createElement('input');
                        input.type = 'text';
                        input.name = 'kode_buku[]';
                        input.placeholder = 'Kode Buku';
                        input.classList.add('form-control');

                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.classList.add('btn', 'btn-danger', 'btn-sm');
                        btn.textContent = '❌';
                        btn.onclick = function() {
                            wrapper.remove();
                        };

                        wrapper.appendChild(input);
                        wrapper.appendChild(btn);
                        container.appendChild(wrapper);
                    }

                    function hapusKodeBuku(el) {
                        el.closest('.kode-buku-item').remove();
                    }
                </script>
            </div>
        </div>
    </div>
@endsection
