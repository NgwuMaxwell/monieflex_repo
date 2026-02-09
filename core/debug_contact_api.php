<?php
// Debug script to test contact API directly
require_once 'core/bootstrap/app.php';

use Illuminate\Support\Facades\DB;

try {
    // Test database connection
    $result = DB::select('SELECT 1 as test');
    echo "Database connection: OK\n";
    
    // Test if contact_messages table exists
    $tables = DB::select("SHOW TABLES LIKE 'contact_messages'");
    if (!empty($tables)) {
        echo "contact_messages table: EXISTS\n";
    } else {
        echo "contact_messages table: MISSING\n";
    }
    
    // Test API endpoint directly
    $client = new \GuzzleHttp\Client();
    $response = $client->post('http://localhost/app1/api/contact', [
        'form_params' => [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'message' => 'Test message for debugging'
        ]
    ]);
    
    echo "API Response Status: " . $response->getStatusCode() . "\n";
    echo "API Response Body: " . $response->getBody() . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
?>