<?php

require_once __DIR__ . '/vendor/autoload.php';

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

$post = \App\Models\Frontend::where('data_keys', 'blog.content')->first();
if ($post) {
    echo 'data_values type: ' . gettype($post->data_values) . PHP_EOL;
    echo 'data_values: ' . print_r($post->data_values, true) . PHP_EOL;
} else {
    echo 'No post found' . PHP_EOL;
}