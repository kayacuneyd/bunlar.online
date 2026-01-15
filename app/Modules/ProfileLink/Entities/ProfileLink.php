<?php

namespace App\Modules\ProfileLink\Entities;

use CodeIgniter\Entity\Entity;

class ProfileLink extends Entity
{
    protected $attributes = [
        'id' => null,
        'profile_id' => null,
        'title' => null,
        'url' => null,
        'icon' => null,
        'position' => 0,
        'click_count' => 0,
        'is_active' => true,
        'created_at' => null,
        'updated_at' => null,
    ];

    protected $casts = [
        'id' => 'integer',
        'profile_id' => 'integer',
        'position' => 'integer',
        'click_count' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function isActive(): bool
    {
        return (bool) $this->attributes['is_active'];
    }

    public function incrementClickCount(): void
    {
        $this->attributes['click_count']++;
    }

    public function getIconEmoji(): ?string
    {
        return $this->attributes['icon'];
    }
}
