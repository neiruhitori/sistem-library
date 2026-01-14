@extends('layouts.app')

@section('title', 'Tambah Peminjaman Harian')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary" style="font-size: 2rem">
                        <i class="fas fa-book-reader"></i>
                        Tambah Peminjaman Harian
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><span class="badge badge-primary"><i
                                        class="fas fa-home"></i> Beranda</span></a></li>
                        <li class="breadcrumb-item"><a href="/peminjamanharian"><span class="badge badge-primary"><i
                                        class="fas fa-book-reader"></i> Peminjaman Harian</span></a></li>
                        <li class="breadcrumb-item active"><span class="badge badge-info"><i class="fas fa-plus"></i>
                                Tambah</span></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card mx-auto shadow" style="max-width: 800px;">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Form Tambah Peminjaman Harian</h3>
                </div>
                
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <form method="POST" action="{{ route('peminjamanharian.store') }}">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="siswas_id" class="form-label">Nama Siswa</label>
                                <select name="siswas_id" id="siswas_id" class="form-control select2">
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswas as $siswa)
                                        <option value="{{ $siswa->id }}">
                                            {{ $siswa->name }} - {{ $siswa->nisn ?? 'Belum ada NISN' }} -
                                            {{ $siswa->kelas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" name="tanggal_pinjam" id="tanggal_pinjam">
                            </div>

                            <div class="col-md-6">
                                <label for="tanggal_kembali" class="form-label">Tanggal Kembali</label>
                                <input type="date" class="form-control" name="tanggal_kembali" id="tanggal_kembali">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Pilih Buku (Kode Buku)</label>
                                <div id="kode-buku-container">
                                    <div class="input-group mb-2 kode-buku-item">
                                        <select name="kode_buku[]" class="form-control select2-single">
                                            <option value="">-- Pilih Kode Buku --</option>
                                            @foreach ($kode_bukus as $kode)
                                                <option value="{{ $kode->id }}"
                                                    {{ $kode->status == 'dipinjam' ? 'disabled' : '' }}>
                                                    {{ $kode->kode_buku }} - {{ $kode->buku->judul ?? '-' }}
                                                    {{ $kode->status == 'dipinjam' ? '(Masih Dipinjam)' : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2"
                                    onclick="tambahKodeBuku()">
                                    + Tambah Buku
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('peminjamanharian.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Buat Pinjaman?
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin ingin menyimpan data?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal
                                        </button>

                                        <button type="submit" class="btn btn-primary waves-light waves-effect"
                                            id="update-modal">
                                            Simpan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @push('styles')
                    <style>
                        select option[disabled] {
                            color: red;
                            font-style: italic;
                        }
                    </style>
                @endpush
                @push('scripts')
                    <!-- Select2 -->
                    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

                    <script>
                        $(document).ready(function() {
                            $('.select2').select2();
                            $('.select2-single').select2();

                            // Set tanggal pinjam ke hari ini
                            const today = new Date().toISOString().split('T')[0];
                            if (!$('#tanggal_pinjam').val()) {
                                $('#tanggal_pinjam').val(today);
                                setTanggalKembali();
                            }

                            // Event listener untuk tanggal pinjam
                            $('#tanggal_pinjam').on('change', function() {
                                setTanggalKembali();
                            });
                        });

                        function setTanggalKembali() {
                            const tanggalPinjam = $('#tanggal_pinjam').val();
                            if (tanggalPinjam) {
                                // Tambah 7 hari (1 minggu)
                                const date = new Date(tanggalPinjam);
                                date.setDate(date.getDate() + 7);
                                const tanggalKembali = date.toISOString().split('T')[0];
                                $('#tanggal_kembali').val(tanggalKembali);
                            }
                        }

                        function tambahKodeBuku() {
                            const container = document.getElementById('kode-buku-container');
                            const group = document.createElement('div');
                            group.classList.add('input-group', 'mb-2', 'kode-buku-item');

                            group.innerHTML = `
                <select name="kode_buku[]" class="form-control select2-single">
                    <option value="">-- Pilih Kode Buku --</option>
                    @foreach ($kode_bukus as $kode)
                        <option value="{{ $kode->id }}">{{ $kode->kode_buku }} - {{ $kode->buku->judul ?? '-' }}</option>
                    @endforeach
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.kode-buku-item').remove()">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                            container.appendChild(group);
                            $(group).find('.select2-single').select2();
                        }
                    </script>
                @endpush

            </div>
        </div>
    </div>
@endsection
