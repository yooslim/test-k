<?php

return [
    /*
    |--------------------------------------------------------------------------
    | USE DEFAULT PAYMENT PROVIDER
    |--------------------------------------------------------------------------
    |
    | If set on true, when creating a new payment instance, if no provider has
    | been selected, the default one will be used.
    |
    */
    'use_default' => env('USE_DEFAULT_PAYMENT', true),
    
    /*
    |--------------------------------------------------------------------------
    | PAYMENT PROVIDERS CREDENDETIALS
    |--------------------------------------------------------------------------
    |
    | key and secret credentials of each payment provider.
    |
    */
    'crendentials' => [
        'stripe' => [
            'id' => env('STRIPE_ID'),
            'secret' => env('STRIPE_SECRET'),
        ],

        'paypal' => [
            'id' => env('PAYPAL_ID'),
            'secret' => env('PAYPAL_SECRET'),
        ]
    ]
];
