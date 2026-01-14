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
            padding: 20px;
        }

        .card, .card-back {
            background: white;
            width: 323px;   /* 85.6mm dalam pixel (85.6 * 3.77 = 323px) */
            height: 204px;  /* 53.98mm dalam pixel (53.98 * 3.77 = 204px) */
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }

        .card-header {
            background: #1e3799;
            background-image: linear-gradient(to right, #1e3799, #4a69bd);
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 13px;
            width: 100%;
            position: relative;
            display: flex;
            align-items: center;
        }

        .card-header * {
            vertical-align: middle;
        }

        .card-header img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 8px;
            object-fit: cover;
        }

        .card-header span {
            background: transparent;
            color: white;
        }

        .card-header::after {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-header::before {
            content: '';
            position: absolute;
            top: -35px;
            right: -35px;
            width: 140px;
            height: 140px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .card-content {
            padding: 12px;
            position: relative;
            height: 110px;
        }

        .qr-code {
            position: absolute;
            left: 12px;
            top: 12px;
            width: 75px;
            height: 75px;
        }

        .qr-code img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .info-container {
            position: absolute;
            left: 100px;
            top: 12px;
            right: 12px;
            height: 85px;
            text-align: left;
            overflow: hidden;
        }

        .student-name {
            font-size: 13px;
            font-weight: bold;
            color: #1a365d;
            margin-bottom: 2px;
            line-height: 0.9;
        }

        .info-item {
            margin: 0px 0;
            display: flex;
            gap: 6px;
            align-items: center;
            line-height: 1.0;
        }

        .info-label {
            font-weight: bold;
            color: #2b4c7e;
            font-size: 10px;
            min-width: 40px;
        }

        .info-value {
            color: #2c3e50;
            font-size: 10px;
            font-weight: 600;
        }

        .year {
            position: absolute;
            bottom: 8px;
            right: 12px;
            color: #718096;
            font-size: 8px;
            font-weight: bold;
        }

        .student-id-label {
            position: absolute;
            top: 8px;
            right: 12px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 9px;
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
            font-size: 13px;
            margin-bottom: 8px;
            text-align: center;
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
        }

        .rules-list {
            font-size: 10px;
            color: #2c3e50;
            padding-left: 18px;
            position: absolute;
            top: 45px;
            left: 15px;
            right: 15px;
        }

        .rules-list li {
            margin-bottom: 3px;
        }

        .signature-section {
            position: absolute;
            bottom: 45px;
            right: 15px;
            font-size: 9px;
            color: #2c3e50;
            text-align: right;
        }

        .signature-line {
            width: 80px;
            height: 1px;
            background: #000;
            margin: 5px 0 5px auto;
        }

        .school-info-back {
            position: absolute;
            bottom: 8px;
            left: 15px;
            right: 15px;
            font-size: 8px;
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
                <div style="width: 30px; height: 30px; background: white; border-radius: 50%; margin-right: 8px;"></div>
            @endif
            <span>SMPN 02 KLAKAH</span>
        </div>
        <div class="student-id-label">Student ID Card</div>
        <div class="card-content">
            <div class="qr-code">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" alt="QR Code">
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
        <div class="year">Valid: {{ date('Y') }}</div>
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
