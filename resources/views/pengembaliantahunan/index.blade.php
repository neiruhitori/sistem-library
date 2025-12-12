@extends('layouts.app')

@section('title', 'Pengembalian Tahunan')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-book-reader text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Pengembalian Tahunan</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar pengembalian tahunan buku SMPN 02 Klakah
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
                                <span class="align-middle">Pengembalian Tahunan</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> Tabel Pengembalian Tahunan</h3>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nama Siswa</th>
                                <th>Kode Buku</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($details as $detail)
                                <tr>
                                    <td>{{ $detail->peminjaman->siswa->name }}</td>
                                    <td>{{ $detail->kodeBuku->kode_buku ?? '-' }}</td>
                                    <td>{{ $detail->kodeBuku->buku->judul ?? '-' }}</td>
                                    <td>{{ $detail->peminjaman->tanggal_pinjam }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-success"
                                            onclick="openModalPengembalian('{{ route('pengembaliantahunan.update', $detail->id) }}')">
                                            <i class="fas fa-check"></i> Kembalikan
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Tambahkan di paling bawah halaman, sebelum </body> -->
                    <div class="modal fade" id="modalKondisiBuku" tabindex="-1" aria-labelledby="modalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" id="formPengembalian">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Konfirmasi Pengembalian Buku</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Pilih kondisi buku saat dikembalikan:</p>
                                        <select name="kondisi_buku" id="kondisiBukuSelect" class="form-control" required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="baik">Baik (Tanpa Denda)</option>
                                            <option value="terlambat">Terlambat (Denda Rp 1.000/hari)</option>
                                            <option value="rusak">Rusak (Denda Rp 10.000)</option>
                                            <option value="hilang">Hilang (Denda Rp 50.000)</option>
                                        </select>

                                        <!-- Sub-pilihan untuk jenis kerusakan -->
                                        <div id="jenisKerusakanWrapper" style="display: none; margin-top: 15px;">
                                            <label for="jenisKerusakanSelect"><strong>Pilih Jenis Kerusakan:</strong></label>
                                            <select name="jenis_kerusakan" id="jenisKerusakanSelect" class="form-control">
                                                <option value="">-- Pilih Jenis Kerusakan --</option>
                                                <option value="Corat-coret">Corat-coret</option>
                                                <option value="Sobek halaman">Sobek halaman</option>
                                                <option value="Cover rusak">Cover rusak</option>
                                                <option value="Jilid lepas">Jilid lepas</option>
                                                <option value="Basah/Terkena air">Basah/Terkena air</option>
                                                <option value="Rusak parah (tidak bisa dipinjam)">Rusak parah (tidak bisa dipinjam)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success" id="submitPengembalian"
                                            disabled>Kembalikan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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
    <script>
        function openModalPengembalian(url) {
            const form = document.getElementById('formPengembalian');
            form.action = url;
            const modal = new bootstrap.Modal(document.getElementById('modalKondisiBuku'));
            modal.show();
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('kondisiBukuSelect');
            const submitButton = document.getElementById('submitPengembalian');
            const jenisKerusakanWrapper = document.getElementById('jenisKerusakanWrapper');
            const jenisKerusakanSelect = document.getElementById('jenisKerusakanSelect');

            select.addEventListener('change', function() {
                if (select.value === 'rusak') {
                    // Tampilkan pilihan jenis kerusakan
                    jenisKerusakanWrapper.style.display = 'block';
                    jenisKerusakanSelect.required = true;
                    submitButton.setAttribute('disabled', true);
                } else {
                    // Sembunyikan pilihan jenis kerusakan
                    jenisKerusakanWrapper.style.display = 'none';
                    jenisKerusakanSelect.required = false;
                    jenisKerusakanSelect.value = '';
                    
                    if (select.value !== '') {
                        submitButton.removeAttribute('disabled');
                    } else {
                        submitButton.setAttribute('disabled', true);
                    }
                }
            });

            // Validasi untuk jenis kerusakan
            jenisKerusakanSelect.addEventListener('change', function() {
                if (jenisKerusakanSelect.value !== '' && select.value === 'rusak') {
                    submitButton.removeAttribute('disabled');
                } else {
                    submitButton.setAttribute('disabled', true);
                }
            });
        });
    </script>
@endpush
