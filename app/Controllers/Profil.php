<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\RESTful\ResourceController;

class Profil extends BaseController
{
    protected $user;
    public function __construct()
    {
        $this->user = new UserModel();
    }
    public function index()
    {

        $user = session()->get();
        $data = [
            'title' => 'YM | Profil',
            'user' => $user,

        ];
        return view('profil/index', $data);
    }
    public function ubah_password()
    {
        helper(['form', 'url']);
        // dd(session()->get());
        $validation = \Config\Services::validation();

        // Definisikan aturan validasi
        $validation->setRules([
            'old_password' => 'required',
            'new_password' => 'required',
            // 'new_password' => [
            //     'required',
            //     'min_length[8]',
            //     'regex_match[/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W])/]',
            //     'differs[old_password]',
            // ],
            'confirm_password' => 'required|matches[new_password]',
        ], [
            'old_password' => [
                'required' => 'Password lama harus diisi.',
                // 'min_length' => 'Password lama harus terdiri dari minimal 6 karakter.'
            ],
            'new_password' => [
                'required' => 'Password baru harus diisi.',
                // 'min_length' => 'Password baru harus terdiri dari minimal 8 karakter.',
                // 'regex_match' => 'Password baru harus mengandung minimal satu huruf besar, satu huruf kecil, satu angka, dan satu karakter khusus.',
                // 'differs' => 'Password baru tidak boleh sama dengan password lama.',
            ],
            'confirm_password' => [
                'required' => 'Konfirmasi password baru harus diisi.',
                'matches' => 'Konfirmasi password baru tidak cocok dengan password baru.'
            ]
        ]);

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        } else {
            $userModel = $this->user;
            $session = session();


            $userId = $session->get('id'); // Sesuaikan dengan key user id di session Anda
            $user = $userModel->getData($userId);

            $oldPassword = $this->request->getPost('old_password');
            $newPassword = $this->request->getPost('new_password');
            // dd($userId);
            // Verifikasi password lama
            if (!password_verify($oldPassword, $user['password'])) {
                session()->setFlashdata(['msg' => 'Password lama tidak sesuai', 'warna' => 'danger']);
                return redirect()->back()->withInput();
            }

            // Cek apakah password baru mengandung username (opsional)
            if (strpos($newPassword, $user['username']) !== false) {
                session()->setFlashdata(['msg' => 'Password baru tidak boleh mengandung username.', 'warna' => 'danger']);
                return redirect()->back()->withInput();
            }

            // Update password
            $updateSuccess = $userModel->update($userId, [
                'password' => password_hash($newPassword, PASSWORD_DEFAULT)
            ]);

            if ($updateSuccess) {
                $session->setFlashdata(['msg' => 'Password berhasil diubah.', 'warna' => 'success']);
            } else {
                $session->setFlashdata(['msg' => 'Gagal mengubah password. Silakan coba lagi.', 'warna' => 'danger']);
            }
            return redirect()->to('profil')->with('success', 'Password berhasil diubah.');
        }
    }
}
