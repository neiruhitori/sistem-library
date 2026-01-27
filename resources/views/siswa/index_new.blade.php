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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
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
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title"><i class="fas fa-table"></i> Data Siswa Per Periode</h3>
                </div>
                <div class="card-body">
                    {{-- Filter Periode --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <form action="{{ route('siswa.index') }}" method="GET" id="filterForm">
                                <div class="form-group">
                                    <label for="periode_id">
                                        <i class="fas fa-filter"></i> Filter Periode Tahun Ajaran:
                                    </label>
                                    <select name="periode_id" id="periode_id" class="form-control" onchange="document.getElementById('filterForm').submit()">
                                        <option value="">-- Pilih Periode --</option>
                                        @foreach ($periodes as $periode)
                                            <option value="{{ $periode->id }}" 
                                                {{ $selectedPeriode == $periode->id ? 'selected' : '' }}>
                                                {{ $periode->nama_lengkap }}
                                                @if ($periode->is_active)
                                                    <span class="badge badge-success">(Aktif)</span>
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="mb-3 d-flex flex-wrap gap-2">
                        <a href="{{ route('siswa.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Siswa
                        </a>
                        
                        <!-- Button Import Excel -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            <i class="fas fa-file-excel"></i> Import Excel
                        </button>

                        <!-- Modal Import -->
                        <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title" id="importModalLabel">
                                            <i class="fas fa-file-excel"></i> Import Data Siswa
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle"></i> 
                                            <strong>Petunjuk:</strong>
                                            <ul class="mb-0">
                                                <li>Pilih periode tahun ajaran tujuan import</li>
                                                <li>Download template Excel terlebih dahulu</li>
                                                <li>Isi data siswa sesuai format</li>
                                                <li>Upload kembali file yang sudah diisi</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <a href="{{ route('siswa.download.template') }}" class="btn btn-success btn-block">
                                                <i class="fas fa-download"></i> Download Template Excel
                                            </a>
                                        </div>
                                        
                                        <form action="{{ route('siswa.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            
                                            <div class="form-group">
                                                <label for="import_periode_id">
                                                    Periode Tahun Ajaran <span class="text-danger">*</span>
                                                </label>
                                                <select name="periode_id" id="import_periode_id" class="form-control" required>
                                                    <option value="">-- Pilih Periode --</option>
                                                    @foreach ($periodes as $periode)
                                                        <option value="{{ $periode->id }}" 
                                                            {{ $periode->is_active ? 'selected' : '' }}>
                                                            {{ $periode->nama_lengkap }}
                                                            @if ($periode->is_active)
                                                                (Aktif)
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">
                                                    Data siswa akan diimport ke periode yang dipilih
                                                </small>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="file">Pilih File Excel (.xls / .xlsx) <span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="file" id="file"
                                                    accept=".xlsx,.xls" required>
                                            </div>
                                            
                                            <div class="modal-footer mt-3">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-upload"></i> Import
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Table Data Siswa --}}
                    @if ($selectedPeriode)
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th width="5%">No</th>
                                    <th>NISN</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Absen</th>
                                    <th>L/P</th>
                                    <th>Agama</th>
                                    <th>Status</th>
                                    <th width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswaData as $key => $siswaPeriode)
                                    <tr>
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td>{{ $siswaPeriode->siswa->nisn }}</td>
                                        <td>{{ $siswaPeriode->siswa->name }}</td>
                                        <td>
                                            @php
                                                $kelas = strtoupper($siswaPeriode->kelas);
                                            @endphp
                                            @if (Str::startsWith($kelas, '7'))
                                                <span class="badge badge-success" style="font-size:1rem;">{{ $siswaPeriode->kelas }}</span>
                                            @elseif(Str::startsWith($kelas, '8'))
                                                <span class="badge badge-warning" style="font-size:1rem;">{{ $siswaPeriode->kelas }}</span>
                                            @elseif(Str::startsWith($kelas, '9'))
                                                <span class="badge badge-danger" style="font-size:1rem;">{{ $siswaPeriode->kelas }}</span>
                                            @else
                                                <span class="badge badge-secondary" style="font-size:1rem;">{{ $siswaPeriode->kelas }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $siswaPeriode->absen ?: '-' }}</td>
                                        <td>{{ $siswaPeriode->siswa->jenis_kelamin ?: '-' }}</td>
                                        <td>{{ $siswaPeriode->siswa->agama ?: '-' }}</td>
                                        <td>
                                            @if ($siswaPeriode->status == 'Aktif')
                                                <span class="badge badge-success">{{ $siswaPeriode->status }}</span>
                                            @elseif($siswaPeriode->status == 'Lulus')
                                                <span class="badge badge-info">{{ $siswaPeriode->status }}</span>
                                            @elseif($siswaPeriode->status == 'Pindah')
                                                <span class="badge badge-warning">{{ $siswaPeriode->status }}</span>
                                            @else
                                                <span class="badge badge-secondary">{{ $siswaPeriode->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('siswa.show', $siswaPeriode->siswa->id) }}?periode_id={{ $selectedPeriode }}" 
                                                   class="btn btn-sm btn-secondary" 
                                                   title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('siswa.edit', $siswaPeriode->siswa->id) }}?periode_id={{ $selectedPeriode }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(!empty($siswaPeriode->siswa->nisn))
                                                    <a href="{{ route('siswa.print.card', $siswaPeriode->siswa->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Print Card PDF">
                                                        <i class="fas fa-id-card"></i>
                                                    </a>
                                                @endif
                                                <form action="{{ route('siswa.destroy', $siswaPeriode->siswa->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Apakah kamu yakin ingin hapus?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-danger" title="Hapus Data">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            <i class="fas fa-inbox fa-3x mb-3"></i>
                                            <p>Belum ada data siswa pada periode ini</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-warning text-center">
                            <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                            <p class="mb-0">Silakan pilih periode tahun ajaran terlebih dahulu untuk melihat data siswa</p>
                        </div>
                    @endif
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
                },
                "buttons": [
                    {
                        extend: 'print',
                        text: 'Print',
                        title: '',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        customize: function(win) {
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

                            $(win.document.body).find('table')
                                .addClass('display')
                                .css('font-size', '14px');
                        }
                    },
                    {
                        text: 'PDF',
                        action: function(e, dt, node, config) {
                            var periodeId = $('#periode_id').val();
                            var url = '{{ route("siswa.export.pdf") }}';
                            if (periodeId) {
                                url += '?periode_id=' + periodeId;
                            }
                            window.open(url, '_blank');
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
