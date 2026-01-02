<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Egg UUID Changer Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration options for the Egg UUID Changer plugin.
    |
    */

    'enabled' => env('EGG_UUID_CHANGER_ENABLED', true),

    /*
    |--------------------------------------------------------------------------
    | Validation
    |--------------------------------------------------------------------------
    |
    | Configure validation options for UUID changes.
    |
    */

    'validation' => [
        'allow_duplicate' => env('EGG_UUID_CHANGER_ALLOW_DUPLICATE', false),
        'require_confirmation' => env('EGG_UUID_CHANGER_REQUIRE_CONFIRMATION', true),
    ],
];
