<?php $__env->startSection('title', 'Pembayaran Denda'); ?>

<?php $__env->startSection('contents'); ?>
    <div class="container mt-5" style="max-width: 700px;">
        <div class="card shadow">
            <?php if(session('success') || session('info')): ?>
                <?php
                    $alertType = session('success') ? 'success' : 'info';
                    $alertMessage = session('success') ?: session('info');
                    $alertIcon = session('success') ? 'check-circle' : 'info-circle';
                ?>
                <div class="alert alert-<?php echo e($alertType); ?> alert-dismissible fade show mt-2" role="alert" id="alert-session">
                    <i class="fas fa-<?php echo e($alertIcon); ?>"></i> <?php echo e($alertMessage); ?>

                    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-session')?.classList.remove('show'), 4000);
                </script>
            <?php endif; ?>
            <div class="card-header bg-info text-white">
                <h4 class="mb-0"><i class="fas fa-money-bill-wave"></i> Konfirmasi Pembayaran Denda (Cash)</h4>
            </div>
            <div class="card-body">
                <p><strong>Nama Siswa:</strong> <?php echo e($catatan->siswa->name); ?></p>
                <p><strong>Kelas:</strong> <?php echo e($catatan->siswa->kelas); ?></p>
                <p><strong>Jenis Denda:</strong> <?php echo e(ucfirst($catatan->jenis_denda)); ?></p>
                <p><strong>Jumlah Tagihan:</strong>
                    <span class="badge badge-pill badge-warning">
                        Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?>

                    </span>
                </p>
                <p><strong>Status:</strong>
                    <span class="badge badge-<?php echo e($catatan->status == 'dibayar' ? 'success' : 'danger'); ?>">
                        <?php echo e($catatan->status == 'dibayar' ? 'Lunas' : 'Belum Dibayar'); ?>

                    </span>
                </p>

                
                <?php if($catatan->status === 'belum_dibayar'): ?>
                    <div class="text-center mt-4">
                        
                        <button class="btn btn-success" data-toggle="modal" data-target="#confirmModal">
                            <i class="fas fa-check-circle"></i> Bayar via Cash
                        </button>

                        
                        <button id="pay-button" class="btn btn-primary">
                            <i class="fas fa-credit-card"></i> Bayar via Mbanking
                        </button>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-3">
                    <a href="<?php echo e(route('catatantahunan.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="fas fa-exclamation-circle"></i> Konfirmasi Pembayaran Cash
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Tutup">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    Apakah Anda yakin pembayaran <strong>tunai</strong> sebesar<br>
                    <span class="text-primary">Rp<?php echo e(number_format($catatan->jumlah, 0, ',', '.')); ?></span> sudah dilakukan?
                </div>
                <div class="modal-footer justify-content-center">
                    <form action="<?php echo e(route('catatantahunan.processPayment', $catatan->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ya, Sudah Dibayar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="https://app.<?php echo e(config('services.midtrans.is_production') ? '' : 'sandbox.'); ?>midtrans.com/snap/snap.js"
        data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>
 
    <script>
        document.getElementById('pay-button').addEventListener('click', function(e) {
            e.preventDefault();
            snap.pay('<?php echo e($catatan->snap_token); ?>', {
                onSuccess: function(result) {
                    console.log('Success:', result);
                    // Create a form dynamically and submit it to our new endpoint
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = "<?php echo e(route('catatantahunan.midtrans.success', $catatan->id)); ?>";
 
                    const csrfToken = document.createElement('input');
                    csrfToken.type = 'hidden';
                    csrfToken.name = '_token';
                    csrfToken.value = '<?php echo e(csrf_token()); ?>';
                    form.appendChild(csrfToken);
 
                    document.body.appendChild(form);
                    form.submit();
                },
                onPending: function(result) {
                    console.log('Pending:', result);
                    alert("Menunggu pembayaran selesai. Status akan diperbarui setelah pembayaran berhasil.");
                    window.location.href = "<?php echo e(route('catatantahunan.show', $catatan->id)); ?>";
                },
                onError: function(result) {
                    console.log('Error:', result);
                    alert("Pembayaran gagal: " + result.status_message);
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\sistem-library\resources\views/catatantahunan/payment.blade.php ENDPATH**/ ?>