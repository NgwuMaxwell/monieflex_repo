<?php
// Test script to verify the contact route is working
require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Test the route
$route = $app['router']->getRoutes()->getByName('contact.submit');

if ($route) {
    echo "✅ Route 'contact.submit' is now defined!\n";
    echo "Route URI: " . $route->uri() . "\n";
    echo "Route Method: " . implode(', ', $route->methods()) . "\n";
    echo "Route Action: " . $route->getActionName() . "\n";
} else {
    echo "❌ Route 'contact.submit' is still not defined\n";
}

// Test the contact GET route too
$contactRoute = $app['router']->getRoutes()->getByName('contact');
if ($contactRoute) {
    echo "✅ Route 'contact' (GET) is defined!\n";
} else {
    echo "❌ Route 'contact' (GET) is not defined\n";
}