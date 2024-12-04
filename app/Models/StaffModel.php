<?php

namespace App\Models;

use CodeIgniter\Model;

class StaffModel extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id_staff';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id_staff', 'nama_staff', 'jenis_kelamin', 'alamat_staff', 'telp_staff', 'jabatan', 'id_user', 'daftar'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_staff', $data)->first();
        }
    }
}
