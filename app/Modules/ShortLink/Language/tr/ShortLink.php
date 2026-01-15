<?php

return [
    'admin' => [
        'title' => 'Kisa Linkler',
        'create' => 'Yeni Kisa Link',
        'edit' => 'Link Duzenle',
        'show' => 'Link Detayi',
        'list' => 'Link Listesi',
    ],

    'fields' => [
        'code' => 'Kisa Kod',
        'target_url' => 'Hedef URL',
        'title' => 'Baslik',
        'short_url' => 'Kisa URL',
        'click_count' => 'Tiklanma',
        'expires_at' => 'Bitis Tarihi',
        'is_active' => 'Aktif',
        'created_at' => 'Olusturulma',
    ],

    'buttons' => [
        'create' => 'Yeni Link',
        'save' => 'Kaydet',
        'update' => 'Guncelle',
        'delete' => 'Sil',
        'cancel' => 'Iptal',
        'back' => 'Geri',
        'edit' => 'Duzenle',
        'copy' => 'Kopyala',
        'view' => 'Goruntule',
    ],

    'messages' => [
        'created' => 'Kisa link basariyla olusturuldu.',
        'updated' => 'Link basariyla guncellendi.',
        'deleted' => 'Link basariyla silindi.',
        'not_found' => 'Link bulunamadi.',
        'delete_confirm' => 'Bu linki silmek istediginizden emin misiniz?',
        'no_items' => 'Henuz kisa link olusturulmamis.',
        'copied' => 'Link kopyalandi!',
        'expired' => 'Bu linkin suresi dolmus.',
        'inactive' => 'Bu link artik aktif degil.',
    ],

    'placeholders' => [
        'code' => 'Otomatik olusturulur',
        'target_url' => 'https://example.com/uzun-url-buraya',
        'title' => 'Link aciklamasi (opsiyonel)',
    ],

    'help' => [
        'code' => 'Bos birakirsaniz otomatik olusturulur. Sadece harf ve rakam.',
        'expires_at' => 'Bos birakirsaniz link suressiz olur.',
    ],
];
