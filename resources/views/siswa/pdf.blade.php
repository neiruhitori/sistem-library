<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Siswa SMPN 02 Klakah</title>
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

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 6px;
            text-align: center;
        }

        .ttd {
            margin-top: 50px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="kop">
        <table width="100%" cellpadding="0" cellspacing="0" style="border: none; border-collapse: collapse;">
            <tr>
                <td width="80" style="border: none;">
                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/smp2.png') }}" alt="smp"
                        style="height: 80px;">
                </td>
                <td align="center" style="border: none;">
                    <strong style="font-size: 14px;">PEMERINTAH KABUPATEN LUMAJANG</strong><br>
                    <strong style="font-size: 14px;">DINAS PENDIDIKAN</strong><br>
                    <strong style="font-size: 18px;">SMP NEGERI 02 KLAKAH</strong><br>
                    <span style="font-size: 12px;">Jl. Ranu No.23, Linduboyo, Klakah, Kabupaten Lumajang, Jawa Timur
                        67356</span>
                </td>
                <td width="80" style="border: none;">
                    <img src="{{ public_path('AdminLTE-3.2.0/dist/img/lumajang.png') }}" alt="kabupaten"
                        style="height: 80px;">
                </td>
            </tr>
        </table>

        <hr>
    </div>

    <h3 style="text-align: center; margin-top: 10px;">Daftar Siswa SMPN 02 Klakah</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Absen</th>
                <th>L/P</th>
                <th>Agama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($siswa as $no => $s)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $s->nisn }}</td>
                    <td style="text-align: left">{{ $s->name }}</td>
                    <td>{{ $s->kelas }}</td>
                    <td>{{ $s->absen ?: '-' }}</td>
                    <td>{{ $s->jenis_kelamin ?: '-' }}</td>
                    <td>{{ $s->agama ?: '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd">
        <p>Kepala Perpustakaan<br>SMPN 02 Klakah</p>
        <br><br><br>
        <p><strong><u>{{ auth()->user()->name }}</u></strong><br>NIP. {{ auth()->user()->nip }}</p>
    </div>
</body>

</html>
