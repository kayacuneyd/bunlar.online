<?php

return [
    'admin' => [
        'title' => 'Profiles',
        'create' => 'New Profile',
        'edit' => 'Edit Profile',
        'show' => 'Profile Details',
        'delete' => 'Delete Profile',
        'list' => 'Profile List',
    ],

    'frontend' => [
        'title' => 'Profile',
        'show' => 'Profile Page',
        'no_items' => 'No profiles found.',
        'view_profile' => 'View Profile',
        'download_qr' => 'Download QR Code',
    ],

    'fields' => [
        'username' => 'Username',
        'display_name' => 'Display Name',
        'bio' => 'Bio',
        'avatar' => 'Profile Picture',
        'theme' => 'Theme',
        'ga_measurement_id' => 'Google Analytics ID',
        'view_count' => 'Views',
        'is_active' => 'Active',
        'created_at' => 'Created At',
        'updated_at' => 'Updated At',
    ],

    'buttons' => [
        'create' => 'New Profile',
        'save' => 'Save',
        'update' => 'Update',
        'delete' => 'Delete',
        'cancel' => 'Cancel',
        'back' => 'Back',
        'edit' => 'Edit',
        'view' => 'View',
    ],

    'messages' => [
        'created' => 'Profile created successfully.',
        'updated' => 'Profile updated successfully.',
        'deleted' => 'Profile deleted successfully.',
        'not_found' => 'Profile not found.',
        'delete_confirm' => 'Are you sure you want to delete this profile?',
        'username_taken' => 'This username is already taken.',
        'username_reserved' => 'This username is reserved.',
    ],

    'validation' => [
        'username_required' => 'Username is required.',
        'username_min_length' => 'Username must be at least 3 characters.',
    ],
];
