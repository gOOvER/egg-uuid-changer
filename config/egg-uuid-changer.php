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
    | Prompt on Import
    |--------------------------------------------------------------------------
    |
    | When enabled, after importing an egg, a prominent button will appear
    | on the egg edit page prompting to change the imported UUID.
    |
    */

    'prompt_on_import' => env('EGG_UUID_CHANGER_PROMPT_ON_IMPORT', false),

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
