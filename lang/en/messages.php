<?php

return [
    'button_label' => 'Change UUID',
    'modal_heading' => 'Change Egg UUID',
    'modal_description' => 'Warning: Changing the UUID can cause problems if this UUID is already being used elsewhere.',
    'modal_icon_tooltip' => 'Warning',
    
    'form' => [
        'new_uuid_label' => 'New UUID',
        'new_uuid_placeholder' => 'Leave empty for automatic generation',
        'new_uuid_helper' => 'Enter a valid UUID or leave the field empty to generate a new UUID.',
    ],
    
    'validation' => [
        'invalid_uuid' => 'The entered UUID is invalid.',
        'duplicate_uuid' => 'This UUID is already being used by another Egg.',
    ],
    
    'notifications' => [
        'success_title' => 'UUID successfully changed',
        'success_body' => 'The UUID has been changed from :old to :new.',
        'error_title' => 'Error changing UUID',
    ],
];
