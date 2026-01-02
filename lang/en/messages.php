<?php

return [
    'button_label' => 'Change UUID',
    'modal_heading' => 'Change Egg UUID',
    'modal_description' => 'Warning: Changing the UUID can cause problems if this UUID is already being used elsewhere.',
    'modal_icon_tooltip' => 'Warning',
    
    'save_button_label' => 'Save',
    'save_modal_heading' => 'Save Egg',
    'save_modal_description' => 'Would you like to change the UUID when saving?',
    
    'save_form' => [
        'change_uuid_label' => 'Change UUID on save',
        'change_uuid_helper' => 'Enable this option to automatically generate a new UUID or enter your own.',
    ],
    
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
        'save_success_title' => 'Egg successfully saved',
        'error_title' => 'Error changing UUID',
    ],
];
