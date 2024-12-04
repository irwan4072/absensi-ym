<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Absensi extends BaseController
{
    public function index()
    {

        $data = [
            'title' => 'YM | Home',

        ];
        return view('home', $data);
    }
}
