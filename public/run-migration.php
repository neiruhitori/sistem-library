<?php
// Run migration via web browser
// Akses: https://perpustakaan-smpn2klakah.my.id/run-migration.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h1>Running Migration</h1>";
echo "<pre>";

try {
    // Check if user_id column exists
    $columns = DB::select("SHOW COLUMNS FROM notifications");
    $hasUserId = false;
    foreach ($columns as $column) {
        if ($column->Field === 'user_id') {
            $hasUserId = true;
            break;
        }
    }
    
    if ($hasUserId) {
        echo "✓ Column 'user_id' already exists in notifications table\n";
    } else {
        echo "Adding 'user_id' column to notifications table...\n";
        
        DB::statement("ALTER TABLE notifications ADD COLUMN user_id BIGINT UNSIGNED NOT NULL AFTER id");
        DB::statement("ALTER TABLE notifications ADD INDEX idx_user_id (user_id)");
        
        echo "✓ Column 'user_id' added successfully\n";
    }
    
    echo "\n=== Current Table Structure ===\n";
    $columns = DB::select("SHOW COLUMNS FROM notifications");
    foreach ($columns as $column) {
        echo "{$column->Field} ({$column->Type})\n";
    }
    
    echo "\n✓ Migration completed successfully!\n";
    echo "You can now delete this file for security.\n";
    
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
