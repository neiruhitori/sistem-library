@extends('layouts.app')

@section('title', 'Data Siswa')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-users text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Siswa</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar seluruh siswa SMPN 02 Klakah
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
                                <i class="fas fa-users" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Siswa</span>
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
                    <h3 class="card-title"><i class="fas fa-table"></i> DataTable Siswa</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <a href="{{ route('siswa.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                        <form action="{{ route('siswa.hapussemua') }}" method="POST"
                            onsubmit="return confirm('Yakin hapus semua data siswa?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i> Hapus Semua
                            </button>
                        </form>
                        <!-- Tombol Trigger Modal -->
                        <button type="button" class="btn btn-primary float-sm-right" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>

                        <!-- Modal Import -->
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="importModalLabel">Import Data Siswa</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('siswa.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="form-group">
                                                <label for="file">Pilih File Excel (.xls / .xlsx)</label>
                                                <input type="file" class="form-control" name="file" id="file"
                                                    accept=".xlsx,.xls" required>
                                            </div>
                                            <div class="modal-footer mt-3">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <table id="example1" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>NISN</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswa as $key => $p)
                                <tr>
                                    <td scope="row">{{ $key + 1 }}</td>
                                    <td>{{ $p->nisn }}</td>
                                    <td>{{ $p->name }}</td>
                                    <td>
                                        @php
                                            $kelas = strtoupper($p->kelas);
                                        @endphp
                                        @if (Str::startsWith($kelas, 'VII'))
                                            <span class="badge badge-success"
                                                style="font-size:1rem;">{{ $p->kelas }}</span>
                                        @elseif(Str::startsWith($kelas, 'VIII'))
                                            <span class="badge badge-warning"
                                                style="font-size:1rem;">{{ $p->kelas }}</span>
                                        @elseif(Str::startsWith($kelas, 'IX'))
                                            <span class="badge badge-danger"
                                                style="font-size:1rem;">{{ $p->kelas }}</span>
                                        @else
                                            <span class="badge badge-secondary"
                                                style="font-size:1rem;">{{ $p->kelas }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('siswa.show', $p->id) }}" type="button" class="btn btn-secondary" title="Lihat Detail"><i
                                                    class="fas fa-eye"></i></a>
                                            <a href="{{ route('siswa.edit', $p->id) }}" type="button" class="btn btn-warning" title="Edit Data"><i
                                                    class="fas fa-edit"></i></a>
                                            <a href="{{ route('siswa.print.card', $p->id) }}" type="button" class="btn btn-info" title="Print Card PDF"><i
                                                    class="fas fa-id-card"></i></a>
                                            <a href="{{ route('siswa.print.card.png', $p->id) }}" type="button" class="btn btn-success" title="Download Card PNG (300 DPI)"><i
                                                    class="fas fa-image"></i></a>
                                            <form action="{{ route('siswa.destroy', $p->id) }}" method="POST" class="d-inline"
                                                onsubmit="return confirm('Apakah kamu yakin ingin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger m-0" title="Hapus Data"><i class="fas fa-trash"></i></button>
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">Data Siswa belum Tersedia.</td>
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
    {{-- EXPORT DATA WITH PRINT, PDF, EXCEL --}}
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": true, // Aktifkan dropdown untuk mengubah jumlah data per halaman
                "autoWidth": false,
                "paging": true, // Aktifkan pagination
                "pageLength": 25, // Tampilkan 25 data per halaman (default)
                "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]], // Opsi jumlah data per halaman
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
                },
                "buttons": [{
                        extend: 'print',
                        text: 'Print',
                        title: '',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function(win) {
                            // Kop surat
                            $(win.document.body).prepend(`
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/smp2.png') }}" style="height:90px;">
                                    <div style="text-align:center;flex:1;">
                                        <div style="font-size:18px;font-weight:bold;">PEMERINTAH KABUPATEN LUMAJANG<br>DINAS PENDIDIKAN</div>
                                        <div style="font-size:22px;font-weight:bold;">SMP NEGERI 02 KLAKAH</div>
                                        <div style="font-size:14px;">Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356</div>
                                    </div>
                                    <img src="{{ asset('AdminLTE-3.2.0/dist/img/lumajang.png') }}" style="height:90px;">
                                </div>
                                <hr>
                                <h3 class="text-center" style="margin-top:10px;">Daftar Siswa SMPN 02 Klakah</h3>
                            `);

                            // Tanda tangan
                            $(win.document.body).append(`
                                <div style="width:100%;margin-top:40px;display:flex;justify-content:flex-end;">
                                    <div style="text-align:center;">
                                        <div>Kepala Perpustakaan<br>SMPN 02 Klakah</div>
                                        <br><br><br>
                                        <div style="font-weight:bold;text-decoration:underline;">{{ auth()->user()->name }}</div>
                                        <div>NIP. {{ auth()->user()->nip }}</div>
                                    </div>
                                </div>
                            `);

                            // Table style
                            $(win.document.body).find('table')
                                .addClass('display')
                                .css('font-size', '14px');
                        }
                    },
                    {
                        text: 'PDF',
                        action: function(e, dt, node, config) {
                            window.open('{{ route('siswa.export.pdf') }}', '_blank');
                        },
                        className: 'btn btn-secondary'
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        title: 'Daftar Siswa SMPN 02 Klakah',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
