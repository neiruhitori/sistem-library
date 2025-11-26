{{-- <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Lokasi - SMPN 02 Klakah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg" style="max-width: 500px; width: 100%;">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="fas fa-map-marker-alt"></i> Verifikasi Lokasi</h4>
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <i class="fas fa-school fa-3x text-primary mb-3"></i>
                    <h5>Sistem Perpustakaan SMPN 02 Klakah</h5>
                    <p class="text-muted">Sistem ini hanya dapat diakses dari area sekolah</p>
                </div>

                <div id="loading" class="text-center" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Mengambil lokasi Anda...</p>
                </div>

                <div id="content">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Perhatian:</strong> Browser Anda akan meminta izin untuk mengakses lokasi. 
                        Silakan klik "Allow" atau "Izinkan" untuk melanjutkan.
                    </div>

                    <button id="getLocationBtn" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-location-arrow"></i> Dapatkan Lokasi Saya
                    </button>
                    
                    <button id="clearSessionBtn" class="btn btn-warning btn-sm w-100 mt-1">
                        <i class="fas fa-trash"></i> Clear Session & Refresh
                    </button>
                </div>

                <div id="debug-result" class="mt-3" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <h6>Debug Information</h6>
                        </div>
                        <div class="card-body">
                            <pre id="debug-content" style="font-size: 12px; max-height: 300px; overflow-y: auto;"></pre>
                        </div>
                    </div>
                </div>

                <div id="error" class="alert alert-danger mt-3" style="display: none;">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="errorMessage"></span>
                </div>

                <div id="success" class="alert alert-success mt-3" style="display: none;">
                    <i class="fas fa-check-circle"></i>
                    <span id="successMessage"></span>
                </div>
            </div>
            <div class="card-footer text-center text-muted">
                <small>© 2025 SMPN 02 Klakah - Sistem Perpustakaan</small>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('getLocationBtn').addEventListener('click', function() {
            if (!navigator.geolocation) {
                showError('Browser Anda tidak mendukung GPS/Geolocation');
                return;
            }

            showLoading();

            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    
                    // Kirim koordinat ke server
                    fetch('{{ route("location.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            latitude: latitude,
                            longitude: longitude
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        
                        if (data.success) {
                            showSuccess(data.message);
                            setTimeout(() => {
                                window.location.href = data.redirect_url;
                            }, 2000);
                        } else {
                            showError(data.message);
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showError('Terjadi kesalahan saat memverifikasi lokasi');
                    });
                },
                function(error) {
                    hideLoading();
                    let message = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Anda menolak permintaan lokasi. Silakan refresh halaman dan izinkan akses lokasi.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message = 'Permintaan lokasi timeout.';
                            break;
                        default:
                            message = 'Terjadi kesalahan yang tidak diketahui.';
                            break;
                    }
                    showError(message);
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        });

        // Clear Session Button
        document.getElementById('clearSessionBtn').addEventListener('click', function() {
            fetch('/location/clear-session')
                .then(response => response.json())
                .then(data => {
                    alert('Session cleared! Page will refresh.');
                    window.location.reload();
                })
                .catch(error => {
                    alert('Error clearing session');
                });
        });

        function showLoading() {
            document.getElementById('loading').style.display = 'block';
            document.getElementById('content').style.display = 'none';
            document.getElementById('error').style.display = 'none';
            document.getElementById('success').style.display = 'none';
            document.getElementById('debug-result').style.display = 'none';
        }

        function hideLoading() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('content').style.display = 'block';
        }

        function showError(message) {
            document.getElementById('errorMessage').textContent = message;
            document.getElementById('error').style.display = 'block';
            document.getElementById('success').style.display = 'none';
        }

        function showSuccess(message) {
            document.getElementById('successMessage').textContent = message;
            document.getElementById('success').style.display = 'block';
            document.getElementById('error').style.display = 'none';
        }

        function showDebugResult(data) {
            document.getElementById('debug-content').textContent = JSON.stringify(data, null, 2);
            document.getElementById('debug-result').style.display = 'block';
        }
    </script>
</body>
</html> --}}
