<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Buku Panduan Guru SMPN 02 Klakah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SMPN 02 KLAKAH</h2>
        <h3>IDENTITAS BUKU PANDUAN GURU</h3>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="10%">Kode Awal</th>
                <th width="10%">Kode Akhir</th>
                <th width="20%">Penulis</th>
                <th width="35%">Judul Buku</th>
                <th width="15%">Penerbit</th>
                <th width="5%">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukus as $index => $buku)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->kode_awal }}</td>
                    <td>{{ $buku->kode_akhir }}</td>
                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->penerbit }}</td>
                    <td>{{ $buku->tahun }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Total Buku Panduan Guru: {{ $bukus->count() }}</strong></p>
    </div>
</body>
</html>
