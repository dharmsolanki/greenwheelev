<?php
return [
    'razorpay' => [
        'key_id'     => env('RAZORPAY_KEY_ID', ''),
        'key_secret' => env('RAZORPAY_KEY_SECRET', ''),
    ],
    'shiprocket' => [
        'email'           => env('SHIPROCKET_EMAIL', ''),
        'password'        => env('SHIPROCKET_PASSWORD', ''),
        'pickup_location' => env('SHIPROCKET_PICKUP_LOCATION', 'Primary'),
        'pickup_pincode'  => env('SHIPROCKET_PICKUP_PINCODE', '387001'),
    ],
];
