<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sanggar extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_sanggar' => [
                'type'           => 'INT',
                'constraint'     => '5',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'Sanggar' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'Alamat_sanggar' => [
                'type'       => 'VARCHAR',
                'constraint' => '225',
            ],
        ]);
        $this->forge->addKey('id_sanggar', true);
        $this->forge->createTable('sanggar');
    }

    public function down()
    {
        $this->forge->dropTable('sanggar');
    }
}
