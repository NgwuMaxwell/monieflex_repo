<?php

namespace Database\Seeders;

use App\Models\Gateway;
use Illuminate\Database\Seeder;

class PaystackGatewaySeeder extends Seeder
{
    public function run()
    {
        // Check if Paystack already exists
        $exists = Gateway::where('alias', 'paystack')->exists();

        if ($exists) {
            $this->command->info('Paystack gateway already exists.');
            return;
        }

        $gateway = new Gateway();
        $gateway->form_id = 0;
        $gateway->code = 501; // Code must be < 1000 for automatic gateways
        $gateway->name = 'Paystack';
        $gateway->alias = 'paystack';
        $gateway->image = null;
        $gateway->status = 0; // Disabled by default
        // Use proper object structure with stdClass for nested properties
        $gateway->gateway_parameters = (object)[
            'public_key' => (object)[
                'title' => 'Public Key',
                'global' => true,
                'value' => 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
            ],
            'secret_key' => (object)[
                'title' => 'Secret Key',
                'global' => true,
                'value' => 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx'
            ]
        ];
        $gateway->supported_currencies = (object)['NGN' => 'NGN', 'USD' => 'USD', 'GHS' => 'GHS', 'ZAR' => 'ZAR', 'KES' => 'KES'];
        $gateway->crypto = 0;
        $gateway->extra = (object)[
            'callback_url' => (object)[
                'title' => 'Callback URL',
                'value' => url('/') . '/user/deposit/confirm'
            ],
            'webhook_url' => (object)[
                'title' => 'Webhook URL',
                'value' => url('/') . '/api/paystack/webhook'
            ]
        ];
        $gateway->description = 'Paystack is a Nigerian payment gateway that allows businesses to accept payments from customers via credit card, debit card, and bank account. It supports multiple African currencies.';
        $gateway->save();

        $this->command->info('Paystack gateway created successfully!');
        $this->command->info('Please update the API keys in the gateway settings.');
    }
}
