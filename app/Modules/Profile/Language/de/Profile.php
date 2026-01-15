<?php

return [
    'admin' => [
        'title' => 'Profile',
        'create' => 'Neues Profil',
        'edit' => 'Profil bearbeiten',
        'show' => 'Profildetails',
        'delete' => 'Profil loschen',
        'list' => 'Profilliste',
    ],

    'frontend' => [
        'title' => 'Profil',
        'show' => 'Profilseite',
        'no_items' => 'Keine Profile gefunden.',
        'view_profile' => 'Profil anzeigen',
        'download_qr' => 'QR-Code herunterladen',
    ],

    'fields' => [
        'username' => 'Benutzername',
        'display_name' => 'Anzeigename',
        'bio' => 'Uber mich',
        'avatar' => 'Profilbild',
        'theme' => 'Design',
        'ga_measurement_id' => 'Google Analytics ID',
        'view_count' => 'Aufrufe',
        'is_active' => 'Aktiv',
        'created_at' => 'Erstellt am',
        'updated_at' => 'Aktualisiert am',
    ],

    'buttons' => [
        'create' => 'Neues Profil',
        'save' => 'Speichern',
        'update' => 'Aktualisieren',
        'delete' => 'Loschen',
        'cancel' => 'Abbrechen',
        'back' => 'Zuruck',
        'edit' => 'Bearbeiten',
        'view' => 'Anzeigen',
    ],

    'messages' => [
        'created' => 'Profil erfolgreich erstellt.',
        'updated' => 'Profil erfolgreich aktualisiert.',
        'deleted' => 'Profil erfolgreich geloscht.',
        'not_found' => 'Profil nicht gefunden.',
        'delete_confirm' => 'Mochten Sie dieses Profil wirklich loschen?',
        'username_taken' => 'Dieser Benutzername ist bereits vergeben.',
        'username_reserved' => 'Dieser Benutzername ist reserviert.',
    ],

    'validation' => [
        'username_required' => 'Benutzername ist erforderlich.',
        'username_min_length' => 'Benutzername muss mindestens 3 Zeichen lang sein.',
    ],
];
