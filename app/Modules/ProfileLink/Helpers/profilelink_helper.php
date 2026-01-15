<?php

if (!function_exists('profilelink_admin_url')) {
    function profilelink_admin_url(?int $id = null, string $action = ''): string
    {
        $url = 'admin/profile-links';

        if ($id !== null) {
            $url .= '/' . $id;
        }

        if ($action !== '') {
            $url .= '/' . $action;
        }

        return site_url($url);
    }
}

if (!function_exists('profilelink_active_badge')) {
    function profilelink_active_badge(bool $isActive): string
    {
        if ($isActive) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Pasif</span>';
    }
}

if (!function_exists('profilelink_format_count')) {
    function profilelink_format_count(int $count): string
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

if (!function_exists('profilelink_format_date')) {
    function profilelink_format_date($date, string $format = 'd.m.Y H:i'): string
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

if (!function_exists('profilelink_truncate_url')) {
    function profilelink_truncate_url(string $url, int $length = 40): string
    {
        if (mb_strlen($url) <= $length) {
            return $url;
        }
        return mb_substr($url, 0, $length) . '...';
    }
}
