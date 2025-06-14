<?php

return [
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),

    'is_production' => env('MIDTRANS_IS_PRODUCTION', false), // Default ke false (Sandbox) jika tidak ada di .env
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),    // Default ke true
    'is_3ds' => env('MIDTRANS_IS_3DS', true),                // Default ke true
];