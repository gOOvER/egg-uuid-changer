<?php

return [
    'button_label' => 'UUID ändern',
    'modal_heading' => 'Egg UUID ändern',
    'modal_description' => 'Achtung: Das Ändern der UUID kann zu Problemen führen, wenn diese UUID bereits anderweitig verwendet wird.',
    'modal_icon_tooltip' => 'Warnung',
    
    'form' => [
        'new_uuid_label' => 'Neue UUID',
        'new_uuid_placeholder' => 'Leer lassen für automatische Generierung',
        'new_uuid_helper' => 'Geben Sie eine gültige UUID ein oder lassen Sie das Feld leer, um eine neue UUID zu generieren.',
    ],
    
    'validation' => [
        'invalid_uuid' => 'Die eingegebene UUID ist ungültig.',
        'duplicate_uuid' => 'Diese UUID wird bereits von einem anderen Egg verwendet.',
    ],
    
    'notifications' => [
        'success_title' => 'UUID erfolgreich geändert',
        'success_body' => 'Die UUID wurde von :old zu :new geändert.',
        'error_title' => 'Fehler beim Ändern der UUID',
    ],
];
