<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Gateway;

// Find Paystack gateway
$gateway = Gateway::where('alias', 'paystack')->first();

if (!$gateway) {
    echo "Paystack gateway not found in database.\n";
    exit(1);
}

echo "Found Paystack gateway (ID: {$gateway->id})\n";
echo "Current gateway_parameters type: " . gettype($gateway->gateway_parameters) . "\n";

// Fix the gateway_parameters structure
$gateway->gateway_parameters = (object)[
    'public_key' => (object)[
        'title' => 'Public Key',
        'global' => true,
        'value' => $gateway->gateway_parameters->public_key->value ?? 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
    ],
    'secret_key' => (object)[
        'title' => 'Secret Key',
        'global' => true,
        'value' => $gateway->gateway_parameters->secret_key->value ?? 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
    ]
];

$gateway->save();

echo "Paystack gateway parameters fixed successfully!\n";
echo "You can now edit the gateway without errors.\n";
