

<?php $__env->startSection('title', 'Edit Lokasi Akses'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="content-header mx-auto mt-3" style="max-width: 98%;">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <i class="fas fa-edit text-warning" style="font-size:2rem;"></i>
                        <span style="font-size:2rem;">Edit Lokasi Akses</span>
                    </h1>
                    <div class="text-muted fw-bold" style="font-size:1.25rem;">
                        Edit lokasi: <?php echo e($allowedLocation->name); ?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-light px-2 py-1 rounded shadow-sm">
                        <li class="breadcrumb-item">
                            <a href="/dashboard">
                                <span class="badge badge-primary" style="font-size:1.1rem;">
                                    <i class="fas fa-home" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Dashboard</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?php echo e(route('admin.allowed-locations.index')); ?>">
                                <span class="badge badge-info" style="font-size:1.1rem;">
                                    <i class="fas fa-map-marker-alt" style="font-size:1.2rem;"></i>
                                    <span class="align-middle">Lokasi Akses</span>
                                </span>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            <span class="badge badge-warning" style="font-size:1.1rem;">
                                <i class="fas fa-edit" style="font-size:1.2rem;"></i>
                                <span class="align-middle">Edit</span>
                            </span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            
            <?php if($errors->any()): ?>
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert" id="alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <ul class="mb-0">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                        let alert = document.getElementById('alert-error');
                        if(alert){
                            alert.classList.remove('show');
                            alert.classList.add('fade');
                        }
                    }, 4000);
                </script>
            <?php endif; ?>

            <div class="card mx-auto mt-3 shadow" style="max-width: 98%;">
                <div class="card-header bg-warning text-dark">
                    <h3 class="card-title"><i class="fas fa-edit"></i> Form Edit Lokasi Akses</h3>
                </div>
                <form action="<?php echo e(route('admin.allowed-locations.update', $allowedLocation)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nama Lokasi *</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="name" name="name" value="<?php echo e(old('name', $allowedLocation->name)); ?>" 
                                       placeholder="Contoh: SMPN 02 Klakah">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="radius_meters" class="form-label">Radius (meter) *</label>
                                <input type="number" class="form-control <?php $__errorArgs = ['radius_meters'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="radius_meters" name="radius_meters" value="<?php echo e(old('radius_meters', $allowedLocation->radius_meters)); ?>" 
                                       min="1" max="5000" placeholder="200">
                                <?php $__errorArgs = ['radius_meters'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <small class="form-text text-muted">Jarak maksimum yang diizinkan dari lokasi (1-5000 meter)</small>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude *</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="latitude" name="latitude" value="<?php echo e(old('latitude', $allowedLocation->latitude)); ?>" 
                                       placeholder="-8.076389" step="any">
                                <?php $__errorArgs = ['latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="form-label">Longitude *</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="longitude" name="longitude" value="<?php echo e(old('longitude', $allowedLocation->longitude)); ?>" 
                                       placeholder="113.746111" step="any">
                                <?php $__errorArgs = ['longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="description" name="description" rows="3" 
                                          placeholder="Deskripsi lokasi..."><?php echo e(old('description', $allowedLocation->description)); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-12">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                                           <?php echo e(old('is_active', $allowedLocation->is_active) ? 'checked' : ''); ?>>
                                    <label class="custom-control-label" for="is_active">Status Aktif</label>
                                </div>
                            </div>
                        </div>

                        <hr class="mt-4">
                        
                        <div class="row">
                            <div class="col-md-12">
                                <h5><i class="fas fa-info-circle text-info"></i> Informasi Lokasi Saat Ini</h5>
                                <div class="alert alert-info">
                                    <strong><?php echo e($allowedLocation->name); ?></strong><br>
                                    <span class="coordinate-display">Lat: <?php echo e($allowedLocation->latitude); ?></span>, 
                                    <span class="coordinate-display">Lng: <?php echo e($allowedLocation->longitude); ?></span><br>
                                    Radius: <span class="badge badge-primary"><?php echo e($allowedLocation->radius_meters); ?>m</span>
                                    <br>
                                    <a href="https://maps.google.com/?q=<?php echo e($allowedLocation->latitude); ?>,<?php echo e($allowedLocation->longitude); ?>" 
                                       target="_blank" class="btn btn-sm btn-info mt-2">
                                        <i class="fas fa-map"></i> Lihat di Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-info">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-map-marker-alt text-info"></i> Gunakan Lokasi Saat Ini</h6>
                                        <button type="button" class="btn btn-info btn-sm" onclick="getCurrentLocation()">
                                            <i class="fas fa-crosshairs"></i> Ambil Lokasi Saat Ini
                                        </button>
                                        <small class="form-text text-muted">Pastikan Anda berada di lokasi yang ingin didaftarkan</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card border-warning">
                                    <div class="card-body">
                                        <h6 class="card-title"><i class="fas fa-ruler text-warning"></i> Test Jarak dari Lokasi Saat Ini</h6>
                                        <button type="button" class="btn btn-warning btn-sm" onclick="testDistance()">
                                            <i class="fas fa-calculator"></i> Hitung Jarak
                                        </button>
                                        <small class="form-text text-muted">Lihat berapa jarak Anda dari koordinat yang diset</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light d-flex justify-content-between">
                        <a href="<?php echo e(route('admin.allowed-locations.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#updateModal">
                            <i class="fas fa-save"></i> Update Lokasi
                        </button>

                        <!-- Modal Konfirmasi Update -->
                        <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Konfirmasi Update</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin mengupdate data lokasi akses ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-warning">
                                            <i class="fas fa-save"></i> Ya, Update
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.coordinate-display {
    font-family: 'Courier New', monospace;
    font-size: 11px;
    background: #f8f9fa;
    padding: 2px 4px;
    border-radius: 3px;
    border: 1px solid #dee2e6;
    display: inline-block;
    margin-bottom: 2px;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function getCurrentLocation() {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung geolocation');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengambil lokasi...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
            
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            alert('Koordinat berhasil diambil!');
        },
        function(error) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            alert('Gagal mendapatkan lokasi: ' + error.message);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}

function testDistance() {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung geolocation');
        return;
    }

    const btn = event.target;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengukur jarak...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const currentLat = position.coords.latitude;
            const currentLng = position.coords.longitude;
            const targetLat = parseFloat(document.getElementById('latitude').value);
            const targetLng = parseFloat(document.getElementById('longitude').value);
            
            if (!targetLat || !targetLng) {
                alert('Koordinat target tidak valid');
                btn.innerHTML = originalText;
                btn.disabled = false;
                return;
            }
            
            // Calculate distance using Haversine formula
            const R = 6371000; // Earth's radius in meters
            const φ1 = currentLat * Math.PI/180;
            const φ2 = targetLat * Math.PI/180;
            const Δφ = (targetLat-currentLat) * Math.PI/180;
            const Δλ = (targetLng-currentLng) * Math.PI/180;

            const a = Math.sin(Δφ/2) * Math.sin(Δφ/2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ/2) * Math.sin(Δλ/2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));

            const distance = R * c; // Distance in meters
            const radius = parseInt(document.getElementById('radius_meters').value) || 200;
            
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            const isAllowed = distance <= radius;
            const status = isAllowed ? 'DIIZINKAN' : 'DITOLAK';
            
            alert(`Jarak dari lokasi target: ${Math.round(distance)}m\nRadius yang diset: ${radius}m\nStatus: ${status}`);
        },
        function(error) {
            btn.innerHTML = originalText;
            btn.disabled = false;
            
            alert('Gagal mendapatkan lokasi: ' + error.message);
        },
        {
            enableHighAccuracy: true,
            timeout: 10000,
            maximumAge: 0
        }
    );
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/admin/allowed-locations/edit.blade.php ENDPATH**/ ?>