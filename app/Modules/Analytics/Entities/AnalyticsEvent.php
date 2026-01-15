<?php

namespace App\Modules\Analytics\Entities;

use CodeIgniter\Entity\Entity;

class AnalyticsEvent extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'event_type' => null,
        'target_id' => null,
        'user_agent' => null,
        'referrer' => null,
        'created_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => '?integer',
        'target_id' => 'integer',
        'created_at' => 'datetime',
    ];

    protected $dates = ['created_at'];

    public function isProfileView(): bool
    {
        return $this->attributes['event_type'] === 'profile_view';
    }

    public function isProfileLinkClick(): bool
    {
        return $this->attributes['event_type'] === 'profile_link_click';
    }

    public function isShortLinkClick(): bool
    {
        return $this->attributes['event_type'] === 'short_link_click';
    }

    public function getBrowserName(): ?string
    {
        $ua = $this->attributes['user_agent'];
        if (empty($ua)) {
            return null;
        }

        if (stripos($ua, 'Chrome') !== false) return 'Chrome';
        if (stripos($ua, 'Firefox') !== false) return 'Firefox';
        if (stripos($ua, 'Safari') !== false) return 'Safari';
        if (stripos($ua, 'Edge') !== false) return 'Edge';
        if (stripos($ua, 'Opera') !== false) return 'Opera';

        return 'Other';
    }

    public function isMobile(): bool
    {
        $ua = $this->attributes['user_agent'] ?? '';
        return preg_match('/Mobile|Android|iPhone|iPad/i', $ua) === 1;
    }

    public function getReferrerDomain(): ?string
    {
        $referrer = $this->attributes['referrer'];
        if (empty($referrer)) {
            return null;
        }

        $parsed = parse_url($referrer);
        return $parsed['host'] ?? null;
    }
}
