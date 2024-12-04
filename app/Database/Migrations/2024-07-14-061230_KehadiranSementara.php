<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KehadiranSementara extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_kehadiran_sementara' => [
                'type'           => 'INT',
                'constraint'     => '11',
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
                'type' => 'INT',
                'constraint' => '2',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_kehadiran_sementara', true);
        $this->forge->createTable('kehadiran_sementara');
    }

    public function down()
    {
        $this->forge->dropTable('kehadiran_sementara');
    }
}
