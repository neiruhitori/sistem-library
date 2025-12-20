<?php
/**
 * OPTIMIZE SCRIPT FOR HOSTING
 * Upload file ini ke folder root di hosting
 * Akses: https://perpustakaan-smpn2klakah.my.id/optimize.php
 * HAPUS FILE INI SETELAH SELESAI untuk keamanan!
 */

echo "<h1>Laravel Optimization Script</h1>";
echo "<hr>";

$basePath = __DIR__;
chdir($basePath);

function runCommand($command, $description) {
    echo "<h3>{$description}</h3>";
    echo "<pre>";
    $output = [];
    $return = null;
    exec("php artisan {$command} 2>&1", $output, $return);
    echo implode("\n", $output);
    echo "</pre>";
    echo "<p>Exit code: {$return}</p>";
    echo "<hr>";
    return $return === 0;
}

// Clear all caches
runCommand('config:clear', '1. Clearing config cache...');
runCommand('cache:clear', '2. Clearing application cache...');
runCommand('route:clear', '3. Clearing route cache...');
runCommand('view:clear', '4. Clearing view cache...');
runCommand('optimize:clear', '5. Clearing all optimization cache...');

echo "<br>";

// Optimize for production
runCommand('config:cache', '6. Caching config...');
runCommand('route:cache', '7. Caching routes...');
runCommand('view:cache', '8. Caching views...');

echo "<br>";

// Composer optimize
echo "<h3>9. Running composer dump-autoload...</h3>";
echo "<pre>";
$output = [];
exec("composer dump-autoload -o 2>&1", $output);
echo implode("\n", $output);
echo "</pre>";
echo "<hr>";

echo "<h2 style='color: green;'>✅ OPTIMIZATION COMPLETE!</h2>";
echo "<p style='color: red;'><strong>PENTING: Hapus file optimize.php ini dari server untuk keamanan!</strong></p>";
echo "<p><a href='/'>Kembali ke Dashboard</a></p>";
?>
