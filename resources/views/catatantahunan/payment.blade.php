@extends('layouts.app')

@section('title', 'Pembayaran Denda')

@section('contents')
    <div class="container mt-5" style="max-width: 700px;">
        <div class="card shadow">
            @if (session('success') || session('info'))
                @php
                    $alertType = session('success') ? 'success' : 'info';
                    $alertMessage = session('success') ?: session('info');
                    $alertIcon = session('success') ? 'check-circle' : 'info-circle';
                @endphp
                <div class="alert alert-{{ $alertType }} alert-dismissible fade show mt-2" role="alert" id="alert-session">
                    <i class="fas fa-{{ $alertIcon }}"></i> {{ $alertMessage }}
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-session')?.classList.remove('show'), 4000);
                </script>
            @endif
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Konfirmasi Pembayaran Denda (Cash)</h4>
            </div>
            <div class="card-body">
                <p><strong>Nama Siswa:</strong> {{ $catatan->siswa->name }}</p>
                <p><strong>Kelas:</strong> {{ $catatan->siswa->kelas }}</p>
                <p><strong>Jenis Denda:</strong> {{ ucfirst($catatan->jenis_denda) }}</p>
                <p><strong>Jumlah Tagihan:</strong>
                    <span class="badge badge-pill badge-warning">
                        Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}
                    </span>
                </p>
                <p><strong>Status:</strong>
                    <span class="badge badge-{{ $catatan->status == 'dibayar' ? 'success' : 'danger' }}">
                        {{ $catatan->status == 'dibayar' ? 'Lunas' : 'Belum Dibayar' }}
                    </span>
                </p>

                {{-- Tombol pembayaran --}}
                @if ($catatan->status === 'belum_dibayar')
                    <div class="text-center mt-4">
                        <button class="btn btn-success" data-toggle="modal" data-target="#confirmModal">
                            <i class="fas fa-check-circle"></i> Bayar via Cash
                        </button>
                    </div>
                @endif

                <div class="text-center mt-3">
                    <a href="{{ route('catatantahunan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="fas fa-exclamation-circle"></i> Konfirmasi Pembayaran Cash
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin pembayaran <strong>tunai</strong> sebesar<br>
                    <span class="text-primary">Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}</span> sudah dilakukan?
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="{{ route('catatantahunan.processPayment', $catatan->id) }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Sudah Dibayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
