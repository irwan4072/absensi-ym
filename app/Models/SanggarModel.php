<?php

namespace App\Models;

use CodeIgniter\Model;

class SanggarModel extends Model
{
    protected $table = 'sanggar';
    protected $primaryKey = 'id_sanggar';
    protected $useTimeStamps = true;
    protected $allowedFields = ['sanggar', 'alamat_sanggar'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_sanggar', $data)->first();
        }
    }
}
