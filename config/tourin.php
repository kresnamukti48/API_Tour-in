<?php

return [
    'payment' => [
        'midtrans' => [
            'server_key' => env('PAYMENT_MIDTRANS_SERVER_KEY'),
            'production' => env('PAYMENT_MIDTRANS_PRODUCTION'),
            'sanitized' => env('PAYMENT_MIDTRANS_SANITIZED'),
            '3ds' => env('PAYMENT_MIDTRANS_3DS'),
        ],
        'xendit' => [
            'secretKey' => env('PAYMENT_XENDIT_SECRET_KEY'),
        ],
    ],
];
