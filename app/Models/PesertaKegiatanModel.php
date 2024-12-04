<?php

namespace App\Models;

use CodeIgniter\Model;

class PesertaKegiatanModel extends Model
{
    protected $table = 'peserta_kegiatan';
    protected $primaryKey = 'id_peserta';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id_kegiatan', 'id_siswa', 'id_sanggar', 'didaftarkan'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_peserta', $data)->first();
        }
    }
}
