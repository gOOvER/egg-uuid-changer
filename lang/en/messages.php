<?php

return [
    'button_label' => 'Change UUID',
    'modal_heading' => 'Change Egg UUID',
    'modal_description' => 'Warning: Changing the UUID can cause problems if this Egg is already assigned to servers or external integrations.',

    'form' => [
        'current_uuid_label' => 'Current UUID',
        'current_uuid_helper' => 'The current UUID of this Egg (copy this if you need a backup).',
        'new_uuid_label' => 'New UUID',
        'new_uuid_placeholder' => 'Leave empty for automatic generation',
        'new_uuid_helper' => 'Enter a valid UUID or leave the field empty to generate a new UUID automatically.',
    ],

    'validation' => [
        'invalid_uuid' => 'The entered UUID is invalid.',
        'same_uuid' => 'The new UUID must be different from the current UUID.',
        'duplicate_uuid' => 'This UUID is already being used by another Egg.',
    ],

    'notifications' => [
        'success_title' => 'UUID successfully changed',
        'success_body' => 'The UUID has been changed from :old to :new.',
        'error_title' => 'Error changing UUID',
        'error_body' => 'An unexpected error occurred while changing the UUID. Please check the panel logs.',
        'unauthorized_body' => 'You do not have permission to update this Egg.',
    ],
];
