<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Ditolak - SMPN 02 Klakah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-danger text-white text-center">
                <h4><i class="fas fa-ban"></i> Akses Ditolak</h4>
            </div>
            <div class="card-body p-4 text-center">
                <i class="fas fa-map-marker-alt fa-4x text-danger mb-4"></i>
                
                <h5 class="text-danger mb-3">Lokasi Tidak Diizinkan</h5>
                
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Maaf!</strong> Sistem Perpustakaan SMPN 02 Klakah hanya dapat diakses dari area sekolah.
                </div>

                <div class="mb-4">
                    <h6>Lokasi yang Diizinkan:</h6>
                    <p class="text-muted">
                        <i class="fas fa-school"></i> Area SMPN 02 Klakah<br>
                        <small>Radius maksimal 200 meter dari area sekolah</small>
                    </p>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('location.check') }}" class="btn btn-primary">
                        <i class="fas fa-redo"></i> Coba Verifikasi Ulang
                    </a>
                    
                    <a href="{{ route('logout') }}" class="btn btn-outline-secondary" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
            <div class="card-footer text-center text-muted">
                <small>© 2025 SMPN 02 Klakah - Sistem Perpustakaan</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
