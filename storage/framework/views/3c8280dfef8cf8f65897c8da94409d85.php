<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Button Loading - Test Page</title>
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('AdminLTE-3.2.0/dist/css/adminlte.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/button-loading.css')); ?>">
</head>
<body class="hold-transition">
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <h1>Test Button Loading Feature</h1>
                    <p class="text-muted">Halaman ini untuk testing fitur button loading</p>
                </div>
            </section>

            <section class="content">
                <div class="container-fluid">
                    
                    <!-- Test 1: Form Submit -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Test 1: Form Submit Button</h3>
                        </div>
                        <form action="#" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Data
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Simpan & Lanjut
                                </button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>

                    <!-- Test 2: Delete Button -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Test 2: Delete Button</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST" onsubmit="return confirm('Yakin hapus data?')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <p>Data akan dihapus secara permanen.</p>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Test 3: Multiple Buttons -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Test 3: Multiple Action Buttons</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <form action="#" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-upload"></i> Import
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form action="#" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-success btn-block">
                                            <i class="fas fa-download"></i> Export
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form action="#" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-warning btn-block">
                                            <i class="fas fa-sync"></i> Refresh
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3">
                                    <form action="#" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-info btn-block">
                                            <i class="fas fa-print"></i> Print
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Test 4: Link as Button -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Test 4: Link Styled as Button</h3>
                        </div>
                        <div class="card-body">
                            <a href="#" class="btn btn-success">
                                <i class="fas fa-plus"></i> Tambah Data
                            </a>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Data
                            </a>
                            <a href="#" class="btn btn-info">
                                <i class="fas fa-eye"></i> Lihat Detail
                            </a>
                        </div>
                    </div>

                    <!-- Test 5: Button Sizes -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Test 5: Different Button Sizes</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Small
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check"></i> Normal
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-check"></i> Large
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Test 6: Modal Form -->
                    <div class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title">Test 6: Button in Modal</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#testModal">
                                <i class="fas fa-window-maximize"></i> Open Modal
                            </button>
                        </div>
                    </div>

                    <!-- Test 7: Icon Only Button -->
                    <div class="card card-dark">
                        <div class="card-header">
                            <h3 class="card-title">Test 7: Icon Only Buttons</h3>
                        </div>
                        <div class="card-body">
                            <form action="#" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </form>
                            <form action="#" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <form action="#" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-info btn-sm" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Test Results -->
                    <div class="card card-light">
                        <div class="card-header">
                            <h3 class="card-title">Test Instructions</h3>
                        </div>
                        <div class="card-body">
                            <h5>Cara Test:</h5>
                            <ol>
                                <li>Klik salah satu button submit</li>
                                <li>Button akan langsung disabled dan menampilkan loading</li>
                                <li>Coba klik button yang sama berkali-kali → tidak akan ada efek</li>
                                <li>Button akan auto-reset setelah 10 detik (timeout)</li>
                                <li>Buka DevTools Console untuk melihat log</li>
                            </ol>

                            <h5 class="mt-3">Expected Behavior:</h5>
                            <ul>
                                <li>✅ Button disabled setelah 1x klik</li>
                                <li>✅ Tampil spinner loading icon</li>
                                <li>✅ Text berubah jadi "Loading..."</li>
                                <li>✅ Opacity button berkurang</li>
                                <li>✅ Cursor berubah jadi not-allowed</li>
                                <li>✅ Form tidak bisa disubmit lagi</li>
                            </ul>

                            <h5 class="mt-3">Console Log:</h5>
                            <div class="bg-dark text-white p-3 rounded">
                                <code>
                                    ✓ Button Loading Handler initialized
                                </code>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>
    </div>

    <!-- Test Modal -->
    <div class="modal fade" id="testModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Test Modal Form</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="#" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Data Test</label>
                            <input type="text" class="form-control" name="test" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('AdminLTE-3.2.0/dist/js/adminlte.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/button-loading.js')); ?>"></script>

    <!-- Test Script -->
    <script>
        // Prevent actual form submission untuk testing
        document.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted (prevented for testing)');
            
            // Simulate server response setelah 2 detik
            setTimeout(function() {
                alert('✅ Test berhasil! Button akan auto-reset atau reload page.');
                // ButtonLoading.resetForm(e.target); // Uncomment untuk auto-reset
            }, 2000);
        });

        // Log button clicks
        document.addEventListener('click', function(e) {
            if (e.target.closest('button, a.btn')) {
                console.log('Button clicked:', e.target.closest('button, a.btn'));
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/test-button-loading.blade.php ENDPATH**/ ?>