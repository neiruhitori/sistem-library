<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Detail Siswa - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
      <!-- Statistik Peminjaman -->
    <div class="stats-box">
        <div class="stat-item">
            <div class="stat-number">{{ $peminjamanHarian->sum(function($p) { return $p->details->count(); }) }}</div>
            <div class="stat-label">Peminjaman Harian</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $peminjamanTahunan->sum(function($p) { return $p->details->count(); }) }}</div>
            <div class="stat-label">Peminjaman Tahunan</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $peminjamanHarian->sum(function($p) { return $p->details->count(); }) + $peminjamanTahunan->sum(function($p) { return $p->details->count(); }) }}</div>
            <div class="stat-label">Total Peminjaman</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $catatanDenda->count() }}</div>
            <div class="stat-label">Aktivitas Denda</div>
        </div>
    </div>ng: 20px;
            font-size: 12px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            color: #666;
        }
        
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .text-center {
            text-align: center;
        }
        
        .badge {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #000;
        }
        
        .badge-success {
            background: #28a745;
        }
        
        .badge-danger {
            background: #dc3545;
        }
        
        .badge-secondary {
            background: #6c757d;
        }
        
        .badge-male {
            background: #17a2b8;
        }
        
        .badge-female {
            background: #ffc107;
            color: #000;
        }
        
        .no-data {
            text-align: center;
            padding: 30px;
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #666;
        }
        
        .signature {
            margin-top: 40px;
            text-align: right;
        }
        
        .signature-box {
            display: inline-block;
            text-align: center;
            min-width: 200px;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 50px;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERPUSTAKAAN SMPN 02 KLAKAH</h1>
        <h2>DETAIL SISWA</h2>
    </div>
    
    <!-- Data Siswa -->
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
        <p style="margin: 3px 0;"><strong>Nama Lengkap</strong> : {{ $siswa->name }}</p>
        <p style="margin: 3px 0;"><strong>NISN</strong> : {{ $siswa->nisn ?? 'N/A' }}</p>
        <p style="margin: 3px 0;"><strong>Kelas</strong> : {{ $siswa->kelas }}</p>
        <p style="margin: 3px 0;"><strong>Terdaftar</strong> : {{ $siswa->created_at->format('d F Y') }}</p>
        <p style="margin: 3px 0;"><strong>Tanggal Cetak</strong> : {{ $tanggalCetak }}</p>
    </div>
    
    <!-- Statistik Peminjaman -->
    <div style="margin-bottom: 20px; padding: 10px; border: 1px solid #ddd;">
        <p style="margin: 3px 0;"><strong>Peminjaman Harian</strong> : {{ $peminjamanHarian->sum(function($p) { return $p->details->count(); }) }}</p>
        <p style="margin: 3px 0;"><strong>Peminjaman Tahunan</strong> : {{ $peminjamanTahunan->sum(function($p) { return $p->details->count(); }) }}</p>
        <p style="margin: 3px 0;"><strong>Total Peminjaman</strong> : {{ $peminjamanHarian->sum(function($p) { return $p->details->count(); }) + $peminjamanTahunan->sum(function($p) { return $p->details->count(); }) }}</p>
        <p style="margin: 3px 0;"><strong>Aktivitas Denda</strong> : {{ $catatanDenda->count() }}</p>
    </div>
    
    <!-- Riwayat Peminjaman Harian -->
    <div class="section-title">RIWAYAT PEMINJAMAN HARIAN</div>
    @if($peminjamanHarian->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal Pinjam</th>
                <th style="width: 15%">Tanggal Kembali</th>
                <th style="width: 35%">Buku</th>
                <th style="width: 15%">Kode Buku</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($peminjamanHarian as $harian)
                @foreach($harian->details as $detail)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $harian->tanggal_pinjam }}</td>
                    <td>{{ $harian->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                    <td>{{ $detail->kodeBuku->buku->judul ?? 'N/A' }}</td>
                    <td>
                        <span class="badge">{{ $detail->kodeBuku->kode_buku ?? 'N/A' }}</span>
                    </td>
                    <td>
                        @if($harian->status == 'dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                        @elseif($harian->status == 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($harian->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Belum ada riwayat peminjaman harian
    </div>
    @endif
    
    <!-- Riwayat Peminjaman Tahunan -->
    <div class="section-title">RIWAYAT PEMINJAMAN TAHUNAN</div>
    @if($peminjamanTahunan->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Tanggal Pinjam</th>
                <th style="width: 15%">Tanggal Kembali</th>
                <th style="width: 35%">Buku</th>
                <th style="width: 15%">Kode Buku</th>
                <th style="width: 15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($peminjamanTahunan as $tahunan)
                @foreach($tahunan->details as $detail)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $tahunan->tanggal_pinjam }}</td>
                    <td>{{ $tahunan->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                    <td>{{ $detail->kodeBuku->buku->judul ?? 'N/A' }}</td>
                    <td>
                        <span class="badge">{{ $detail->kodeBuku->kode_buku ?? 'N/A' }}</span>
                    </td>
                    <td>
                        @if($tahunan->status == 'dipinjam')
                            <span class="badge badge-warning">Dipinjam</span>
                        @elseif($tahunan->status == 'selesai')
                            <span class="badge badge-success">Selesai</span>
                        @else
                            <span class="badge badge-secondary">{{ ucfirst($tahunan->status) }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Belum ada riwayat peminjaman tahunan
    </div>
    @endif
    
    <!-- Aktivitas Denda -->
    <h3>Aktivitas Denda</h3>
    @if($catatanDenda->count() > 0)
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Jumlah Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($catatanDenda as $index => $denda)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $denda->created_at->format('d/m/Y') }}</td>
                <td>{{ $denda->keterangan ?? 'Denda keterlambatan' }}</td>
                <td>Rp {{ number_format($denda->jumlah ?? 0, 0, ',', '.') }}</td>
                <td>
                    @if($denda->status == 'dibayar')
                        <span class="badge badge-success">Lunas</span>
                    @else
                        <span class="badge badge-warning">Belum Lunas</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        Tidak ada aktivitas denda
    </div>
    @endif
    
    <div class="signature">
        <div class="signature-box">
            <p>Klakah, {{ $tanggalCetak }}</p>
            <p>Kepala Perpustakaan</p>
            <div class="signature-line">
                <u>{{ $kepalaPerpustakaan->nama }}</u></strong><br>NIP. {{ $kepalaPerpustakaan->nip }}
            </div>
        </div>
    </div>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }} | Sistem Perpustakaan SMPN 02 Klakah</p>
    </div>
</body>
</html>
