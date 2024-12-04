<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranModel extends Model
{
    protected $table = 'kehadiran';
    protected $primaryKey = 'id_kehadiran';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id_siswa', 'kehadiran', 'level', 'tanggal',  'id_sanggar'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_kehadiran', $data)->first();
        }
    }
}
