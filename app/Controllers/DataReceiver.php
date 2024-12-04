<?php

namespace App\Controllers;

use App\Models\KehadiranSementaraModel;
use App\Models\SiswaModel;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class DataReceiver extends ResourceController
{
    protected $siswa;
    protected $kehadiranSementara;
    protected $db;
    function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->kehadiranSementara = new KehadiranSementaraModel();
        $this->db      = \Config\Database::connect();
    }
    public function index()
    {
        log_message('info', 'DataReceiver controller invoked');
        // $kartu = 463920539;
        $kartu = $_POST['card'];
        $siswa = $this->siswa->join('level', 'siswa.id_level = level.id_level')->where('id_kartu', "$kartu")->first();
        if (!$siswa) {
            $response = [
                'status' => 'failed',
                'eror' => 'data siswa tidak ditemukan'
            ];
            return $this->respond($response);
        }

        // $guru = $this->db->table('guru')->join('sanggar', 'guru.id_sanggar = sanggar.id_sanggar')->where('sanggar.id_sanggar', '1')->get()->getResultArray();;
        // dd($guru);

        $data = [
            'id_siswa' => $siswa['id_siswa'],
            'kehadiran' => 'hadir',
            'tanggal' => Time::now(),
            'level' => $siswa['level'],
            'id_sanggar' => $siswa['id_sanggar'],
            'id_guru' => 1,
            'konfirmasi' => 0
        ];
        $this->kehadiranSementara->insert($data);
        $siswa = $siswa['nama_siswa'];
        $response = [
            'status' => 'success',
            'data' => $siswa,
            'eror' => ''
        ];
        // dd($data);
        // echo $siswa[0]['nama_siswa'];

        return $this->respond($response);
    }
}
