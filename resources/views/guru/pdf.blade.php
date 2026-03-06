<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daftar Guru SMPN 02 Klakah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
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
        <h3>DAFTAR GURU</h3>
        <p>Dicetak pada: {{ date('d/m/Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">NIP</th>
                <th width="30%">Nama</th>
                <th width="25%">Tambahan Tugas</th>
                <th width="20%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gurus as $index => $guru)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $guru->nip ?? '-' }}</td>
                    <td>{{ $guru->nama }}</td>
                    <td>{{ $guru->tambahantugas ?? '-' }}</td>
                    <td>{{ $guru->keterangan ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px;">
        <p><strong>Total Guru: {{ $gurus->count() }}</strong></p>
    </div>
</body>
</html>
