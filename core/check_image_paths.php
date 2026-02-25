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

echo 'Blog image paths:' . PHP_EOL;
$records = \App\Models\Frontend::where('data_keys', 'blog.element')->get();
foreach ($records as $record) {
    echo 'Title: ' . ($record->data_values->title ?? 'No title') . PHP_EOL;
    echo 'Image field: ' . var_export($record->image, true) . PHP_EOL;
    echo 'Data values: ' . var_export($record->data_values, true) . PHP_EOL;
    echo '---' . PHP_EOL;
}
