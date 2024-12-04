<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    protected $table = 'guru';
    protected $primaryKey = 'id_guru';
    protected $useTimeStamps = true;
    protected $allowedFields = ['nama_guru', 'jenis_kelamin', 'alamat_guru', 'telp_guru', 'id_sanggar', 'pelajaran', 'id_user', 'daftar'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_guru', $data)->first();
        }
    }
}
