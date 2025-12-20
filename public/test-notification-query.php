<?php
// Test direct database query untuk notifications
// Akses: https://perpustakaan-smpn2klakah.my.id/test-notification-query.php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "<h1>Test Notification Database Query</h1>";
echo "<pre>";

try {
    // Check table structure
    echo "=== TABLE STRUCTURE ===\n";
    $columns = DB::select("SHOW COLUMNS FROM notifications");
    foreach ($columns as $column) {
        echo "{$column->Field} ({$column->Type})\n";
    }
    
    echo "\n=== TEST QUERY 1: Get all notifications ===\n";
    $all = DB::table('notifications')->get();
    echo "Total records: " . $all->count() . "\n";
    if ($all->count() > 0) {
        echo "First record:\n";
        print_r($all->first());
    }
    
    echo "\n=== TEST QUERY 2: Try query with notifiable_id ===\n";
    try {
        $byNotifiable = DB::table('notifications')
            ->where('notifiable_type', 'App\\Models\\User')
            ->where('notifiable_id', 1)
            ->get();
        echo "SUCCESS: Found " . $byNotifiable->count() . " records\n";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== TEST QUERY 3: Try insert ===\n";
    try {
        $uuid = \Illuminate\Support\Str::uuid();
        $inserted = DB::table('notifications')->insert([
            'id' => $uuid,
            'type' => 'App\\Notifications\\TestNotification',
            'notifiable_type' => 'App\\Models\\User',
            'notifiable_id' => 1,
            'data' => json_encode(['title' => 'Test', 'message' => 'Test message']),
            'read_at' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "SUCCESS: Inserted notification with ID: {$uuid}\n";
        
        // Delete test record
        DB::table('notifications')->where('id', $uuid)->delete();
        echo "Test record deleted\n";
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== TEST QUERY 4: Simulate NotificationController::getNotifications() ===\n";
    try {
        $notifications = DB::table('notifications')
            ->where('notifiable_type', 'App\\Models\\User')
            ->where('notifiable_id', 1)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        echo "SUCCESS: Query completed, found " . $notifications->count() . " notifications\n";
        
        $mapped = $notifications->map(function ($notification) {
            $data = json_decode($notification->data, true);
            return [
                'id' => $notification->id,
                'type' => $data['type'] ?? 'notification',
                'title' => $data['title'] ?? 'Notifikasi',
                'message' => $data['message'] ?? '',
                'is_read' => $notification->read_at !== null,
                'created_at' => $notification->created_at
            ];
        });
        
        echo "Mapped notifications:\n";
        print_r($mapped->toArray());
    } catch (\Exception $e) {
        echo "ERROR: " . $e->getMessage() . "\n";
        echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    }
    
} catch (\Exception $e) {
    echo "FATAL ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "</pre>";
