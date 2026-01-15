<?php

namespace App\Modules\ShortLink\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShortLinkSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'code' => 'demo1',
                'target_url' => 'https://github.com',
                'title' => 'GitHub',
                'click_count' => 0,
                'expires_at' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'user_id' => 1,
                'code' => 'google',
                'target_url' => 'https://google.com',
                'title' => 'Google',
                'click_count' => 0,
                'expires_at' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'user_id' => 1,
                'code' => 'yt',
                'target_url' => 'https://youtube.com',
                'title' => 'YouTube',
                'click_count' => 0,
                'expires_at' => null,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];

        $this->db->table('short_links')->insertBatch($data);
    }
}
