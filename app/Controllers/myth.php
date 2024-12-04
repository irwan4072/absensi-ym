<?php

namespace App\Controllers;

use App\Models\GuruModel;
use App\Models\StaffModel;
use App\Models\UserModel;

class Myth extends BaseController
{
    protected $guru;
    protected $staff;
    protected $user;
    protected $session;

    public function __construct()
    {
        $this->guru  = new GuruModel();
        $this->staff  = new StaffModel();
        $this->user  = new UserModel();
        $this->session = session();
    }
    public function index()
    {
        $session = session();

        if ($session->get('isLoggedIn')) {
            return redirect()->to('/home');
        }
        $data = [
            'title' => 'YM | Login',

        ];
        return view('/myth/login', $data);
    }
    public function login()
    {

        $validation = \Config\Services::validation();

        $validation->setRules(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username' => [
                    'required' => 'Username harus diisi.'
                ],
                'password' => [
                    'required' => 'Password harus diisi.'
                ],
            ]
        );
        // dd($validation->getErrors());

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }

        $session = $this->session;
        // helper(['cookie']);

        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        // $password = password_hash($password, PASSWORD_DEFAULT);
        // $this->user->update(2, ['password' => $password]);
        // $remember = $this->request->getVar('remember');

        $user = $this->user->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                if ($user['role'] == 'staff program') {
                    $staff = $this->staff->where('id_user', $user['id'])->first();
                    // dd($staff);
                    // Gabungkan data $staff dan $user
                    $pengguna = array_merge($staff, $user);
                } else {
                    $guru = $this->guru->where('id_user', $user['id'])->first();
                    // Gabungkan data $guru dan $user
                    $pengguna = array_merge($guru, $user);
                }
                $pengguna['isLoggedIn'] = true;
                $session->set($pengguna);
                // if ($remember) {
                //     set_cookie('remember', $username, 3600 * 24 * 7); // 7 hari
                // } else {
                //     delete_cookie('remember');
                // }
                return redirect()->to('/home');
            } else {
                $session->setFlashdata(['msg' => 'Username atau password salah.', 'warna' => 'danger']);
                return redirect()->back()->withInput();
            }
        } else {
            $session->setFlashdata(['msg' => 'Username atau password salah.', 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }


        // dd($user);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        helper(['cookie']);
        delete_cookie('remember');
        return redirect()->to('/login');
    }
}
