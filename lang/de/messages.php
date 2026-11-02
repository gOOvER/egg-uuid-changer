<?php

return [
    'button_label' => 'UUID ändern',
    'modal_heading' => 'Egg UUID ändern',
    'modal_description' => 'Achtung: Das Ändern der UUID kann zu Problemen führen, wenn dieses Egg bereits Servern oder externen Integrationen zugewiesen ist.',

    'form' => [
        'current_uuid_label' => 'Aktuelle UUID',
        'current_uuid_helper' => 'Die aktuelle UUID dieses Eggs (kopieren Sie diese als Backup, falls benötigt).',
        'new_uuid_label' => 'Neue UUID',
        'new_uuid_placeholder' => 'Leer lassen für automatische Generierung',
        'new_uuid_helper' => 'Geben Sie eine gültige UUID ein oder lassen Sie das Feld leer, um automatisch eine neue UUID zu generieren.',
    ],

    'validation' => [
        'invalid_uuid' => 'Die eingegebene UUID ist ungültig.',
        'same_uuid' => 'Die neue UUID muss sich von der aktuellen UUID unterscheiden.',
        'duplicate_uuid' => 'Diese UUID wird bereits von einem anderen Egg verwendet.',
    ],

    'notifications' => [
        'success_title' => 'UUID erfolgreich geändert',
        'success_body' => 'Die UUID wurde von :old zu :new geändert.',
        'error_title' => 'Fehler beim Ändern der UUID',
        'error_body' => 'Beim Ändern der UUID ist ein unerwarteter Fehler aufgetreten. Bitte prüfen Sie die Panel-Logs.',
        'unauthorized_body' => 'Sie haben keine Berechtigung, dieses Egg zu bearbeiten.',
    ],
];
