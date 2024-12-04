<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $db;
    protected $sanggar;
    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->sanggar = $this->db->table('sanggar')->get()->getResultArray();
    }
    public function index()
    {
        $session = session();
        // dd(session('role'));
        $db = $this->db;
        if (session()->get('role') == 'staff program') {
            $persentase_kehadiran = $db->query("SELECT (SUM(CASE WHEN kehadiran = 'hadir' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS persentase_kehadiran
        FROM kehadiran WHERE YEAR(tanggal) = YEAR(CURDATE())")->getRowArray();
            $persentase_detail = $db->query("SELECT 
                s.sanggar,(SUM(CASE WHEN k.kehadiran = 'hadir' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS persentase_kehadiran 
                FROM kehadiran k JOIN sanggar s ON k.id_sanggar = s.id_sanggar
                WHERE YEAR(k.tanggal) = YEAR(CURDATE()) GROUP BY s.sanggar")->getResultArray();
            $jml_guru = $db->query("SELECT COUNT(*) AS jml FROM guru ")->getRowArray();
            $jml_siswa = $db->query("SELECT COUNT(*) AS jml FROM siswa ")->getRowArray();
            $jml_kegiatanAktif = $db->query("SELECT COUNT(*) AS jml FROM kegiatan WHERE status = 1")->getRowArray();
        } else {
            $id_sanggar = session()->get('id_sanggar');
            $persentase_kehadiran = $db->query("SELECT (SUM(CASE WHEN kehadiran = 'hadir' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS persentase_kehadiran
                                        FROM kehadiran WHERE YEAR(tanggal) = YEAR(CURDATE()) AND id_sanggar = $id_sanggar")->getRowArray();
            $persentase_detail = $db->query("SELECT 
                                    s.nama_siswa,(SUM(CASE WHEN k.kehadiran = 'hadir' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS persentase_kehadiran 
                                    FROM kehadiran k JOIN siswa s ON k.id_siswa = s.id_siswa
                                    WHERE YEAR(k.tanggal) = YEAR(CURDATE()) AND k.id_sanggar = $id_sanggar GROUP BY s.id_siswa")->getResultArray();
            $jml_guru = 0;
            $jml_siswa = $db->query("SELECT COUNT(*) AS jml FROM siswa WHERE id_sanggar =  $id_sanggar")->getRowArray();
            $jml_kegiatanAktif = $db->query("SELECT COUNT(*) AS jml FROM kegiatan WHERE status = 1")->getRowArray();
        }


        // dd($persentase_detail);
        $data = [
            'persentase_kehadiran' => $persentase_kehadiran,
            'persentase_detail' => $persentase_detail,
            'jml_guru' => $jml_guru,
            'jml_siswa' => $jml_siswa,
            'jml_kegiatanAktif' => $jml_kegiatanAktif,
            'title' => 'YM | Dashboard',

        ];
        return view('home', $data);
    }
}
