# Sistem Perpustakaan SMPN 02 Klakah

Sistem manajemen perpustakaan berbasis web untuk SMPN 02 Klakah dengan fitur pembatasan akses lokasi menggunakan GPS.

## Fitur Utama

### 📚 Manajemen Perpustakaan
- **Manajemen Siswa** - CRUD data siswa dengan import Excel
- **Manajemen Buku** - Kategori Harian dan Tahunan
- **Peminjaman & Pengembalian** - Tracking lengkap peminjaman
- **Catatan Denda** - Sistem denda otomatis dengan integrasi Midtrans
- **Laporan Kelas** - Laporan per kelas dan detail siswa

### 🔐 Sistem Multi-User
- **User Isolation** - Data terpisah per user/petugas
- **Notifikasi Personal** - Notifikasi khusus per user
- **Authentication** - Login sistem yang aman

### 📍 Location-Based Access Control
- **GPS Restriction** - Sistem hanya dapat diakses dari area sekolah
- **Radius Control** - Pembatasan akses dalam radius 200m dari sekolah
- **Real-time Validation** - Validasi lokasi secara real-time
- **Admin Interface** - Kelola lokasi yang diizinkan via web interface

## Instalasi

1. **Clone repository**
   ```bash
   git clone https://github.com/neiruhitori/sistem-library.git
   cd sistem-library
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup database**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Jalankan server**
   ```bash
   php artisan serve
   ```

## Konfigurasi Location Restriction

### Setup Lokasi Sekolah
1. Login ke sistem sebagai admin
2. Akses menu **"Kelola Lokasi Akses"** di sidebar
3. Tambah lokasi SMPN 02 Klakah dengan koordinat GPS
4. Atur radius pembatasan (default: 200 meter)

### Commands untuk Testing
```bash
# Test lokasi dengan koordinat tertentu
php artisan test:location -- -8.076389 113.746111

# Bypass location restriction untuk development
php artisan location:bypass enable
php artisan config:clear

# Aktifkan kembali location restriction
php artisan location:bypass disable
php artisan config:clear
```

## Struktur Location Restriction

### Middleware
- `LocationRestriction` - Middleware utama untuk validasi GPS
- Support bypass mode via environment variable `LOCATION_BYPASS`

### Model & Database
- `AllowedLocation` - Model untuk mengelola lokasi yang diizinkan
- Tabel `allowed_locations` dengan koordinat GPS dan radius
- Haversine formula untuk kalkulasi jarak

### Controllers
- `LocationController` - Handle GPS collection dan validation
- `AllowedLocationController` - Admin interface untuk kelola lokasi

### Views
- `location/check.blade.php` - Halaman request GPS permission
- `location/denied.blade.php` - Halaman akses ditolak
- `admin/allowed-locations/` - Interface admin kelola lokasi

## Tech Stack

- **Backend:** Laravel 11, PHP 8.2+
- **Frontend:** AdminLTE, Bootstrap 4, jQuery
- **Database:** SQLite/MySQL
- **GPS:** Browser Geolocation API, Google Maps
- **Payment:** Midtrans Integration
- **Others:** Haversine Formula untuk distance calculation

## Production Deployment

1. **Set environment ke production**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   LOCATION_BYPASS=false
   ```

2. **Optimize aplikasi**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Setup koordinat sekolah**
   - Akses admin panel
   - Input koordinat GPS SMPN 02 Klakah: `-8.076389, 113.746111`
   - Set radius: `200` meter

## Security Features

- ✅ **GPS-based Access Control** - Hanya bisa diakses dari area sekolah
- ✅ **Session Management** - Koordinat user tersimpan di session
- ✅ **CSRF Protection** - Proteksi dari CSRF attacks
- ✅ **User Isolation** - Data terpisah antar user
- ✅ **SQL Injection Prevention** - Eloquent ORM protection

## Browser Support

- ✅ Chrome 50+
- ✅ Firefox 55+
- ✅ Safari 11+
- ✅ Edge 79+
- ⚠️ **Requires HTTPS** untuk Geolocation API di production

## License

Proyek ini menggunakan [MIT License](https://opensource.org/licenses/MIT).
