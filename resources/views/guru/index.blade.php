@extends('layouts.app')

@section('title', 'Data Guru')

@section('contents')
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-chalkboard-teacher text-primary" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Guru</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Daftar seluruh guru SMPN 02 Klakah
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
                                <i class="fas fa-chalkboard-teacher" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Guru</span>
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
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow mt-3">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-list"></i> Daftar Guru
                            </h3>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('guru.create') }}" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Guru
                            </a>
                            <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="fas fa-file-import"></i> Import Excel
                            </button>
                            {{-- <a href="{{ route('guru.export.pdf') }}" class="btn btn-secondary" target="_blank">
                                <i class="fas fa-file-pdf"></i> Export PDF
                            </a> --}}
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mb-3 d-flex gap-2">
                        <a href="{{ route('guru.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Tambah Guru
                        </a>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateStatusModal">
                            <i class="fas fa-sync-alt"></i> Update Status Guru
                        </button>
                        <form action="{{ route('guru.hapussemua') }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus semua data guru?')"
                            class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                {{ $userGuruCount == 0 ? 'disabled' : '' }}
                                {{ $userGuruCount == 0 ? 'title="Tidak ada data guru untuk dihapus"' : '' }}>
                                <i class="fas fa-trash-alt"></i> Hapus Semua Data
                                @if($userGuruCount > 0)
                                    <span class="badge badge-light ml-1">{{ $userGuruCount }}</span>
                                @endif
                            </button>
                        </form>
                    </div>

                    <table id="guruTable" class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Tambahan Tugas</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Import -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('guru.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="importModalLabel">Import Data Guru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="file" class="form-label">Pilih File Excel</label>
                            <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls" required>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <a href="{{ route('guru.download.template') }}" class="alert-link">Download template Excel</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload"></i> Upload & Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Update Status Guru -->
    <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="fas fa-sync-alt"></i> Update Status Guru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="bulkUpdateForm">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <label for="newStatus" class="form-label fw-bold">Status Baru:</label>
                                <select name="status" id="newStatus" class="form-control" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Tidak Aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-4 d-flex align-items-end gap-2">
                                <button type="button" id="selectAllModal" class="btn btn-secondary">
                                    <i class="fas fa-check-square"></i> Pilih Semua
                                </button>
                                <button type="button" id="unselectAllModal" class="btn btn-secondary">
                                    <i class="fas fa-square"></i> Batal Pilih
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>Informasi:</strong> Centang guru yang ingin diubah statusnya, pilih status baru, lalu klik "Update Status"
                        </div>

                        {{-- Tabel Guru --}}
                        <div class="table-responsive" style="max-height: 400px;">
                            <table class="table table-bordered table-sm table-hover" id="modalGuruTable">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th width="5%">
                                            <input type="checkbox" id="checkAllModal">
                                        </th>
                                        <th>No</th>
                                        <th>NIP</th>
                                        <th>Nama</th>
                                        <th>Tambahan Tugas</th>
                                        <th>Status Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($guruData as $index => $guru)
                                        <tr class="guru-row">
                                            <td class="text-center">
                                                <input type="checkbox" name="guru_ids[]" 
                                                       value="{{ $guru->id }}" 
                                                       class="guru-checkbox-modal">
                                            </td>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $guru->nip ?? '-' }}</td>
                                            <td>{{ $guru->nama }}</td>
                                            <td>{{ $guru->tambahantugas ?? '-' }}</td>
                                            <td>
                                                @if ($guru->status == 'Aktif')
                                                    <span class="badge badge-success">{{ $guru->status }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ $guru->status }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <span id="selectedCountModal" class="badge badge-primary" style="font-size: 1rem;">
                                0 guru dipilih
                            </span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Tutup
                    </button>
                    <button type="button" id="submitBulkUpdate" class="btn btn-warning" disabled>
                        <i class="fas fa-sync-alt"></i> Update Status
                    </button>
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
            $('#guruTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route("guru.index") }}',
                    type: 'GET',
                    error: function(xhr, error, thrown) {
                        console.error('Error loading data:', error);
                        alert('Terjadi kesalahan saat memuat data. Silakan refresh halaman.');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, width: '5%' },
                    { data: 'nip_display', name: 'nip', width: '12%' },
                    { data: 'nama', name: 'nama', width: '18%' },
                    { data: 'tambahantugas_display', name: 'tambahantugas', width: '18%' },
                    { data: 'keterangan_display', name: 'keterangan', width: '22%' },
                    { data: 'status_display', name: 'status', orderable: false, searchable: false, width: '8%' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, width: '12%' }
                ],
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
                order: [[2, 'asc']],
                language: {
                    processing: '<i class="fas fa-spinner fa-spin"></i> Memproses...',
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    },
                    emptyTable: "Belum ada data guru",
                    zeroRecords: "Data tidak ditemukan"
                },
                drawCallback: function(settings) {
                    $('[data-toggle="tooltip"]').tooltip();
                }
            });
        });

        // Modal Update Status Script
        const checkboxesModal = document.querySelectorAll('.guru-checkbox-modal');
        const checkAllModal = document.getElementById('checkAllModal');
        const selectAllModalBtn = document.getElementById('selectAllModal');
        const unselectAllModalBtn = document.getElementById('unselectAllModal');
        const selectedCountModal = document.getElementById('selectedCountModal');
        const submitBulkUpdate = document.getElementById('submitBulkUpdate');
        const newStatusSelect = document.getElementById('newStatus');

        function updateSelectedCountModal() {
            const checked = document.querySelectorAll('.guru-checkbox-modal:checked').length;
            selectedCountModal.textContent = checked + ' guru dipilih';
            submitBulkUpdate.disabled = checked === 0;
        }

        if (checkAllModal) {
            checkAllModal.addEventListener('change', function() {
                checkboxesModal.forEach(cb => {
                    cb.checked = this.checked;
                });
                updateSelectedCountModal();
            });
        }

        if (selectAllModalBtn) {
            selectAllModalBtn.addEventListener('click', function() {
                checkboxesModal.forEach(cb => {
                    cb.checked = true;
                });
                checkAllModal.checked = true;
                updateSelectedCountModal();
            });
        }

        if (unselectAllModalBtn) {
            unselectAllModalBtn.addEventListener('click', function() {
                checkboxesModal.forEach(cb => cb.checked = false);
                checkAllModal.checked = false;
                updateSelectedCountModal();
            });
        }

        checkboxesModal.forEach(cb => {
            cb.addEventListener('change', updateSelectedCountModal);
        });

        // Submit bulk update
        if (submitBulkUpdate) {
            submitBulkUpdate.addEventListener('click', function() {
                const checkedIds = Array.from(document.querySelectorAll('.guru-checkbox-modal:checked'))
                    .map(cb => cb.value);
                const status = newStatusSelect.value;

                if (checkedIds.length === 0) {
                    alert('Silakan pilih minimal 1 guru');
                    return;
                }

                if (!status) {
                    alert('Silakan pilih status baru');
                    return;
                }

                if (!confirm(`Yakin ingin mengubah status ${checkedIds.length} guru menjadi "${status}"?`)) {
                    return;
                }

                // Show loading
                submitBulkUpdate.disabled = true;
                submitBulkUpdate.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

                // Send AJAX request
                fetch('{{ route("guru.bulkUpdateStatus") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        guru_ids: checkedIds,
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Gagal: ' + data.message);
                        submitBulkUpdate.disabled = false;
                        submitBulkUpdate.innerHTML = '<i class="fas fa-sync-alt"></i> Update Status';
                    }
                })
                .catch(error => {
                    alert('Terjadi kesalahan: ' + error);
                    submitBulkUpdate.disabled = false;
                    submitBulkUpdate.innerHTML = '<i class="fas fa-sync-alt"></i> Update Status';
                });
            });
        }
    </script>
@endpush
