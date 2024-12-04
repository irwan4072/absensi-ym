<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
// use CodeIgniter\I18n\Time;

class menuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'menu' => 'Management Master',
            ],
            [
                'menu' => 'management',
            ],
            [
                'menu' => 'kehadiran',
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO menu_user (menu) VALUES(:menu:, :email:)', $data);

        // Using Query Builder
        $this->db->table('menu_user')->insertBatch($data);
    }
}
