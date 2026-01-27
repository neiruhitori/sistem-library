@extends('layouts.app')

@section('title', 'Tambah Peminjaman Tahunan')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0 text-primary" style="font-size: 2rem">
                        <i class="fas fa-book-reader"></i>
                        Tambah Peminjaman Tahunan
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item"><a href="/dashboard"><span class="badge badge-primary"><i
                                        class="fas fa-home"></i> Beranda</span></a></li>
                        <li class="breadcrumb-item"><a href="/peminjamantahunan"><span class="badge badge-primary"><i
                                        class="fas fa-book-reader"></i> Peminjaman Tahunan</span></a></li>
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
                    <h3 class="card-title"><i class="fas fa-edit"></i> Form Tambah Peminjaman Tahunan</h3>
                </div>
                <form method="POST" action="{{ route('peminjamantahunan.store') }}">
                    @csrf
                    <div class="card-body">
                        @if (!$periodeAktif)
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Peringatan:</strong> Tidak ada periode aktif. Silakan aktifkan periode terlebih dahulu di menu Periode Tahun Ajaran.
                            </div>
                        @elseif ($siswaData->isEmpty())
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Informasi:</strong> Tidak ada siswa aktif pada periode {{ $periodeAktif->nama_lengkap }}. Silakan tambahkan siswa terlebih dahulu.
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="siswas_id" class="form-label">
                                    Nama Siswa <span class="text-danger">*</span>
                                    @if ($periodeAktif)
                                        <small class="text-muted">(Periode: {{ $periodeAktif->nama_lengkap }})</small>
                                    @endif
                                </label>
                                <select name="siswas_id" id="siswas_id" class="form-control select2" required {{ $siswaData->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">-- Pilih Siswa --</option>
                                    @foreach ($siswaData as $siswa)
                                        <option value="{{ $siswa['id'] }}" data-kelas="{{ $siswa['kelas'] }}">
                                            {{ $siswa['display_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle"></i> Hanya menampilkan siswa dengan status "Aktif"
                                </small>
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
                                <div class="alert alert-info mb-2">
                                    <i class="fas fa-info-circle"></i> Pilih siswa terlebih dahulu untuk melihat daftar buku sesuai kelas
                                </div>
                                <div id="kode-buku-container">
                                    <div class="input-group mb-2 kode-buku-item">
                                        <select name="kode_buku[]" class="form-control select2-single">
                                            <option value="">-- Pilih Siswa Terlebih Dahulu --</option>
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
                        <a href="{{ route('peminjamantahunan.index') }}" class="btn btn-secondary">
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

                            // Event listener untuk deteksi duplikasi kode buku
                            $(document).on('change', '.select2-single', function() {
                                checkDuplicateBooks();
                            });

                            // Validasi sebelum submit
                            $('form').on('submit', function(e) {
                                if (!validateNoDuplicateBooks()) {
                                    e.preventDefault();
                                    return false;
                                }
                            });

                            // Handle student selection change to filter books by class
                            $('#siswas_id').on('change', function() {
                                const siswaId = $(this).val();
                                
                                if (!siswaId) {
                                    // Clear all book selections if no student selected
                                    $('.select2-single').each(function() {
                                        $(this).empty().append('<option value="">-- Pilih Kode Buku --</option>');
                                    });
                                    return;
                                }

                                // Show loading indicator
                                $('.select2-single').prop('disabled', true);
                                
                                // Fetch filtered books via AJAX
                                $.ajax({
                                    url: '{{ route('peminjamantahunan.getBukuByKelas') }}',
                                    method: 'GET',
                                    data: { siswa_id: siswaId },
                                    success: function(data) {
                                        // Update all book dropdowns
                                        $('.select2-single').each(function() {
                                            const currentValue = $(this).val();
                                            $(this).empty().append('<option value="">-- Pilih Kode Buku --</option>');
                                            
                                            data.forEach(function(item) {
                                                $(this).append(new Option(item.text, item.id, false, item.id == currentValue));
                                            }.bind(this));

                                            // Refresh select2
                                            $(this).trigger('change');
                                        });
                                        
                                        $('.select2-single').prop('disabled', false);
                                    },
                                    error: function() {
                                        alert('Gagal memuat data buku. Silakan coba lagi.');
                                        $('.select2-single').prop('disabled', false);
                                    }
                                });
                            });
                        });

                        function checkDuplicateBooks() {
                            const selectedBooks = [];
                            let hasDuplicate = false;

                            $('.select2-single').each(function() {
                                const value = $(this).val();
                                if (value) {
                                    if (selectedBooks.includes(value)) {
                                        hasDuplicate = true;
                                        $(this).addClass('is-invalid');
                                    } else {
                                        $(this).removeClass('is-invalid');
                                        selectedBooks.push(value);
                                    }
                                }
                            });

                            // Tampilkan/sembunyikan pesan error
                            if (hasDuplicate) {
                                if ($('#duplicate-error').length === 0) {
                                    $('#kode-buku-container').after(
                                        '<div id=\"duplicate-error\" class=\"alert alert-danger mt-2\">' +
                                        '<i class=\"fas fa-exclamation-triangle\"></i> ' +
                                        'Kode buku yang sama tidak boleh dipilih lebih dari sekali!' +
                                        '</div>'
                                    );
                                }
                            } else {
                                $('#duplicate-error').remove();
                            }

                            return !hasDuplicate;
                        }

                        function validateNoDuplicateBooks() {
                            const isValid = checkDuplicateBooks();
                            if (!isValid) {
                                alert('Terdapat kode buku yang sama! Silakan pilih kode buku yang berbeda.');
                            }
                            return isValid;
                        }

                        function tambahKodeBuku() {
                            const siswaId = $('#siswas_id').val();
                            
                            if (!siswaId) {
                                alert('Pilih siswa terlebih dahulu!');
                                return;
                            }

                            const container = document.getElementById('kode-buku-container');
                            const group = document.createElement('div');
                            group.classList.add('input-group', 'mb-2', 'kode-buku-item');

                            group.innerHTML = `
                <select name="kode_buku[]" class="form-control select2-single">
                    <option value="">-- Pilih Kode Buku --</option>
                </select>
                <div class="input-group-append">
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.kode-buku-item').remove(); checkDuplicateBooks();">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;

                            container.appendChild(group);
                            const newSelect = $(group).find('.select2-single');
                            newSelect.select2();

                            // Load books for the new dropdown
                            $.ajax({
                                url: '{{ route('peminjamantahunan.getBukuByKelas') }}',
                                method: 'GET',
                                data: { siswa_id: siswaId },
                                success: function(data) {
                                    newSelect.empty().append('<option value="">-- Pilih Kode Buku --</option>');
                                    
                                    data.forEach(function(item) {
                                        newSelect.append(new Option(item.text, item.id));
                                    });
                                    
                                    newSelect.trigger('change');
                                }
                            });
                        }
                    </script>
                @endpush

            </div>
        </div>
    </div>
@endsection
