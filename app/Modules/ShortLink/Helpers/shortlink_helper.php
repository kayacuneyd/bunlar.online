<?php

if (!function_exists('shortlink_url')) {
    function shortlink_url($itemOrCode): string
    {
        $code = is_object($itemOrCode) ? $itemOrCode->code : $itemOrCode;
        return site_url('l/' . $code);
    }
}

if (!function_exists('shortlink_admin_url')) {
    function shortlink_admin_url(?int $id = null, string $action = ''): string
    {
        $url = 'admin/short-links';

        if ($id !== null) {
            $url .= '/' . $id;
        }

        if ($action !== '') {
            $url .= '/' . $action;
        }

        return site_url($url);
    }
}

if (!function_exists('shortlink_active_badge')) {
    function shortlink_active_badge(bool $isActive): string
    {
        if ($isActive) {
            return '<span class="badge bg-success">Aktif</span>';
        }
        return '<span class="badge bg-secondary">Pasif</span>';
    }
}

if (!function_exists('shortlink_status_badge')) {
    function shortlink_status_badge($link): string
    {
        if (!$link->is_active) {
            return '<span class="badge bg-secondary">Pasif</span>';
        }
        if ($link->isExpired()) {
            return '<span class="badge bg-warning text-dark">Suresi Dolmus</span>';
        }
        return '<span class="badge bg-success">Aktif</span>';
    }
}

if (!function_exists('shortlink_format_count')) {
    function shortlink_format_count(int $count): string
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

if (!function_exists('shortlink_format_date')) {
    function shortlink_format_date($date, string $format = 'd.m.Y H:i'): string
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

if (!function_exists('shortlink_truncate_url')) {
    function shortlink_truncate_url(string $url, int $length = 50): string
    {
        if (mb_strlen($url) <= $length) {
            return $url;
        }
        return mb_substr($url, 0, $length) . '...';
    }
}

if (!function_exists('shortlink_copy_button')) {
    function shortlink_copy_button(string $text, string $btnClass = 'btn btn-sm btn-outline-secondary'): string
    {
        $id = 'copy-' . md5($text);
        return '<button type="button" class="' . $btnClass . '" onclick="copyToClipboard(\'' . esc($text, 'js') . '\', this)" title="Kopyala"><i class="bi bi-clipboard"></i></button>';
    }
}
