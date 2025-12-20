<?php
// Test file untuk cek apakah NotificationController sudah pakai code baru
// Akses: https://perpustakaan-smpn2klakah.my.id/test-notification-code.php

echo "<h1>Test Notification Code</h1>";
echo "<pre>";

// Cek file timestamp
$controllerFile = __DIR__ . '/../app/Http/Controllers/NotificationController.php';
$serviceFile = __DIR__ . '/../app/Services/NotificationService.php';
$modelFile = __DIR__ . '/../app/Models/Notification.php';

echo "=== FILE TIMESTAMPS ===\n";
echo "NotificationController.php:\n";
echo "  Modified: " . date('Y-m-d H:i:s', filemtime($controllerFile)) . "\n";
echo "  Size: " . filesize($controllerFile) . " bytes\n\n";

echo "NotificationService.php:\n";
echo "  Modified: " . date('Y-m-d H:i:s', filemtime($serviceFile)) . "\n";
echo "  Size: " . filesize($serviceFile) . " bytes\n\n";

echo "Notification.php:\n";
echo "  Modified: " . date('Y-m-d H:i:s', filemtime($modelFile)) . "\n";
echo "  Size: " . filesize($modelFile) . " bytes\n\n";

echo "=== CODE CHECK ===\n";
$controllerContent = file_get_contents($controllerFile);
$serviceContent = file_get_contents($serviceFile);
$modelContent = file_get_contents($modelFile);

echo "NotificationController uses 'use App\\Models\\Notification': ";
echo (strpos($controllerContent, 'use App\\Models\\Notification') !== false) ? "YES (BAD!)\n" : "NO (GOOD)\n";

echo "NotificationController uses 'DB::table(notifications)': ";
echo (strpos($controllerContent, "DB::table('notifications')") !== false) ? "YES (GOOD)\n" : "NO (BAD!)\n";

echo "NotificationController uses 'notifiable_id': ";
echo (strpos($controllerContent, 'notifiable_id') !== false) ? "YES (GOOD)\n" : "NO (BAD!)\n";

echo "\nNotificationService uses 'Notification::create': ";
echo (strpos($serviceContent, 'Notification::create') !== false) ? "YES (BAD!)\n" : "NO (GOOD)\n";

echo "NotificationService uses 'DB::table(notifications)': ";
echo (strpos($serviceContent, "DB::table('notifications')") !== false) ? "YES (GOOD)\n" : "NO (BAD!)\n";

echo "\nNotification model has fillable with user_id: ";
echo (strpos($modelContent, "'user_id'") !== false && strpos($modelContent, 'fillable') !== false) ? "YES (BAD!)\n" : "NO (GOOD)\n";

echo "Notification model is empty: ";
echo (strpos($modelContent, '// Model kosong') !== false) ? "YES (GOOD)\n" : "NO (BAD!)\n";

echo "\n=== EXPECTED RESULT ===\n";
echo "All should be GOOD for system to work correctly.\n";
echo "If any shows BAD, the file on hosting is not updated yet.\n";

echo "</pre>";
