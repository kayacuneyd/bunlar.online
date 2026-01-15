<?php

namespace App\Modules\ProfileLink\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProfileLinkSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // Demo profile links
            [
                'profile_id' => 1,
                'title' => 'Website',
                'url' => 'https://example.com',
                'icon' => '🌐',
                'position' => 0,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'profile_id' => 1,
                'title' => 'GitHub',
                'url' => 'https://github.com',
                'icon' => '💻',
                'position' => 1,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'profile_id' => 1,
                'title' => 'Twitter / X',
                'url' => 'https://x.com',
                'icon' => '📱',
                'position' => 2,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'profile_id' => 1,
                'title' => 'LinkedIn',
                'url' => 'https://linkedin.com',
                'icon' => '💼',
                'position' => 3,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            // Test profile links
            [
                'profile_id' => 2,
                'title' => 'Portfolio',
                'url' => 'https://portfolio.example.com',
                'icon' => '🎨',
                'position' => 0,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'profile_id' => 2,
                'title' => 'Blog',
                'url' => 'https://blog.example.com',
                'icon' => '📝',
                'position' => 1,
                'click_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];

        $this->db->table('profile_links')->insertBatch($data);
    }
}
