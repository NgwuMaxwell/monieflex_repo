<?php
// Simple test script to debug contact API
require_once 'core/bootstrap/app.php';

use Illuminate\Support\Facades\Http;

try {
    $response = Http::post('http://localhost/app1/api/contact', [
        'first_name' => 'Test',
        'last_name' => 'User',
        'email' => 'test@example.com',
        'message' => 'This is a test message for debugging'
    ]);
    
    echo "Status: " . $response->status() . "\n";
    echo "Body: " . $response->body() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>