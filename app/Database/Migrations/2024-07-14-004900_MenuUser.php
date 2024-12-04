<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MenuUser extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'menu' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('menu_user');
    }

    public function down()
    {
        $this->forge->dropTable('menu_user');
    }
}
