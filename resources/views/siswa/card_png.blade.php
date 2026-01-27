<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .card, .card-back {
            background: white;
            width: {{ $width }}px;   /* 85.6mm dalam pixel @ 300 DPI (85.6 * 11.81 = 1012px) */
            height: {{ $height }}px;  /* 53.98mm dalam pixel @ 300 DPI (53.98 * 11.81 = 640px) */
            border-radius: 24px;
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            margin-bottom: 60px;
        }

        .card-header {
            background: #1e3799;
            background-image: linear-gradient(to right, #1e3799, #4a69bd);
            color: white;
            padding: 24px 36px;
            font-weight: bold;
            font-size: 39px;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
        }

        .card-header * {
            vertical-align: middle;
        }

        .card-header img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            margin-right: 24px;
            object-fit: cover;
        }

        .card-header span {
            background: transparent;
            color: white;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: -60px;
            right: -60px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -105px;
            right: -105px;
            width: 420px;
            height: 420px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-content {
            padding: 36px;
            position: relative;
            height: 330px;
        }

        .qr-code {
            position: absolute;
            left: 36px;
            top: 36px;
            width: 225px;
            height: 225px;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .info-container {
            position: absolute;
            left: 300px;
            top: 36px;
            right: 36px;
            height: 255px;
            text-align: left;
            overflow: hidden;
        }

        .student-name {
            font-size: 39px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 6px;
            line-height: 0.9;
        }

        .info-item {
            margin: 0px 0;
            display: flex;
            gap: 18px;
            align-items: center;
            line-height: 1.0;
        }

        .info-label {
            font-weight: bold;
            color: #2b4c7e;
            font-size: 30px;
            min-width: 120px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 30px;
            font-weight: 600;
        }

        .year {
            position: absolute;
            bottom: 24px;
            right: 36px;
            color: #718096;
            font-size: 24px;
            font-weight: bold;
        }

        .student-id-label {
            position: absolute;
            top: 24px;
            right: 36px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 27px;
            font-weight: normal;
            z-index: 10;
        }

        /* BACK CARD STYLES */
        .card-back {
            background: white;
        }

        .rules-title {
            color: #1e3799;
            font-weight: bold;
            font-size: 39px;
            margin-bottom: 24px;
            text-align: center;
            position: absolute;
            top: 45px;
            left: 45px;
            right: 45px;
        }

        .rules-list {
            font-size: 30px;
            color: #2c3e50;
            padding-left: 54px;
            position: absolute;
            top: 135px;
            left: 45px;
            right: 45px;
        }

        .rules-list li {
            margin-bottom: 9px;
        }

        .signature-section {
            position: absolute;
            bottom: 135px;
            right: 45px;
            font-size: 27px;
            color: #2c3e50;
            text-align: right;
        }

        .signature-line {
            width: 240px;
            height: 3px;
            background: #000;
            margin: 15px 0 15px auto;
        }

        .school-info-back {
            position: absolute;
            bottom: 24px;
            left: 45px;
            right: 45px;
            font-size: 24px;
            color: #666;
            text-align: center;
            line-height: 1.2;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            @if($logoBase64)
                <img src="data:image/png;base64,{{ $logoBase64 }}" alt="Logo">
            @else
                <div style="width: 90px; height: 90px; background: white; border-radius: 50%; margin-right: 24px;"></div>
            @endif
            <span>SMPN 02 KLAKAH</span>
        </div>
        <div class="student-id-label">Student ID Card</div>
        <div class="card-content">
            <div class="qr-code">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code">
            </div>
            <div class="info-container">
                <div class="student-name">{{ strtoupper($siswa->name) }}</div>
                <div class="info-item">
                    <span class="info-label">NISN:</span>
                    <span class="info-value">{{ $siswa->nisn ?: '-' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelas:</span>
                    <span class="info-value">{{ strtoupper($siswa->kelas) }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">L/P:</span>
                    <span class="info-value">{{ $siswa->jenis_kelamin ?: '-' }}</span>
                </div>
            </div>
        </div>
        {{-- <div class="year">Valid: {{ date('Y') }}</div> --}}
    </div>

    <div class="card-back">
        <div class="rules-title">TATA TERTIB PERPUSTAKAAN</div>
        <ol class="rules-list">
            <li>Kartu ini adalah milik sekolah dan tidak boleh dipinjamkan</li>
            <li>Wajib dibawa setiap kali berkunjung ke perpustakaan</li>
            <li>Jika hilang segera lapor ke Tata Usaha</li>
            <li>Berlaku selama menjadi siswa aktif SMPN 02 Klakah</li>
            <li>Dilarang merusak atau mengubah kartu ini</li>
        </ol>
        
        <div class="signature-section">
            Klakah, {{ date('d M Y') }}
            <div class="signature-line"></div>
            <div>Tanda Tangan Siswa</div>
        </div>
        
        <div class="school-info-back">
            <strong>SMPN 02 KLAKAH</strong><br>
            Jl. Raya Klakah No. 123, Klakah, Lumajang<br>
            Jawa Timur 67371 | Telp: (0334) 123456<br>
            <small>ID: {{ str_pad($siswa->id, 4, '0', STR_PAD_LEFT) }} | Sistem Perpustakaan Digital</small>
        </div>
    </div>
</body>
</html>
