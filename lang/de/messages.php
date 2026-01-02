<?php

return [
    'button_label' => 'UUID ändern',
    'modal_heading' => 'Egg UUID ändern',
    'modal_description' => 'Achtung: Das Ändern der UUID kann zu Problemen führen, wenn diese UUID bereits anderweitig verwendet wird.',
    'modal_icon_tooltip' => 'Warnung',
    
    'save_button_label' => 'Speichern',
    'save_modal_heading' => 'Egg speichern',
    'save_modal_description' => 'Möchten Sie beim Speichern auch die UUID ändern?',
    
    'save_form' => [
        'change_uuid_label' => 'UUID beim Speichern ändern',
        'change_uuid_helper' => 'Aktivieren Sie diese Option, um automatisch eine neue UUID zu generieren oder eine eigene einzugeben.',
    ],
    
    'import_button_label' => 'Mit UUID-Änderung importieren',
    'import_modal_heading' => 'Egg importieren',
    'import_modal_description' => 'Möchten Sie die UUID des importierten Eggs ändern?',
    
    'import_form' => [
        'change_uuid_label' => 'UUID nach Import ändern',
        'change_uuid_helper' => 'Aktivieren Sie diese Option, um nach dem Import automatisch eine neue UUID zu generieren oder eine eigene einzugeben.',
    ],
    
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
        'save_success_title' => 'Egg erfolgreich gespeichert',
        'import_success_title' => 'Egg erfolgreich importiert und UUID geändert',
        'import_success_body' => 'Das Egg wurde importiert und die UUID wurde von :old zu :new geändert.',
        'import_detected_title' => 'Egg erfolgreich importiert',
        'import_detected_body' => 'Möchten Sie die UUID des importierten Eggs ändern?',
        'change_uuid_action' => 'UUID ändern',
        'keep_uuid_action' => 'UUID beibehalten',
        'import_ready_title' => 'UUID-Änderung vorbereitet',
        'import_ready_body' => 'Die UUID wird nach dem Import automatisch geändert.',
        'error_title' => 'Fehler beim Ändern der UUID',
    ],
];
