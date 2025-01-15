<?php

namespace App\Controllers;

use \App\Models\userModel;
use App\Models\SiswaModel;
use App\Models\SanggarModel;
use App\Models\LevelModel;
use App\Models\KehadiranModel;
use App\Models\KehadiranSementaraModel;
use CodeIgniter\I18n\Time;



class Kehadiran extends BaseController
{
    protected $siswa;
    protected $user;
    protected $level;
    protected $kehadiran;
    protected $kehadiran_sementara;
    protected $session;
    protected $helperKehadiran;
    protected $db;


    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->user = new UserModel();
        $this->level = new LevelModel();
        $this->kehadiran = new KehadiranModel();
        $this->kehadiran_sementara = new KehadiranSementaraModel();
        $this->session = \Config\Services::session();
        $this->helperKehadiran = helper('kehadiran');
        // helper('App\Helpers\kehadiran');
        $this->db      = \Config\Database::connect();
    }
    public function indexx()
    {

        session();
        helper('kehadiran');
        $id_sanggar = session()->get('id_sanggar');
        $date = date('Y-m');
        $bulanSkrg = $date . '-20';
        $bulanLalu = jarak_waktu($date);
        $siswa = $this->siswa->findAll();
        // $kehadiran = $this->kehadiran->findAll();
        $sql = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND id_sanggar = '$id_sanggar'";
        // dd(session()->get('id_sanggar'));
        $kehadiran = $this->db->query($sql)->getResultArray();
        // $kehadiran = $this->db->query("SELECT * FROM kehadiran WHERE (tanggal between '2023-02-15' AND '2023-03-15' );")->getResultArray();
        // dd($kehadiran);
        $thnBln = explode('-', $date);
        $thn = $thnBln[0];
        $bln = $thnBln[1];
        $data = [
            'title' => 'YM  | Kehadiran',
            'siswa' => $siswa,
            'kehadiran' => $kehadiran,
            'bulan' => $date,
            'bln' => $bln,
            'thn' => $thn,
            'bulanLalu' => $bulanLalu,
            'bulanSkrg' => $bulanSkrg


        ];
        return view('kehadiran/daftar_Hadir', $data);
        // return view('kehadiran/daftar_Hadir', $data);
    }
    public function index($bulan = null, $id_sanggar = 1)
    {
        session();
        $sanggar = $this->db->table('sanggar')->get()->getResultArray();
        // dd(date('Y-m'));
        if ($bulan == null) {
            $bulan = date('Y-m');
        }
        // dd($bulan);
        // $date = date('Y-m');
        $siswa = $this->siswa->findAll();


        $bulanSkrg = $bulan . '-21';
        $bulanLalu = jarak_waktu($bulan);
        $siswa = $this->siswa->join('sanggar', 'siswa.id_sanggar = sanggar.id_sanggar')->where('sanggar.id_sanggar', $id_sanggar)->findAll();
        $query = "SELECT * FROM kehadiran JOIN sanggar ON kehadiran.id_sanggar = sanggar.id_sanggar WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND sanggar.id_sanggar= $id_sanggar ";
        // $kehadiran = $this->kehadiran->findAll();
        $kehadiran = $this->db->query($query)->getResultArray();
        // $kehadiran = $this->db->table('kehadiran')->like('tanggal', $bulan)->get()->getResultArray();
        $date = explode('-', $bulan);
        $thn = $date[0];
        $bln = $date[1];
        $sanggar =
            // dd($kehadiran);
            $data = [
                'title' => 'YM | Laporan Kehadiran',
                'siswa' => $siswa,
                'sanggar' => $sanggar,
                'id_sanggar' => $id_sanggar,
                'kehadiran' => $kehadiran,
                'bulan' => $bulan,
                'bln' => $bln,
                'thn' => $thn,
                'bulanLalu' => $bulanLalu,
                'bulanSkrg' => $bulanSkrg


            ];
        return view('kehadiran/daftar_Hadir', $data);
    }


    public function konfirmasi_kehadiran()
    {
        session();
        $kehadiran_sementara = $this->kehadiran_sementara->where('id_sanggar', session()->get('id_sanggar'))->findAll();
        $siswa = $this->siswa->where('id_sanggar', session()->get('id_sanggar'))->findAll();
        // dd($siswa);


        $data = [
            'title' => 'YM  | Konfirmasi Kehadiran',
            'siswa' => $siswa,
            'kehadiran_sementara' => $kehadiran_sementara,


        ];
        return view('kehadiran/konfirmasi_kehadiran', $data);
        // return view('kehadiran/daftar_Hadir', $data);
    }

    public function simpan_kehadiran()
    {
        session();
        // $db = \Config\Database::connect();
        // $card = '3591216';
        // // $card = $this->request->getVar('card');
        // $siswa = $this->siswa->where('card', $card)->first();
        // dd($siswa);
        // // echo $card;
        // // echo "selamat datang" . $siswa[0]['nama'];
        // die;
        // $siswa =
        $idSiswa = $this->request->getVar('idSiswa');
        $kehadiran = $this->request->getVar('kehadiran');
        $naikLevel = $this->request->getVar('naikLevel');
        // // dd($naikLevel);
        // // dd($idSiswa);

        for ($i = 0; $i < count($idSiswa); $i++) {
            $siswaHadir = $this->siswa
                ->join('level', 'siswa.id_level = level.id_level')
                ->where('id_siswa', $idSiswa[$i])->first();
            // $naikLevel = $naikLevel[$i];
            if (isset($naikLevel[$i])) {
                // $siswa = cari_hadir('siswa', 'id', $idSiswa);
                // $level = cari_hadir('level', 'id', $siswa);

                $levelInfo = $siswaHadir['level'];
                $levelInt = intval($levelInfo);
                d($levelInfo);
                $level = $this->getMaxLevelFromDatabase($levelInfo);
                dd($level);

                $data = [

                    'id_level' => "$level"
                ];
                $sql = "UPDATE `siswa` SET `id_level`= '$level' WHERE `id_siswa` = $idSiswa[$i]";
                // dd($sql);
                $this->db->query($sql);
                // die;
                // $this->siswa->where('id_siswa', $idSiswa[$i])->update($data);
            } else {
                $level = $siswaHadir['id_level'];
            }


            // d($level);
            $siswaHadir = [
                'id_siswa' => $idSiswa[$i],
                'kehadiran' => $kehadiran[$i],
                'tanggal' => Time::now(),
                'level' => $level,
                'id_sanggar' => session()->get('id_sanggar'),
                'id_guru' => session()->get('id_guru'),
            ];

            $this->kehadiran->insert($siswaHadir);
            $this->kehadiran_sementara->where('id_siswa', $siswaHadir['id_siswa'])->delete();
        }
        // die;
        session()->setFlashdata('pesan', 'data berhasil ditambahkan');
        session()->setFlashdata('warna', 'success');
        return redirect()->to('kehadiran/konfirmasi_kehadiran');
    }
    function getMaxLevelFromDatabase($level)
    {
        // Ambil level maksimal dari database berdasarkan prefix
        $prefix = substr($level, 0, 1);
        $angka = substr($level, 1);
        $db = db_connect();
        $query = $db->query("SELECT MAX(CAST(SUBSTRING(level, 2) AS UNSIGNED)) AS max_level FROM level WHERE level LIKE '$prefix%'");
        $result = $query->getRowArray();
        $a = $result['max_level'];
        d($a);
        $lanjut = 0;
        $cari = 0;
        while ($lanjut < 1) {

            $angka += 1;
            $cari = $prefix . $angka;
            // dd($cari);
            $sql = "SELECT * FROM level WHERE level = '$cari' LIMIT 1";
            $siswaHadir = $db->query($sql)->getResultArray();
            // dd($siswaHadir);
            if (count($siswaHadir) > 0) {
                // dd($siswaHadir);s
                $lanjut = 2;
                // dd($lanjut);
                // die;
                return $siswaHadir[0]['id_level'];
            }
            // dd($siswaHadir);
            if ($angka > $a) {
                $prefix = $this->naikPrefix($prefix);
                $angka = 0;
                // dd($cari);
            }
        }
        // dd($cari);
        // Kembalikan level maksimal yang ditemukan

    }
    public function naikPrefix($before)
    {
        $levelPrefix = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
        $index = array_search($before, $levelPrefix);
        $naik = intval($index) + 1;
        // $levelPrefix = [
        //     1 => 'A',
        //     2 => 'B',
        //     3 => 'C',
        //     4 => 'D',
        //     5 => 'E',
        //     6 => 'F',
        //     7 => 'G',
        //     8 => 'H',
        //     9 => 'I',
        //     10 => 'J',
        //     11 => 'K',
        //     12 => 'L',
        // ];
        return $levelPrefix[$naik];
    }
    function getNextAvailableLevel($prefix, $maxLevel)
    {
        // Ambil level yang ada di database
        $existingLevels = $this->getExistingLevelsByPrefix($prefix);

        // Iterasi dari level 1 hingga maxLevel
        for ($i = 1; $i <= $maxLevel; $i++) {
            $currentLevel = $prefix . $i;
            if (!in_array($currentLevel, $existingLevels)) {
                // Jika level tidak ada di daftar yang sudah ada, kembalikan level ini
                return $currentLevel;
            }
        }
        // Jika tidak ada level yang tersedia, kembalikan null
        return null;
    }

    function getExistingLevelsByPrefix($prefix)
    {
        // Query database untuk mendapatkan level yang ada berdasarkan prefix
        $db = db_connect();
        $query = $db->query("SELECT level FROM level WHERE level LIKE '$prefix%' ORDER BY level ASC");
        $result = $query->getResultArray();

        // Ambil hanya kolom 'level'
        $levels = array_column($result, 'level');
        return $levels;
    }
}
