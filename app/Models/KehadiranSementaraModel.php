<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranSementaraModel extends Model
{
    protected $table = 'kehadiran_sementara';
    protected $primaryKey = 'id_kehadiran_sementara';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id_siswa', 'kehadiran', 'level', 'tanggal',  'id_sanggar'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_kehadiran_sementara', $data)->first();
        }
    }
}
