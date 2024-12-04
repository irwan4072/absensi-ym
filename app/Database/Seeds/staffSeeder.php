<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;



class staffSeeder extends Seeder
{
    public function run()
    {

        $faker = Factory::create('id_ID');


        $sanggar = rand(1, 8);
        $jk =  ['pria', 'wanita'];
        $jk = $faker->randomElement($jk);
        $pelajaran = ['umum', 'agama'];
        $pelajaran = $faker->randomElement($pelajaran);

        $data = [
            'id_staff' => '',
            'nama_staff' => $faker->name(),
            'jenis_kelamin' => $jk,
            'Alamat_staff' => $faker->address(),
            'telp_staff' => $faker->phoneNumber(),
            'jabatan' => 'Staff Program',
            'daftar' => Time::now()->getLocal()
        ];
        // $this->db->table('siswa')->insert($data);


        // Simple Queries
        // $this->db->query('INSERT INTO menu_user (`nama_siswa`, `kelas`, `alamat_siswa`, `telp_siswa`, `jenis_kelamin`, `status`, `level`, `id_sanggar`, `id_kartu`) VALUES
        // (:nama_siswa:, :kelas:, :alamat_siswa:, :telp_siswa:, :jenis_kelamin:, :status:, :level:, :id_sanggar:, :id_kartu:)', $data);

        // Using Query Builder
        $this->db->table('staff')->insert($data);
    }
}
