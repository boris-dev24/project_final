<?php

return [
    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'secret' => env('PAYPAL_CLIENT_SECRET'),
        'test_mode' => env('PAYPAL_TEST_MODE', true), // True pour le mode sandbox
    ],
];
