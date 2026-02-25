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

echo 'All frontend records:' . PHP_EOL;
$records = \App\Models\Frontend::all();
foreach ($records as $record) {
    echo 'ID: ' . $record->id . ', Data Keys: ' . $record->data_keys . ', Title: ' . ($record->data_values->heading ?? $record->data_values->title ?? 'No title') . PHP_EOL;
}