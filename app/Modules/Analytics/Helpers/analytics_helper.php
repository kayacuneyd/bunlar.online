<?php

if (!function_exists('analytics_format_count')) {
    function analytics_format_count(int $count): string
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

if (!function_exists('analytics_percent')) {
    function analytics_percent(int $part, int $total): string
    {
        if ($total === 0) {
            return '0%';
        }
        return round(($part / $total) * 100, 1) . '%';
    }
}

if (!function_exists('analytics_trend_class')) {
    function analytics_trend_class(int $current, int $previous): string
    {
        if ($current > $previous) {
            return 'text-success';
        }
        if ($current < $previous) {
            return 'text-danger';
        }
        return 'text-muted';
    }
}

if (!function_exists('analytics_trend_icon')) {
    function analytics_trend_icon(int $current, int $previous): string
    {
        if ($current > $previous) {
            return '<i class="bi bi-arrow-up"></i>';
        }
        if ($current < $previous) {
            return '<i class="bi bi-arrow-down"></i>';
        }
        return '<i class="bi bi-dash"></i>';
    }
}

if (!function_exists('analytics_format_referrer')) {
    function analytics_format_referrer(?string $referrer): string
    {
        if (empty($referrer)) {
            return 'Dogrudan';
        }

        $parsed = parse_url($referrer);
        return $parsed['host'] ?? $referrer;
    }
}

if (!function_exists('analytics_chart_data')) {
    function analytics_chart_data(array $data): string
    {
        return json_encode(array_values($data));
    }
}

if (!function_exists('analytics_chart_labels')) {
    function analytics_chart_labels(array $data): string
    {
        $labels = array_map(function($date) {
            return date('d M', strtotime($date));
        }, array_keys($data));

        return json_encode($labels);
    }
}
