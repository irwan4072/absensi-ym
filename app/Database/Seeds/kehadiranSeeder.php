<?php

namespace App\Database\Seeds;

use App\Models\LevelModel;
use App\Models\SiswaModel;
use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use Faker\Factory;

class kehadiranSeeder extends Seeder
{
    public function run()
    {
        $siswaModel = new SiswaModel();
        $siswaAll = $siswaModel->getData();
        $faker = Factory::create('id_ID');
        $sanggarAll = $this->db->table('sanggar')->get()->getResultArray();

        // Inisialisasi array untuk menyimpan tanggal unik per sanggar
        $sanggarTanggal = [];

        // Buat tanggal untuk setiap sanggar
        foreach ($sanggarAll as $sanggar) {
            $sanggar = $sanggar['id_sanggar'];

            // Jika belum ada tanggal untuk sanggar ini, buat tanggal unik untuk setiap bulan
            if (!isset($sanggarTanggal[$sanggar])) {
                $sanggarTanggal[$sanggar] = [];

                // Iterasi setiap bulan dalam setahun
                for ($month = 1; $month <= 12; $month++) {
                    $year = date('Y');
                    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                    $sanggarTanggal[$sanggar][$month] = [];

                    // Pilih 10 tanggal unik dalam bulan ini
                    while (count($sanggarTanggal[$sanggar][$month]) < 10) {
                        $day = rand(1, $daysInMonth);
                        $tanggal = sprintf('%04d-%02d-%02d', $year, $month, $day);

                        // Pastikan tanggal unik untuk bulan ini
                        if (!in_array($tanggal, $sanggarTanggal[$sanggar][$month])) {
                            $sanggarTanggal[$sanggar][$month][] = $tanggal;
                        }
                    }
                }
            }
        }
        // dd($sanggarAll);

        // Buat kehadiran untuk setiap siswa
        $data = []; // Inisialisasi array data di luar loop
        $z = 0;
        foreach ($siswaAll as $siswa) {
            $sanggar = $siswa['id_sanggar'];

            // Buat kehadiran untuk setiap bulan
            for ($month = 1; $month <= 12; $month++) {
                // Ambil semua tanggal untuk bulan yang sesuai
                // dd($sanggarTanggal[$sanggar]);
                $tanggalList = $sanggarTanggal[$sanggar];
                $tanggalList = $tanggalList[$month];

                foreach ($tanggalList as $tanggal) {
                    $waktu = $tanggal . ' ' . $faker->time('H:i:s');

                    // Random kehadiran
                    $rand = rand(1, 8);
                    if ($rand % 4 == 1) {
                        $hadir = 'hadir';
                        $level = intval($siswa['id_level']) + 1;
                    } elseif ($rand % 4 == 2) {
                        $hadir = 'sakit';
                        $level = $siswa['id_level'];
                    } elseif ($rand % 4 == 3) {
                        $hadir = 'izin';
                        $level = $siswa['id_level'];
                    } else {
                        $hadir = 'alfa';
                        $level = $siswa['id_level'];
                    }

                    // Membuat array baru untuk dimasukkan ke database
                    $dataNew = [
                        'kehadiran' => $hadir,
                        'id_siswa' => $siswa['id_siswa'],
                        'tanggal' => $waktu,
                        'level' => $level,
                        'id_sanggar' => $sanggar,
                    ];
                    $data[] = $dataNew;
                }
            }
            $z++;
        }

        // Insert data ke database
        $this->db->table('kehadiran')->insertBatch($data);



        // dd($sanggarTanggal);

        // Insert data ke database
        $this->db->table('kehadiran')->insertBatch($data);


        // Insert data ke database
        $this->db->table('kehadiran')->insertBatch($data);
    }
}
