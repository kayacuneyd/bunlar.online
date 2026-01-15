<?php

namespace App\Modules\ShortLink\Entities;

use CodeIgniter\Entity\Entity;

class ShortLink extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'code' => null,
        'target_url' => null,
        'title' => null,
        'click_count' => 0,
        'expires_at' => null,
        'is_active' => true,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'click_count' => 'integer',
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at', 'expires_at'];

    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }

    public function isExpired(): bool
    {
        if (empty($this->attributes['expires_at'])) {
            return false;
        }

        $expiresAt = $this->attributes['expires_at'];
        if (is_string($expiresAt)) {
            $expiresAt = new \DateTime($expiresAt);
        }

        return $expiresAt < new \DateTime();
    }

    public function isValid(): bool
    {
        return $this->isActive() && !$this->isExpired();
    }

    public function getShortUrl(): string
    {
        return site_url('l/' . $this->attributes['code']);
    }

    public function incrementClickCount(): void
    {
        $this->attributes['click_count']++;
    }
}
