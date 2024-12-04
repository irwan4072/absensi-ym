<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;



class siswaSeeder extends Seeder
{
    public function run()
    {

        $faker = Factory::create('id_ID');
        $data = [];

        for ($i = 0; $i < 90; $i++) {
            $kelas = rand(1, 6);
            $sanggar = rand(1, 11);
            $kartu = rand(100000000, 9999999999);
            $jk =  ['pria', 'wanita'];
            $jk = $faker->randomElement($jk);
            $status = ['yatim', 'Non Yatim'];
            $status = $faker->randomElement($status);
            $level = rand(1, 148);

            $datanew = [
                'id_siswa' => '',
                'nama_siswa' => $faker->name(),
                'kelas' => $kelas,
                'alamat_siswa' => $faker->address(),
                'telp_siswa' => $faker->phoneNumber(),
                'jenis_kelamin' => $jk,
                'status' => $status,
                'id_level' => $level,
                'id_sanggar' => $sanggar,
                'id_kartu' => "$kartu",
                'created_at' => Time::now()->getLocal()
                // 'id_siswa' => '',
                // 'nama_siswa' => 'apa',
                // 'kelas' => 3,
                // 'alamat_siswa' => 'cikupa',
                // 'telp_siswa' => '098999',
                // 'jenis_kelamin' => 'pria',
                // 'status' => 'yatim',
                // 'level' => 23,
                // 'id_sanggar' => 4,
                // 'id_kartu' => "234567888",
                // 'created_at' => Time::now()->getLocal()
            ];
            // $this->db->table('siswa')->insert($data);
            $data[] = $datanew;
        }

        // Simple Queries
        // $this->db->query('INSERT INTO menu_user (`nama_siswa`, `kelas`, `alamat_siswa`, `telp_siswa`, `jenis_kelamin`, `status`, `level`, `id_sanggar`, `id_kartu`) VALUES
        // (:nama_siswa:, :kelas:, :alamat_siswa:, :telp_siswa:, :jenis_kelamin:, :status:, :level:, :id_sanggar:, :id_kartu:)', $data);

        // Using Query Builder
        $this->db->table('siswa')->insertBatch($data);
    }
}
