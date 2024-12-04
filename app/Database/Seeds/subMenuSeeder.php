<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
// use CodeIgniter\I18n\Time;

class subMenuSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_menu' => 1,
                'sub_menu' => 'Data Staf',
                'url' => '/admin/staf',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 1,
                'sub_menu' => 'Data Guru',
                'url' => '/admin/guru',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 1,
                'sub_menu' => 'Data Siswa',
                'url' => '/admin/siswa',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 1,
                'sub_menu' => 'Kegiatan',
                'url' => '/kegiatan',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 2,
                'sub_menu' => 'kehadiran',
                'url' => '/kehadiran',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 2,
                'sub_menu' => 'kegiatan',
                'url' => '/kehadiran',
                'icon' => 'fa-solid fa-user-tie',
            ],
            [
                'id_menu' => 3,
                'sub_menu' => 'Absensi',
                'url' => '/absensi',
                'icon' => 'fa-solid fa-user-tie',
            ],
        ];

        // Simple Queries
        // $this->db->query('INSERT INTO menu_user (menu) VALUES(:menu:, :email:)', $data);

        // Using Query Builder
        $this->db->table('subMenu_user')->insertBatch($data);
    }
}
