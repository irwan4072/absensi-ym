<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Level extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_level' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'jilid' => [
                'type'       => 'VARCHAR',
                'constraint' => '1',
            ],
            'Materi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint' => '3',
            ],
            'Tema' => [
                'type'       => 'VARCHAR',
                'constraint' => '225',
            ],
        ]);
        $this->forge->addKey('id_level', true);
        $this->forge->createTable('level');
    }

    public function down()
    {
        $this->forge->dropTable('level');
    }
}
