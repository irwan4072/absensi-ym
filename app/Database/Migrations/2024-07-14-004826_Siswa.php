<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Siswa extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_siswa' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_siswa' => [
                'type'       => 'VARCHAR',
                'constraint' => '225',
            ],
            'kelas' => [
                'type'       => 'INT',
                'constraint' => '2',
            ],
            'alamat_siswa' => [
                'type'       => 'TEXT',
                'constraint' => '100',
            ],
            'telp_siswa' => [
                'type' => 'VARCHAR',
                'constraint'     => '15',
                'null' => true,
            ],
            'jenis_kelamin' => [
                'type'       => 'TEXT',
                'constraint' => '100',
            ],
            'status' => [
                'type' => 'TEXT',
                'constraint'     => '2',
                'null' => true,
            ],
            'level' => [
                'type'       => 'VARCHAR',
                'constraint'     => '3',
            ],
            'id_sanggar' => [
                'type'       => 'INT',
                'constraint'     => '11',
            ],
            'id_kartu' => [
                'type'       => 'VARCHAR',
                'constraint'     => '10',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_siswa', true);
        $this->forge->createTable('siswa');
    }

    public function down()
    {
        $this->forge->dropTable('siswa');
    }
}
