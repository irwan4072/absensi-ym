<?php

namespace App\Controllers;

use App\Models\SiswaModel;
use App\Models\KehadiranSementaraModel;
use App\Models\KehadiranModel;

class Auto extends BaseController
{
    public function prosesKehadiran()
    {
        // Inisialisasi model
        $siswaModel = new SiswaModel();
        $konfirmasiKehadiranModel = new KehadiranSementaraModel();
        $kehadiranModel = new KehadiranModel();

        // Ambil id_sanggar yang ada di konfirmasi kehadiran minimal satu hari
        $sanggars = $konfirmasiKehadiranModel->select('id_sanggar')
            ->where('DATEDIFF(NOW(), tanggal) >=', 1)
            ->groupBy('id_sanggar')
            ->findAll();
        $i = 1;
        foreach ($sanggars as $sanggar) {
            $id_sanggar = $sanggar['id_sanggar'];

            // Ambil semua siswa berdasarkan id_sanggar
            $siswaList = $siswaModel->where('id_sanggar', $id_sanggar)->findAll();
            // dd($siswaList);

            foreach ($siswaList as $siswa) {
                // Cek apakah siswa ada di konfirmasi kehadiran
                $kehadiran = $konfirmasiKehadiranModel
                    ->select('id_kehadiran_sementara')
                    ->where('id_siswa', $siswa['id_siswa'])
                    ->where('DATEDIFF(NOW(), tanggal) >=', 1)
                    ->first();



                if ($kehadiran) {
                } else {
                    // Jika siswa tidak ada di konfirmasi, tambahkan status "alfa"
                    $kehadiranModel->insert([
                        'id_siswa' => $siswa['id_siswa'],
                        'status' => 'alfa',
                        'tanggal_kehadiran' => date('Y-m-d'),
                        'id_sanggar' => $id_sanggar
                    ]);
                    echo "Siswa: " . $siswa['nama_siswa'] . " Kehadiran: Alfa <br>";
                    $i++;
                }
            }
            die;
        }
    }
}
