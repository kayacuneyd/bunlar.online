<?php

namespace App\Modules\Profile\Entities;

use CodeIgniter\Entity\Entity;

class Profile extends Entity
{
    protected $attributes = [
        'id' => null,
        'user_id' => null,
        'username' => null,
        'display_name' => null,
        'bio' => null,
        'avatar' => null,
        'theme' => 'minimal',
        'ga_measurement_id' => null,
        'view_count' => 0,
        'is_active' => true,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'view_count' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }

    public function getProfileUrl(): string
    {
        return site_url($this->attributes['username']);
    }

    public function getAvatarUrl(): ?string
    {
        if (empty($this->attributes['avatar'])) {
            return null;
        }
        return site_url('uploads/avatars/' . $this->attributes['avatar']);
    }

    public function getQrCodeUrl(): string
    {
        return site_url($this->attributes['username'] . '/qr');
    }

    public function incrementViewCount(): void
    {
        $this->attributes['view_count']++;
    }
}
