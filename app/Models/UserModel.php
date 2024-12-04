<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    protected $useTimeStamps = true;
    protected $allowedFields = ['id',  'username', 'password', 'role'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id', $data)->first();
        }
    }
}
