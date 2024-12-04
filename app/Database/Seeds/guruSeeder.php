    <?php

    namespace App\Database\Seeds;

    use CodeIgniter\Database\Seeder;
    use CodeIgniter\I18n\Time;
    use Faker\Factory;



    class guruSeeder extends Seeder
    {
        public function run()
        {

            $faker = Factory::create('id_ID');
            $data = [];

            for ($i = 0; $i < 100; $i++) {
                $sanggar = rand(1, 8);
                $jk =  ['pria', 'wanita'];
                $jk = $faker->randomElement($jk);
                $pelajaran = ['umum', 'agama'];
                $pelajaran = $faker->randomElement($pelajaran);

                $datanew = [
                    'id_guru' => '',
                    'nama_guru' => $faker->name(),
                    'jenis_kelamin' => $jk,
                    'Alamat_guru' => $faker->address(),
                    'telp_guru' => $faker->phoneNumber(),
                    'id_sanggar' => $sanggar,
                    'pelajaran' => $pelajaran,
                    'daftar' => Time::now()->getLocal()
                ];
                // $this->db->table('siswa')->insert($data);
                $data[] = $datanew;
            }

            // Simple Queries
            // $this->db->query('INSERT INTO menu_user (`nama_siswa`, `kelas`, `alamat_siswa`, `telp_siswa`, `jenis_kelamin`, `status`, `level`, `id_sanggar`, `id_kartu`) VALUES
            // (:nama_siswa:, :kelas:, :alamat_siswa:, :telp_siswa:, :jenis_kelamin:, :status:, :level:, :id_sanggar:, :id_kartu:)', $data);

            // Using Query Builder
            $this->db->table('guru')->insertBatch($data);
        }
    }
