<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';
    protected $useTimeStamps = true;
    protected $allowedFields = ['nama_siswa', 'kelas', 'alamat_siswa', 'telp_siswa', 'status', 'jenis_kelamin', 'id_sanggar', 'id_level', 'id_kartu', 'created_at'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_siswa', $data)->first();
        }
    }
    public function getDataWithCard($card = false)
    {

        return $this->where('id_siswa', $card)->first();
    }
}
