<?php

require_once __DIR__ . '/vendor/autoload.php';

// Test the Frontend model
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '127.0.0.1',
    'database'  => 'app1_db',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();

// Test the query
try {
    $posts = \App\Models\Frontend::where('data_keys', 'blog.content')
        ->latest()
        ->take(5)
        ->get();
    
    echo "Posts type: " . gettype($posts) . "\n";
    echo "Posts class: " . get_class($posts) . "\n";
    echo "Posts count: " . $posts->count() . "\n";
    echo "Posts is null: " . ($posts === null ? 'true' : 'false') . "\n";
    echo "Posts is empty: " . $posts->isEmpty() . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
