<?php

if (!function_exists('profile_url')) {
    function profile_url($itemOrUsername): string
    {
        $username = is_object($itemOrUsername) ? $itemOrUsername->username : $itemOrUsername;
        return site_url($username);
    }
}

if (!function_exists('profile_admin_url')) {
    function profile_admin_url(?int $id = null, string $action = ''): string
    {
        $url = 'admin/profiles';

        if ($id !== null) {
            $url .= '/' . $id;
        }

        if ($action !== '') {
            $url .= '/' . $action;
        }

        return site_url($url);
    }
}

if (!function_exists('profile_avatar_url')) {
    function profile_avatar_url(?string $avatar, string $default = '/assets/img/default-avatar.svg'): string
    {
        if (empty($avatar)) {
            return $default;
        }
        return site_url('uploads/avatars/' . $avatar);
    }
}

if (!function_exists('profile_active_badge')) {
    function profile_active_badge(bool $isActive): string
    {
        if ($isActive) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Pasif</span>';
    }
}

if (!function_exists('profile_theme_badge')) {
    function profile_theme_badge(string $theme): string
    {
        $themes = [
            'minimal' => '<span class="badge bg-light text-dark">Minimal</span>',
            'dark' => '<span class="badge bg-dark">Dark</span>',
            'colorful' => '<span class="badge bg-primary">Colorful</span>',
            'gradient' => '<span class="badge bg-info">Gradient</span>',
        ];

        return $themes[$theme] ?? '<span class="badge bg-secondary">' . esc($theme) . '</span>';
    }
}

if (!function_exists('profile_format_date')) {
    function profile_format_date($date, string $format = 'd.m.Y H:i'): string
    {
        if (empty($date)) {
            return '-';
        }

        if (is_object($date) && method_exists($date, 'format')) {
            return $date->format($format);
        }

        return date($format, strtotime($date));
    }
}

if (!function_exists('profile_format_count')) {
    function profile_format_count(int $count): string
    {
        if ($count >= 1000000) {
            return round($count / 1000000, 1) . 'M';
        }
        if ($count >= 1000) {
            return round($count / 1000, 1) . 'K';
        }
        return (string) $count;
    }
}

if (!function_exists('profile_qr_url')) {
    function profile_qr_url(string $username): string
    {
        $profileUrl = site_url($username);
        return 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($profileUrl);
    }
}
