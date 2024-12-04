<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SubmenuUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sub' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_menu' => [
                'type'       => 'VARCHAR',
                'constraint'     => '11',
                'constraint' => '100',
            ],
            'sub_menu' => [
                'type' => 'VARCHAR',
                'constraint'     => '225',
                'null' => true,
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint'     => '225',
                'constraint' => '100',
            ],
            'icon' => [
                'type' => 'VARCHAR',
                'constraint'     => '225',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_sub', true);
        $this->forge->createTable('subMenu_user');
    }

    public function down()
    {
        $this->forge->dropTable('subMenu_user');
    }
}
