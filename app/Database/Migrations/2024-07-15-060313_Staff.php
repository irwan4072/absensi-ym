<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Staff extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_staff' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_staff' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ],
            'Alamat_staff' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telp_staff' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '25',
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'daftar' => [
                'type' => 'DateTime',
            ],
        ]);
        $this->forge->addKey('id_staff', true);
        $this->forge->createTable('staff');
    }

    public function down()
    {
        $this->forge->dropTable('staff');
    }
}
