<?php

return [
    'admin' => [
        'title' => 'Kurzlinks',
        'create' => 'Neuer Kurzlink',
        'edit' => 'Link bearbeiten',
        'show' => 'Link Details',
        'list' => 'Link Liste',
    ],

    'fields' => [
        'code' => 'Kurzcode',
        'target_url' => 'Ziel-URL',
        'title' => 'Titel',
        'short_url' => 'Kurz-URL',
        'click_count' => 'Klicks',
        'expires_at' => 'Ablaufdatum',
        'is_active' => 'Aktiv',
        'created_at' => 'Erstellt',
    ],

    'buttons' => [
        'create' => 'Neuer Link',
        'save' => 'Speichern',
        'update' => 'Aktualisieren',
        'delete' => 'Loschen',
        'cancel' => 'Abbrechen',
        'back' => 'Zuruck',
        'edit' => 'Bearbeiten',
        'copy' => 'Kopieren',
        'view' => 'Anzeigen',
    ],

    'messages' => [
        'created' => 'Kurzlink erfolgreich erstellt.',
        'updated' => 'Link erfolgreich aktualisiert.',
        'deleted' => 'Link erfolgreich geloscht.',
        'not_found' => 'Link nicht gefunden.',
        'delete_confirm' => 'Mochten Sie diesen Link wirklich loschen?',
        'no_items' => 'Noch keine Kurzlinks.',
        'copied' => 'Link kopiert!',
        'expired' => 'Dieser Link ist abgelaufen.',
        'inactive' => 'Dieser Link ist nicht mehr aktiv.',
    ],

    'placeholders' => [
        'code' => 'Automatisch generiert',
        'target_url' => 'https://example.com/lange-url-hier',
        'title' => 'Link Beschreibung (optional)',
    ],

    'help' => [
        'code' => 'Leer lassen fur automatische Generierung. Nur Buchstaben und Zahlen.',
        'expires_at' => 'Leer lassen fur kein Ablaufdatum.',
    ],
];
