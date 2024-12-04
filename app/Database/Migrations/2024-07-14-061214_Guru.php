<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Guru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_guru' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_guru' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'jenis_kelamin' => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
            ],
            'Alamat_guru' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'telp_guru' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_sanggar' => [
                'type' => 'INT',
                'constraint' => '2',
            ],
            'pelajaran' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
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
        $this->forge->addKey('id_guru', true);
        $this->forge->createTable('guru');
    }

    public function down()
    {
        $this->forge->dropTable('guru');
    }
}
