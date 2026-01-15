<?php

return [
    'admin' => [
        'title' => 'Profiller',
        'create' => 'Yeni Profil',
        'edit' => 'Profil Duzenle',
        'show' => 'Profil Detayi',
        'delete' => 'Profil Sil',
        'list' => 'Profil Listesi',
    ],

    'frontend' => [
        'title' => 'Profil',
        'show' => 'Profil Sayfasi',
        'no_items' => 'Henuz profil bulunmuyor.',
        'view_profile' => 'Profili Gor',
        'download_qr' => 'QR Kodu Indir',
    ],

    'fields' => [
        'username' => 'Kullanici Adi',
        'display_name' => 'Gorunen Ad',
        'bio' => 'Hakkinda',
        'avatar' => 'Profil Resmi',
        'theme' => 'Tema',
        'ga_measurement_id' => 'Google Analytics ID',
        'view_count' => 'Goruntulenme',
        'is_active' => 'Aktif',
        'created_at' => 'Olusturulma Tarihi',
        'updated_at' => 'Guncelleme Tarihi',
    ],

    'buttons' => [
        'create' => 'Yeni Profil',
        'save' => 'Kaydet',
        'update' => 'Guncelle',
        'delete' => 'Sil',
        'cancel' => 'Iptal',
        'back' => 'Geri',
        'edit' => 'Duzenle',
        'view' => 'Goruntule',
    ],

    'messages' => [
        'created' => 'Profil basariyla olusturuldu.',
        'updated' => 'Profil basariyla guncellendi.',
        'deleted' => 'Profil basariyla silindi.',
        'not_found' => 'Profil bulunamadi.',
        'delete_confirm' => 'Bu profili silmek istediginizden emin misiniz?',
        'username_taken' => 'Bu kullanici adi zaten kullaniliyor.',
        'username_reserved' => 'Bu kullanici adi sistemde ayrilmis.',
    ],

    'validation' => [
        'username_required' => 'Kullanici adi zorunludur.',
        'username_min_length' => 'Kullanici adi en az 3 karakter olmalidir.',
    ],
];
