<?php

namespace App\Models;

use CodeIgniter\Model;

class KegiatanModel extends Model
{
    protected $table = 'kegiatan';
    protected $primaryKey = 'id_kegiatan';
    protected $useTimeStamps = true;
    protected $allowedFields = ['nama_kegiatan', 'syarat', 'tanggal', 'lokasi', 'jumlah_peserta', 'status'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_kegiatan', $data)->first();
        }
    }
}
