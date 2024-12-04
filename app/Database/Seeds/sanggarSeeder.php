<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

use Faker\Factory;

class sanggarSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create('id_ID');
        $data = [];
        for ($i = 0; $i < 8; $i++) {
            $datanew = [

                'Sanggar' => $faker->company(),
                'Alamat_sanggar' => $faker->address(),

            ];
            $data[] = $datanew;
        }

        // Simple Queries
        // $this->db->query('INSERT INTO menu_user (menu) VALUES(:menu:, :email:)', $data);

        // Using Query Builder
        $this->db->table('sanggar')->insertBatch($data);
    }
}
