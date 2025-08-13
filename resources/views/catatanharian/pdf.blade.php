<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Catatan Denda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .kop {
            text-align: center;
        }

        .kop img {
            height: 70px;
        }

        .kop .info {
            margin-top: -70px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
        }

        .badge-success {
            background-color: green;
        }

        .badge-danger {
            background-color: red;
        }
    </style>
</head>

<body>
    <div class="kop">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none;">
            <tr>
                <td width="80" style="border: none;">
                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/smp2.png') }}" alt="smp"
                        style="height: 80px;">
                </td>
                <td style="border: none; text-align: center; vertical-align: middle;">
                    <strong style="font-size: 14px;">PEMERINTAH KABUPATEN LUMAJANG</strong><br>
                    <strong style="font-size: 14px;">DINAS PENDIDIKAN</strong><br>
                    <strong style="font-size: 18px;">SMP NEGERI 02 KLAKAH</strong><br>
                    <span style="font-size: 12px;">
                        Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur 67356
                    </span>
                </td>
                <td width="80" style="border: none;">
                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/lumajang.png') }}" alt="kabupaten"
                        style="height: 80px;">
                </td>
            </tr>
        </table>
        <hr>
    </div>

    <h3 style="text-align: center; margin-top: 10px;">Detail Catatan Denda</h3>

    <table>
        <tr>
            <th width="30%">Nama Siswa</th>
            <td>{{ $catatan->siswa->name }}</td>
        </tr>
        <tr>
            <th>NISN</th>
            <td>{{ $catatan->siswa->nisn }}</td>
        </tr>
        <tr>
            <th>Kelas</th>
            <td>{{ $catatan->siswa->kelas }}</td>
        </tr>
        <tr>
            <th>Jenis Denda</th>
            <td>{{ ucfirst($catatan->jenis_denda) }}</td>
        </tr>
        <tr>
            <th>Jumlah Denda</th>
            <td><b>Rp{{ number_format($catatan->jumlah, 0, ',', '.') }}</b></td>
        </tr>
        <tr>
            <th>Tanggal Denda</th>
            <td>{{ \Carbon\Carbon::parse($catatan->tanggal_denda)->translatedFormat('d F Y') }}</td>
        </tr>
        @if ($catatan->status === 'dibayar')
            <tr>
                <th>Tanggal Bayar</th>
                <td>{{ \Carbon\Carbon::parse($catatan->tanggal_bayar)->translatedFormat('d F Y') }}</td>
            </tr>
        @endif
        <tr>
            <th>Status</th>
            <td>
                <b>{{ $catatan->status === 'dibayar' ? 'Lunas' : 'Belum Bayar' }}</b>
            </td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td>{{ $catatan->keterangan ?? '-' }}</td>
        </tr>
    </table>
    @if ($catatan->peminjaman && $catatan->peminjaman->details->count())
        <h4 style="margin-top: 30px;">Detail Buku Terkait</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kode Buku</th>
                    <th>Penulis</th>
                    <th>Tahun</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $detail = $catatan->peminjaman->details->where('id', $catatan->referensi_id)->first();
                @endphp
                @if ($detail)
                    <tr>
                        <td>1</td>
                        <td>{{ $detail->kodeBuku->buku->judul ?? '-' }}</td>
                        <td>{{ $detail->kodeBuku->kode_buku ?? '-' }}</td>
                        <td>{{ $detail->kodeBuku->buku->penulis ?? '-' }}</td>
                        <td>{{ $detail->kodeBuku->buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif
    <div class="ttd">
        <p>Kepala Perpustakaan<br>SMPN 02 Klakah</p>
        <br><br><br>
        <p>
            <strong><u>{{ $catatan->handledByUser->name ?? 'Tidak diketahui' }}</u></strong><br>
            NIP. {{ $catatan->handledByUser->nip ?? '-' }}
        </p>
    </div>
</body>

</html>
