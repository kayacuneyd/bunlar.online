<?php

return [
    'admin' => [
        'title' => 'Short Links',
        'create' => 'New Short Link',
        'edit' => 'Edit Link',
        'show' => 'Link Details',
        'list' => 'Link List',
    ],

    'fields' => [
        'code' => 'Short Code',
        'target_url' => 'Target URL',
        'title' => 'Title',
        'short_url' => 'Short URL',
        'click_count' => 'Clicks',
        'expires_at' => 'Expires At',
        'is_active' => 'Active',
        'created_at' => 'Created',
    ],

    'buttons' => [
        'create' => 'New Link',
        'save' => 'Save',
        'update' => 'Update',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'back' => 'Back',
        'edit' => 'Edit',
        'copy' => 'Copy',
        'view' => 'View',
    ],

    'messages' => [
        'created' => 'Short link created successfully.',
        'updated' => 'Link updated successfully.',
        'deleted' => 'Link deleted successfully.',
        'not_found' => 'Link not found.',
        'delete_confirm' => 'Are you sure you want to delete this link?',
        'no_items' => 'No short links yet.',
        'copied' => 'Link copied!',
        'expired' => 'This link has expired.',
        'inactive' => 'This link is no longer active.',
    ],

    'placeholders' => [
        'code' => 'Auto-generated',
        'target_url' => 'https://example.com/long-url-here',
        'title' => 'Link description (optional)',
    ],

    'help' => [
        'code' => 'Leave empty to auto-generate. Letters and numbers only.',
        'expires_at' => 'Leave empty for no expiration.',
    ],
];
