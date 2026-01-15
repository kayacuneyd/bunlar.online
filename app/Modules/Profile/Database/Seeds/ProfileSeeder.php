<?php

namespace App\Modules\Profile\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'user_id' => 1,
                'username' => 'demo',
                'display_name' => 'Demo User',
                'bio' => 'Bu bir demo profil sayfasidir. Linktree benzeri profil ozelliklerini test edin!',
                'avatar' => null,
                'theme' => 'minimal',
                'ga_measurement_id' => null,
                'view_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
            [
                'user_id' => 1,
                'username' => 'test',
                'display_name' => 'Test Profile',
                'bio' => 'Dark tema ornek profili',
                'avatar' => null,
                'theme' => 'dark',
                'ga_measurement_id' => null,
                'view_count' => 0,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ];

        $this->db->table('profiles')->insertBatch($data);
    }
}
