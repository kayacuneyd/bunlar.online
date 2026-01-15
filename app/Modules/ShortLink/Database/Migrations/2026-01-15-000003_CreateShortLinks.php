<?php

namespace App\Modules\ShortLink\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateShortLinks extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'unique' => true,
            ],
            'target_url' => [
                'type' => 'TEXT',
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'click_count' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('code');
        $this->forge->addKey('user_id');
        $this->forge->addKey('is_active');
        $this->forge->addKey('expires_at');

        $this->forge->createTable('short_links');
    }

    public function down()
    {
        $this->forge->dropTable('short_links');
    }
}
