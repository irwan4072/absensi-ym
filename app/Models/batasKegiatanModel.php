<?php

namespace App\Models;

use CodeIgniter\Model;

class BatasKegiatanModel extends Model
{
    protected $table = 'batas_kegiatan';
    protected $primaryKey = 'id_batas_kegiatan';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id_kegiatan', 'id_sanggar', 'batas'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_batas_kegiatan', $data)->first();
        }
    }
}
