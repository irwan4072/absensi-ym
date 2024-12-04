<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_user' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'Alamat_user' => [
                'type' => 'TEXT',
                'constraint' => '225',
                'null' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '225',
            ],
            'Password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'telp_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '15',
            ],
            'jabatan' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => true,
            ],
            'daftar' => [
                'type' => 'DateTime',
            ],
        ]);
        $this->forge->addKey('id_user', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
