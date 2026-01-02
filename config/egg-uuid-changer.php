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
    | Auto Prompt on Save
    |--------------------------------------------------------------------------
    |
    | When enabled, the plugin will prompt the user to change the UUID
    | every time they save an egg.
    |
    */

    'auto_prompt_on_save' => env('EGG_UUID_CHANGER_AUTO_PROMPT_ON_SAVE', false),

    /*
    |--------------------------------------------------------------------------
    | Auto Prompt on Import
    |--------------------------------------------------------------------------
    |
    | When enabled, the plugin will show an action button on the import page
    | allowing the user to change the UUID before or after importing an egg.
    |
    */

    'auto_prompt_on_import' => env('EGG_UUID_CHANGER_AUTO_PROMPT_ON_IMPORT', false),

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
