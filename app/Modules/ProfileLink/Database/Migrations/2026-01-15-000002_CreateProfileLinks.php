<?php

namespace App\Modules\ProfileLink\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProfileLinks extends Migration
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
            'profile_id' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'url' => [
                'type' => 'TEXT',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'position' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
            ],
            'click_count' => [
                'type' => 'INTEGER',
                'constraint' => 11,
                'default' => 0,
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
        $this->forge->addKey('profile_id');
        $this->forge->addKey('position');
        $this->forge->addKey('is_active');

        $this->forge->createTable('profile_links');
    }

    public function down()
    {
        $this->forge->dropTable('profile_links');
    }
}
