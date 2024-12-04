<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kehadiran extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kehadiran' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kehadiran' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'level' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
                'null' => true,
            ],
            'id_sanggar' => [
                'type' => 'VARCHAR',
                'constraint' => '3',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_kehadiran', true);
        $this->forge->createTable('kehadiran');
    }

    public function down()
    {
        $this->forge->dropTable('kehadiran');
    }
}
