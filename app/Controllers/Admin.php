<?php

namespace App\Controllers;

use App\Database\Migrations\Staff;
use App\Models\SiswaModel;
use App\Models\UserModel;
use App\Models\guruModel;
use App\Models\LevelModel;
use App\Models\KegiatanModel;
use App\Models\SanggarModel;
use App\Models\staffModel;
use CodeIgniter\I18n\Time;


class Admin extends BaseController
{
    protected $siswa;
    protected $user;
    protected $guru;
    protected $staff;
    protected $validation;
    protected $faker;
    protected $sanggar;
    protected $db;
    protected $level;
    protected $kegiatan;

    public function __construct()
    {
        if (session()->get('role') !== 'staff program') {

            redirect()->to('/home')->send();
            exit;
        }
        $this->siswa = new SiswaModel();
        $this->user = new UserModel();
        $this->guru = new GuruModel();
        $this->staff = new StaffModel();
        $this->level = new LevelModel();
        // $this->level = new LevelModel();
        $this->kegiatan = new KegiatanModel();
        $this->validation = \Config\Services::validation();
        $this->db      = \Config\Database::connect();
        $this->sanggar = new SanggarModel();
        helper(['form', 'url']);
    }
    public function index()
    {
        redirect()->to('/home')->send();
        exit;
        // session();
        // // $nama = $this->faker->username;
        // // dd($nama);
        // // $pass = 123;
        // // 
        // // dd($password);
        // $data = [
        //     'title' => 'YM  | Admin'

        // ];
        // return view('templates/home_template', $data);
    }
    public function staff($id = false)
    {
        if ($id != false) {
            $staff = $this->staff->join('user', 'user.id=staff.id_user')->where('id_staff', $id)->first();
        } else {
            $staff = $this->staff->getData();
        }
        // dd($staff);
        // dd($staff);
        $data = [
            'title' => 'YM  | Data Staff',
            'staff' => $staff,
            'validation' => $this->validation,

        ];

        if ($id != false) {
            return view('master/edit_staff', $data);
        } else {
            return view('master/staff', $data);
        }
    }
    public function guru($id = false)
    {
        if ($id != false) {
            // if (isset($id)) {
            //     $ciphertext_iv = urldecode($id);
            //     list($ciphertext, $iv) = explode('::', base64_decode($ciphertext_iv), 2);
            //     $cipher = "aes-256-cbc"; // Algoritma yang sama seperti saat enkripsi
            //     $key = "UNIPI2020804118"; // Kunci yang sama seperti saat enkripsi

            //     $original_id = openssl_decrypt($ciphertext, $cipher, $key, $options = 0, $iv);
            // } else {
            //     return redirect()->back()->withInput();
            // }

            $guru = $this->guru->join('user', 'user.id=guru.id_user')->where('guru.id_guru', $id)->first();
            // dd($guru);
        } else {
            $guru = $this->guru->getData();
        }
        // dd($guru);
        $data = [
            'title' => 'YM  | Data guru',
            'guru' => $guru,
            'validation' => $this->validation,
            'sanggar' => $this->sanggar->getData(),

        ];
        if ($id != false) {

            return view('master/edit_guru', $data);
        } else {

            return view('master/guru', $data);
        }
    }
    public function siswa($id = false)
    {

        if ($id != false) {
            $siswa = $this->siswa->join('level', 'siswa.id_level = level.id_level')->where('siswa.id_siswa', $id)->first();
        } else {
            $siswa = $this->siswa->join('level', 'siswa.id_level = level.id_level')->findAll();
        }
        $data = [
            'title' => 'YM  | Data Siswa',
            'siswa' => $siswa,
            'validation' => $this->validation,
            'sanggar' => $this->sanggar->getData(),

        ];

        if ($id != false) {
            return view('master/edit_siswa', $data);
        } else {
            return view('master/siswa', $data);
        }
        // dd($siswa);
    }

    public function level($id = false)
    {
        if ($id != false) {
            $level = $this->level->getData($id);
        } else {
            $level = $this->level->getData();
        }
        $data = [
            'title' => 'YM  | Data level',
            'level' => $level,
            'validation' => $this->validation,
            'sanggar' => $this->sanggar->getData(),

        ];
        if ($id != false) {
            return view('master/edit_level', $data);
        } else {
            return view('master/level', $data);
        }
    }

    public function sanggar($id = false)
    {
        if ($id != false) {
            $sanggar = $this->sanggar->getData($id);
        } else {
            $sanggar = $this->sanggar->getData();
        }
        $data = [
            'title' => 'YM  | Data Sanggar',
            'sanggar' => $sanggar,
            'validation' => $this->validation,
            'sanggar' => $sanggar,

        ];
        if ($id != false) {
            return view('master/edit_sanggar', $data);
        } else {
            return view('master/sanggar', $data);
        }
    }
    public function kegiatan($id = false)
    {
        if ($id != false) {
            $kegiatan = $this->kegiatan->getData($id);
        } else {
            $kegiatan = $this->kegiatan->getData();
        }
        // dd($kegiatan);
        $data = [
            'title' => 'YM  | Data Kegiatan',
            'kegiatan' => $kegiatan,
            'validation' => $this->validation,
            'sanggar' => $this->sanggar->getData(),

        ];
        if ($id != false) {
            // dd($kegiatan);
            return view('master/edit_kegiatan', $data);
        } else {
            return view('master/kegiatan', $data);
        }
    }
    public function toggle_status()
    {
        // $id = 2;
        $id = $this->request->getPost('id');
        // $id = $this->input->post('id');

        // Ambil status saat ini dari database
        // $this->load->model('Model_name');
        $kegiatan = $this->kegiatan->getData($id);
        $current_status = $kegiatan['status'];
        // dd($id);

        // Tentukan status baru
        $new_status = $current_status == 1 ? 0 : 1;

        // Update status di database

        $update = $this->kegiatan->update($id, ['status' => $new_status]);
        // dd($new_status);
        // $update = $this->kegiatan->update($id, $new_status);

        if ($update) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }



    // -------------------------------- tambah -------------------------------------------------
    public function simpan_staff()
    {
        // dd($this->request->getVar('jenis_kelamin'));
        session();
        $id_staff = $this->request->getVar('id_staff');
        $username = $this->request->getVar('username');
        // $id_user = 6;

        $username_rules = 'required|min_length[5]|max_length[50]';
        if (!is_null($id_staff)) {
            $user = $this->staff
                ->select('user.id as id, user.username')
                ->join('user', 'staff.id_user = user.id') // Gabungkan dengan tabel 'user'
                ->where('staff.id_staff', $id_staff)      // Pastikan kolom 'username' ada di tabel 'user'
                ->first();
            // $user = $this->user->where(['role' => 'staff program', 'username' => $username])->first();
            // dd($user['id']);
            // dd($user['id']);

            if ($user) {
                $username_rules .= '|is_unique[user.username,id,' . $user['id'] . ']';
            }
        } else {
            $username_rules .= '|is_unique[user.username]';
        }


        $validation = \Config\Services::validation();
        $rules = [
            'nama_staff' => [
                'label' => 'Nama Staff',
                'rules' => 'required|alpha_space|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama Staff wajib diisi.',
                    'alpha_space' => 'Nama Staff hanya boleh berisi huruf dan spasi.',
                    'min_length' => 'Nama Staff minimal 3 karakter.',
                    'max_length' => 'Nama Staff maksimal 100 karakter.'
                ]
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required|in_list[pria,wanita]',
                'errors' => [
                    'required' => 'Jenis Kelamin wajib diisi.',
                    'in_list' => 'Jenis Kelamin harus salah satu dari: pria atau wanita.'
                ]
            ],
            'alamat_staff' => [
                'label' => 'Alamat Staff',
                'rules' => 'required|string|min_length[5]|max_length[255]',
                'errors' => [
                    'required' => 'Alamat Staff wajib diisi.',
                    'string' => 'Alamat Staff harus berupa teks.',
                    'min_length' => 'Alamat Staff minimal 5 karakter.',
                    'max_length' => 'Alamat Staff maksimal 255 karakter.'
                ]
            ],
            'telepon' => [
                'label' => 'Telepon',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Telepon wajib diisi.',
                    'numeric' => 'Telepon hanya boleh berisi angka.',
                    'min_length' => 'Telepon minimal 10 karakter.',
                    'max_length' => 'Telepon maksimal 15 karakter.'
                ]
            ],
            'jabatan' => [
                'label' => 'Jabatan',
                'rules' => 'required|string|min_length[3]|max_length[50]',
                'errors' => [
                    'required' => 'Jabatan wajib diisi.',
                    'string' => 'Jabatan harus berupa teks.',
                    'min_length' => 'Jabatan minimal 3 karakter.',
                    'max_length' => 'Jabatan maksimal 50 karakter.'
                ]
            ],
            'username' => [
                'label' => 'Username',
                'rules' => $username_rules,
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 50 karakter.',
                    'is_unique' => 'Username sudah digunakan, pilih username yang lain.'
                ]
            ]
        ];

        // Jika $id_staff kosong (tambah data), tambahkan validasi password
        if (!isset($id_staff) || empty($id_staff)) {
            $rules['password'] = [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[50]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                    'max_length' => 'Password maksimal 50 karakter.'
                ]
            ];
        }

        $validation->setRules($rules);


        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }


        $nama_staff = $this->request->getVar('nama_staff');
        $id_staff = $this->request->getVar('id_staff');
        // $id_user = $this->request->getVar('id_user');
        $jenis_kelamin = $this->request->getVar('jenis_kelamin');
        $alamat_staff = $this->request->getVar('alamat_staff');
        $telp_staff = $this->request->getVar('telepon');
        $jabatan = $this->request->getVar('jabatan');
        $username = $this->request->getVar('username');
        $pass = $this->request->getVar('password');
        $password = password_hash($pass, PASSWORD_DEFAULT);
        // $query = "SELECT * FROM `level` WHERE id = 1";
        // $level = $db->query("SELECT * FROM `siswa` WHERE id = 1");
        // dd($telp_staff);
        if (!is_null($id_staff)) {
            session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            $this->staff->update($id_staff, [
                'id_staff' => $id_staff,
                'nama_staff' => $nama_staff,
                'jenis_kelamin' => $jenis_kelamin,
                'alamat_staff' => $alamat_staff,
                'telp_staff' => $telp_staff,
                'jabatan' => $jabatan,

            ]);
            $id_user = ($user['id']);

            $this->__user([
                'username' => $username,
                'password' => $password,
                'role' => 'staff program',
                'id' => $id_user,

            ]);
        } else {
            session()->setFlashdata(['msg' => 'Data Berhasil sitambahkan', 'warna' => 'success']);
            if ($id = $this->__user([
                'username' => $username,
                'password' => $password,
                'role' => 'staff program',

            ])) {
                // dd($id);
                $data = [
                    'nama_staff' => $nama_staff,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat_staff' => $alamat_staff,
                    'telp_staff' => $telp_staff,
                    'jabatan' => $jabatan,
                    'id_user' => $id,
                    'daftar' => Time::now(),

                ];
                $a = $this->staff->insert($data);
            }
        }

        // dd($data);
        return redirect()->to('/admin/staff');
    }
    public function simpan_guru()
    {
        $id_guru = $this->request->getVar('id_guru');
        $username = $this->request->getVar('username');

        $id_staff = $this->request->getVar('id_staff');
        $username = $this->request->getVar('username');



        $username_rules = 'required|min_length[5]|max_length[50]';
        if (!is_null($id_guru)) {
            $user = $this->guru
                ->select('user.id as id, user.username')
                ->join('user', 'guru.id_user = user.id') // Gabungkan dengan tabel 'user'
                ->where('guru.id_guru', $id_guru)      // Pastikan kolom 'username' ada di tabel 'user'
                ->first();
            // $user = $this->user->where(['id_user' => $id_user, 'username' => $username])->first();

            if (!$user) {
                $username_rules .= '|is_unique[user.username,id,' . $user['id'] . ']';
            }
        } else {
            $username_rules .= '|is_unique[user.username]';
        }
        $validation = \Config\Services::validation();
        $rules = [
            'nama_guru' => [
                'label' => 'Nama Guru',
                'rules' => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required' => 'Nama Guru wajib diisi.',
                    'min_length' => 'Nama Guru harus memiliki panjang minimal 3 karakter.',
                    'max_length' => 'Nama Guru tidak boleh lebih dari 100 karakter.',
                ],
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'rules' => 'required|in_list[pria,wanita]',
                'errors' => [
                    'required' => 'Jenis Kelamin wajib diisi.',
                    'in_list' => 'Jenis Kelamin harus Pria atau Wanita.',
                ],
            ],
            'alamat_guru' => [
                'label' => 'Alamat Guru',
                'rules' => 'required|max_length[255]',
                'errors' => [
                    'required' => 'Alamat Guru wajib diisi.',
                    'max_length' => 'Alamat Guru tidak boleh lebih dari 255 karakter.',
                ],
            ],
            'telepon' => [
                'label' => 'Telepon Guru',
                'rules' => 'required|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'required' => 'Telepon Guru wajib diisi.',
                    'numeric' => 'Telepon Guru harus berupa angka.',
                    'min_length' => 'Telepon Guru harus memiliki panjang minimal 10 karakter.',
                    'max_length' => 'Telepon Guru tidak boleh lebih dari 15 karakter.',
                ],
            ],
            'id_sanggar' => [
                'label' => 'ID Sanggar',
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'ID Sanggar wajib diisi.',
                    'numeric' => 'ID Sanggar harus berupa angka.',
                ],
            ],
            'pelajaran' => [
                'label' => 'Pelajaran',
                'rules' => 'required|max_length[100]',
                'errors' => [
                    'required' => 'Pelajaran wajib diisi.',
                    'max_length' => 'Pelajaran tidak boleh lebih dari 100 karakter.',
                ],
            ],
            'username' => [
                'label' => 'Username',
                'rules' => $username_rules,
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username harus memiliki panjang minimal 5 karakter.',
                    'max_length' => 'Username tidak boleh lebih dari 50 karakter.',
                    'is_unique' => 'Username sudah digunakan.',
                ],
            ],
            // 'password' => [
            //     'label' => 'Password',
            //     'rules' => 'required|min_length[8]',
            //     'errors' => [
            //         'required' => 'Password wajib diisi.',
            //         'min_length' => 'Password harus memiliki panjang minimal 8 karakter.',
            //     ],
            // ],
            // untuk password kuatt
            // 'password' => [
            //     'label' => 'Password',
            //     'rules' => 'required|min_length[8]|max_length[255]|regex_match[^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$]',
            //     'errors' => [
            //         'required' => 'Password wajib diisi.',
            //         'min_length' => 'Password harus memiliki panjang minimal 8 karakter.',
            //         'max_length' => 'Password tidak boleh lebih dari 255 karakter.',
            //         'regex_match' => 'Password harus mengandung setidaknya satu huruf besar, satu huruf kecil, satu angka, dan satu simbol khusus.',
            //     ],
            // ],

        ];
        if (!isset($id_guru) || empty($id_guru)) {
            $rules['password'] = [
                'label' => 'Password',
                'rules' => 'required|min_length[6]|max_length[50]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.',
                    'max_length' => 'Password maksimal 50 karakter.'
                ]
            ];
        }
        $validation->setRules($rules);

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }


        $nama_guru = $this->request->getVar('nama_guru');
        // dd($nama_guru);
        $id_guru = $this->request->getVar('id_guru');
        $jenis_kelamin = $this->request->getVar('jenis_kelamin');
        $alamat_guru = $this->request->getVar('alamat_guru');
        $telp_guru = $this->request->getVar('telepon');
        $id_sanggar = $this->request->getVar('id_sanggar');
        $pelajaran = $this->request->getVar('pelajaran');
        $username = $this->request->getVar('username');
        $pass = $this->request->getVar('password');
        $password = password_hash($pass, PASSWORD_DEFAULT);
        // $query = "SELECT * FROM `level` WHERE id = 1";
        // $level = $db->query("SELECT * FROM `siswa` WHERE id = 1");
        // dd($telp_guru);

        if (!is_null($id_guru)) {
            session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            $this->guru->update($id_guru, [
                'id_guru' => $id_guru,
                'nama_guru' => $nama_guru,
                'jenis_kelamin' => $jenis_kelamin,
                'alamat_guru' => $alamat_guru,
                'telp_guru' => $telp_guru,
                'id_sanggar' => $id_sanggar,
                'pelajaran' => $pelajaran,
                'username' => $username,
                'password' => $password,

            ]);
        } else {
            session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            if ($id = $this->__user([
                'username' => $username,
                'password' => $password,
                'role' => 'guru',

            ])) {

                $this->guru->save([
                    'id_guru' => $id_guru,
                    'nama_guru' => $nama_guru,
                    'jenis_kelamin' => $jenis_kelamin,
                    'alamat_guru' => $alamat_guru,
                    'telp_guru' => $telp_guru,
                    'id_sanggar' => $id_sanggar,
                    'pelajaran' => $pelajaran,
                    'id_user' => $id,
                    'daftar' => Time::now(),

                ]);
            }
        }

        return redirect()->to('/admin/guru');
    }
    public function simpan_siswa()
    {
        $db = db_connect();
        $id_siswa = $this->request->getVar('id_siswa');
        $id_kartu = $this->request->getVar('id_kartu');

        $id_kartu_rules = 'required|integer';
        if (!is_null($id_siswa)) {
            $siswa = $this->siswa->where(['id_siswa' => $id_siswa, 'id_kartu' => $id_kartu]);
            if (!$siswa) {
                $id_kartu_rules .= "|is_unique[siswa.id_kartu,id,$id_siswa]";
            }
        } else {
            $id_kartu_rules .= '|is_unique[siswa.id_kartu]';
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama_siswa' => [
                'label'  => 'Nama Siswa',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Nama siswa wajib diisi.',
                    'min_length' => 'Nama siswa harus memiliki minimal 3 karakter.',
                    'max_length' => 'Nama siswa tidak boleh lebih dari 100 karakter.',
                ],
            ],
            'kelas' => [
                'label'  => 'Kelas',
                'rules'  => 'required|min_length[1]|max_length[50]',
                'errors' => [
                    'required'   => 'Kelas wajib diisi.',
                    'min_length' => 'Kelas harus memiliki minimal 1 karakter.',
                    'max_length' => 'Kelas tidak boleh lebih dari 50 karakter.',
                ],
            ],
            'alamat_siswa' => [
                'label'  => 'Alamat Siswa',
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Alamat siswa wajib diisi.',
                    'min_length' => 'Alamat siswa harus memiliki minimal 5 karakter.',
                    'max_length' => 'Alamat siswa tidak boleh lebih dari 255 karakter.',
                ],
            ],
            'telepon' => [
                'label'  => 'Telepon Siswa',
                'rules'  => 'required|regex_match[/^[0-9]{10,15}$/]',
                'errors' => [
                    'required'       => 'Telepon siswa wajib diisi.',
                    'regex_match'    => 'Telepon siswa harus berupa angka dan panjang antara 10 hingga 15 digit.',
                ],
            ],
            'status' => [
                'label'  => 'Status',
                'rules'  => 'required|in_list[yatim,non yatim]',
                'errors' => [
                    'required'   => 'Status wajib diisi.',
                    'in_list'    => 'Status harus salah satu dari: Yatin, Non Yatim.',
                ],
            ],
            'jenis_kelamin' => [
                'label'  => 'Jenis Kelamin',
                'rules'  => 'required|in_list[laki-laki,perempuan]',
                'errors' => [
                    'required'   => 'Jenis kelamin wajib diisi.',
                    'in_list'    => 'Jenis kelamin harus salah satu dari: laki-laki, perempuan.',
                ],
            ],
            'id_sanggar' => [
                'label'  => 'Sanggar',
                'rules'  => 'required|integer',
                'errors' => [
                    'required' => 'Sanggar wajib diisi.',
                    'integer'  => 'Sanggar harus dipilih.',
                ],
            ],
            'level' => [
                'label'  => 'level',
                'rules'  => 'required|is_not_unique[level.level]',
                'errors' => [
                    'required' => 'level wajib diisi.',
                    'is_not_unique'  => 'Level tidak terdaftar.',
                ],
            ],
            'id_kartu' => [
                'label'  => 'Kartu',
                'rules'  => $id_kartu_rules,
                'errors' => [
                    'required' => 'Kartu wajib diisi.',
                    'integer'  => 'Kartu harus berupa angka.',
                    'is_unique'  => 'Nomor kartu sudah terdaftar.',
                ],
            ],
        ]);
        $id_siswa = $this->request->getVar('id_siswa');

        if (!is_null($id_siswa)) {
            $id_kartu_rules = 'required|integer|is_unique[siswa.id_kartu]';
            $id_kartu_rules .= ',id_kartu,' . $id_siswa;
        }

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }
        $id_siswa = $this->request->getVar('id_siswa');
        $nama_siswa = $this->request->getVar('nama_siswa');
        $kelas = $this->request->getVar('kelas');
        $alamat_siswa = $this->request->getVar('alamat_siswa');
        $telp_siswa = $this->request->getVar('telepon');
        $status = $this->request->getVar('status');
        $jenis_kelamin = $this->request->getVar('jenis_kelamin');
        $level = $this->request->getVar('level');
        $id_sanggar = $this->request->getVar('id_sanggar');
        // $id_kartu = $this->request->getVar('id_kartu');

        $level = $this->level->where('level', $level)->first();
        $id_level = $level['id_level'];
        // $sql = "INSERT INTO `siswa`(`id_siswa`, `nama_siswa`, `kelas`, `alamat_siswa`, `telp_siswa`, `jenis_kelamin`, `status`, `id_level`, `id_sanggar`, `id_kartu`, `created_at`) VALUES
        // ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','$id_level','[value-9]','[value-10]','[value-11]')";
        // dd($id_level);
        if (!is_null($id_siswa)) {
            // d('Pre-update');
            $sql = "UPDATE `siswa` 
                        SET 
                            `nama_siswa` = '$nama_siswa',
                            `kelas` = '$kelas',
                            `alamat_siswa` = '$alamat_siswa',
                            `telp_siswa` = '$telp_siswa',
                            `status` = '$status',
                            `jenis_kelamin` = '$jenis_kelamin',
                            `id_level` = '$id_level',
                            `id_sanggar` = '$id_sanggar',
                            `id_kartu` = '$id_kartu'
                        WHERE 
                            `id_siswa` = '$id_siswa'
                        ";
            $ab = $db->query($sql);

            // dd($sql);
            //     $this->siswa->update($id_siswa, [
            //         'nama_siswa' => $nama_siswa,
            //         'kelas' => $kelas,
            //         'alamat_siswa' => $alamat_siswa,
            //         'telp_siswa' => $telp_siswa,
            //         'status' => $status,
            //         'jenis_kelamin' => $jenis_kelamin,
            //         'id_level' => $id_level,
            //         'id_sanggar' => $id_sanggar,
            //         'id_kartu' => $id_kartu,

            //     ]);
            if ($ab) {
                session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            }
            // dd($this->db->getLastQuery());
        } else {
            // $ab = session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            $ab = $this->siswa->save([
                'nama_siswa' => $nama_siswa,
                'kelas' => $kelas,
                'alamat_siswa' => $alamat_siswa,
                'telp_siswa' => $telp_siswa,
                'jenis_kelamin' => $jenis_kelamin,
                'status' => $status,
                'id_level' => $id_level,
                'id_sanggar' => $id_sanggar,
                'id_kartu' => $id_kartu,
                'created_at' => Time::now(),

            ]);
            if ($ab) {
                session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            }
        }


        return redirect()->to('/admin/siswa');
    }
    public function simpan_level()
    {
        $db = db_connect();
        $jilid = $this->request->getPost('jilid');
        $level = $this->request->getPost('level');
        $id_level = $this->request->getVar('id_level');
        $materi = $this->request->getVar('materi');
        $tema = $this->request->getVar('tema');

        // Gabungkan jilid dan level
        $combinedLevel = $jilid . $level;  // Hasilnya: 'a8'

        // dd($combinedLevel);

        $inputMengurut = $this->level->coba($this->request->getVar());






        // // Buat data gabungan untuk validasi
        // $data = [
        //     'jilid' => $jilid,
        //     'materi' => $materi,
        //     'level' => $combinedLevel,
        //     'tema' => $tema,
        // ];

        // $levelValidasi = 'required|max_length[3]';
        // if (!is_null($id_level)) {
        //     $levelNew = $this->level
        //         ->select('*')
        //         ->where('level', $combinedLevel)
        //         ->first();

        //     if ($levelNew) {
        //         $levelValidasi .= '|is_unique[level.level,id_level,' . $id_level . ']';
        //     }
        // } else {
        //     $levelValidasi .= '|is_unique[level.level]';
        // }
        // // dd($levelValidasi);

        // $validation = \Config\Services::validation();
        // $validation->setRules([
        //     'jilid' => [
        //         'label' => 'Jilid',
        //         'rules' => 'required|max_length[1]',
        //         'errors' => [
        //             'required' => 'Jilid wajib diisi.',
        //             'max_length' => 'Jilid tidak boleh lebih dari 1 karakter.',
        //             'integer'  => 'Kartu harus berupa angka.',
        //         ],
        //     ],
        //     'materi' => [
        //         'label' => 'Materi',
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'Materi wajib diisi.',
        //         ],
        //     ],
        //     'level' => [
        //         'label' => 'level',
        //         'rules' => $levelValidasi,
        //         'errors' => [
        //             'required' => 'Level wajib diisi.',
        //             'max_length' => 'Level tidak boleh lebih dari 3 karakter.',
        //             'is_unique' => "level $combinedLevel sudah tersedia",
        //         ],
        //     ],
        //     'tema' => [
        //         'label' => 'tema',
        //         'rules' => 'required',
        //         'errors' => [
        //             'required' => 'tema wajib diisi.',
        //         ],
        //     ],

        // ]);

        // if (!$validation->run($data)) {
        //     session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
        //     return redirect()->back()->withInput();
        // }


        if (!is_null($id_level)) {
            $ab = $this->level->update($id_level, [
                'jilid' => $jilid,
                'materi' => $materi,
                'level' => $combinedLevel,
                'tema' => $tema,
            ]);
            if ($ab) {
                session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            }
        } else {
            $ab =  $this->level->save([
                'jilid' => $jilid,
                'materi' => $materi,
                'level' => $level,
                'tema' => $tema,

            ]);
            if ($ab) {
                session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            }
        }

        return redirect()->to('/admin/level');
    }


    public function simpan_sanggar()
    {

        $validation = \Config\Services::validation();
        $validation->setRules([
            'sanggar' => [
                'label'  => 'Sanggar',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => 'Sanggar wajib diisi.',
                    'min_length' => 'Sanggar harus memiliki minimal 3 karakter.',
                    'max_length' => 'Sanggar tidak boleh lebih dari 100 karakter.',
                ],
            ],
            'alamat_sanggar' => [
                'label'  => 'Alamat Siswa',
                'rules'  => 'required|min_length[5]|max_length[255]',
                'errors' => [
                    'required'   => 'Alamat sanggar wajib diisi.',
                    'min_length' => 'Alamat sanggar harus memiliki minimal 5 karakter.',
                    'max_length' => 'Alamat sanggar tidak boleh lebih dari 255 karakter.',
                ],
            ],
        ]);

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }
        $id_sanggar = $this->request->getVar('id_sanggar');
        $sanggar = $this->request->getVar('sanggar');
        $alamat_sanggar = $this->request->getVar('alamat_sanggar');
        // dd($levelExists);
        if (!is_null($id_sanggar)) {
            session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            $this->sanggar->update($id_sanggar, [
                'sanggar' => $sanggar,
                'alamat_sanggar' => $alamat_sanggar,

            ]);
        } else {
            session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            $this->sanggar->save([
                'sanggar' => $sanggar,
                'alamat_sanggar' => $alamat_sanggar,

            ]);
        }

        return redirect()->to('/admin/sanggar');
    }

    public function simpan_kegiatan()
    {
        $db = db_connect();
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_kegiatan' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Nama kegiatan harus diisi.',
                    'min_length' => 'Nama kegiatan minimal harus 3 karakter.',
                    'max_length' => 'Nama kegiatan maksimal 255 karakter.'
                ]
            ],
            'syarat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Syarat harus diisi.'
                ]
            ],
            'tanggal' => [
                'label' => 'Tanggal Kegiatan',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Tanggal harus diisi.',
                    'valid_date' => 'Tanggal tidak valid.',
                ]
            ],
            'lokasi' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Lokasi harus diisi.',
                    'min_length' => 'Lokasi minimal harus 3 karakter.',
                    'max_length' => 'Lokasi maksimal 255 karakter.'
                ]
            ],
            'jumlah_peserta' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Lokasi harus diisi.',
                    'integer' => 'jumlah peserta harus angka.',
                ]
            ],
            // 'status' => [
            //     'rules' => 'required|in_list[aktif,nonaktif]',
            //     'errors' => [
            //         'required' => 'Status harus diisi.',
            //         'in_list' => 'Status harus salah satu dari: aktif, nonaktif.'
            //     ]
            // ]
        ]);
        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }
        $tanggal = $this->request->getVar('tanggal');
        $currentDate = date('Y-m-d');

        // Logika tambahan untuk memeriksa apakah tanggal kegiatan lebih besar dari hari ini
        if ($tanggal <= $currentDate) {
            // Tambahkan error jika tanggal tidak valid
            $errors = ['tanggal' => 'Tanggal kegiatan harus lebih besar dari hari ini.'];
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $id_kegiatan = $this->request->getVar('id_kegiatan');
        $nama_kegiatan = $this->request->getVar('nama_kegiatan');
        $syarat = $this->request->getVar('syarat');
        $lokasi = $this->request->getVar('lokasi');
        $jumlah_peserta = $this->request->getVar('jumlah_peserta');

        if (!is_null($id_kegiatan)) {
            session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            $this->kegiatan->update($id_kegiatan, [
                'nama_kegiatan' => $nama_kegiatan,
                'syarat' => $syarat,
                'tanggal' => $tanggal,
                'lokasi' => $lokasi,
                'jumlah_peserta' => $jumlah_peserta,

            ]);
        } else {
            session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            $this->kegiatan->save([

                'nama_kegiatan' => $nama_kegiatan,
                'syarat' => $syarat,
                'tanggal' => $tanggal,
                'lokasi' => $lokasi,
                'jumlah_peserta' => $jumlah_peserta,

            ]);
        }
        // Mengambil ID kegiatan yang baru disimpan
        $id_kegiatan_baru = $this->kegiatan->insertID();

        // Langkah 1: Hitung batas per sanggar dan sisa
        $total_batas = (int) $jumlah_peserta;
        $total_sanggar = $db->table('sanggar')->countAllResults();
        $batas_per_sanggar = floor($total_batas / $total_sanggar);
        $sisa = $total_batas % $total_sanggar;

        // Langkah 2: Hitung persentase kehadiran untuk setiap sanggar
        $kehadiranQuery = $db->query("
    SELECT 
        k.id_sanggar,
        (SUM(CASE WHEN k.kehadiran = 'hadir' THEN 1 ELSE 0 END) / COUNT(*)) * 100 AS persentase_kehadiran
    FROM 
        kehadiran k
    GROUP BY 
        k.id_sanggar
");

        // Simpan hasil persentase kehadiran ke dalam array
        $persentase_kehadiran = [];
        foreach ($kehadiranQuery->getResult() as $row) {
            $persentase_kehadiran[$row->id_sanggar] = $row->persentase_kehadiran;
        }

        // Ambil semua sanggar dan hitung batas awal
        $sanggarQuery = $db->table('sanggar')
            ->select('sanggar.*, COUNT(siswa.id_siswa) as jumlah_siswa')
            ->join('siswa', 'sanggar.id_sanggar = siswa.id_sanggar', 'left')
            ->groupBy('sanggar.id_sanggar')
            ->get();

        // dd($sanggarQuery->getResultArray('jumlah_siswa'));
        $batas_sanggar = [];
        foreach ($sanggarQuery->getResult() as $sanggar) {
            $batas = $batas_per_sanggar; // batas awal untuk setiap sanggar

            // Jika jumlah siswa saat ini kurang dari batas awal, tambahkan selisihnya ke variabel $sisa
            if ($sanggar->jumlah_siswa < $batas_per_sanggar) {
                $sisa += ($batas_per_sanggar - $sanggar->jumlah_siswa);
                $batas = $sanggar->jumlah_siswa; // batas menjadi jumlah siswa saat ini
            }

            $batas_sanggar[] = [
                'id_sanggar' => $sanggar->id_sanggar,
                'sanggar' => $sanggar->sanggar,
                'alamat_sanggar' => $sanggar->alamat_sanggar,
                'batas' => $batas,
                'jumlah_siswa' => $sanggar->jumlah_siswa,
                'persentase_kehadiran' => isset($persentase_kehadiran[$sanggar->id_sanggar]) ? $persentase_kehadiran[$sanggar->id_sanggar] : 0
            ];
        }

        unset($sanggar);

        // Urutkan berdasarkan persentase kehadiran tertinggi
        usort($batas_sanggar, function ($a, $b) {
            return $b['persentase_kehadiran'] <=> $a['persentase_kehadiran'];
        });

        // Bagikan sisa ke sanggar dengan persentase kehadiran tertinggi
        foreach ($batas_sanggar as &$sanggar) {
            while ($sisa > 0 && $sanggar['batas'] < $sanggar['jumlah_siswa']) {
                echo $sanggar['id_sanggar'] . '<br>';
                $sanggar['batas'] += 1;
                $sisa -= 1;
            }
        }
        // dd($batas_sanggar);
        unset($sanggar);

        // Update atau insert ke database
        if (!is_null($id_kegiatan)) {
            foreach ($batas_sanggar as $sanggar) {
                $db->table('batas_kegiatan')->where(['id_kegiatan' => $id_kegiatan, 'id_sanggar' => $sanggar['id_sanggar']])->update([
                    'id_kegiatan' => $id_kegiatan,
                    'id_sanggar' => $sanggar['id_sanggar'],
                    'batas' => $sanggar['batas']
                ]);
            }
        } else {
            foreach ($batas_sanggar as $sanggar) {
                $db->table('batas_kegiatan')->insert([
                    'id_kegiatan' => $id_kegiatan_baru,
                    'id_sanggar' => $sanggar['id_sanggar'],
                    'batas' => $sanggar['batas']
                ]);
            }
        }


        return redirect()->to('/admin/kegiatan');
    }
    public function __user($data)
    {

        $username = $data['username'];
        $password = $data['password'];
        $role = $data['role'];
        // dd($data);


        if (isset($data['id'])) {
            $id = $data['id'];
            $this->user->update($id, [
                'username' => $username,
                'password' => $password,

            ]);
        } else {
            $data = [
                'username' => $username,
                'password' => $password,
                'role' => $role,

            ];
            $insert = $this->user->save($data);
            // dd($insert);
            if ($insert) {
                $id = $this->user->getInsertID();
            } else {
                return false;
            }
        }

        // dd($data);
        return $id;
    }

    // ------------------------------ hapus -------------------------------------------------
    public function __hapus_user($id)
    {

        $hapus = $this->staff->delete($id);
        if ($hapus) {
            return true;
        } else {
            return false;
        }
    }
    public function hapus_staff($id)
    {
        $user = $this->staff->getData($id);
        if (count($user) > 0) {
            if ($this->__hapus_user($user['id_user'])) {
                $hapus = $this->staff->delete($id);
                if ($hapus) {
                    session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
                } else {
                    session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
                }
            } else {
                session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
            }
        }
        // dd($staff());
        return redirect()->to('/admin/staff');
    }
    public function hapus_guru($id)
    {
        $user = $this->guru->getData($id);
        if ($user) {
            if ($this->__hapus_user($user['id_user'])) {
                $hapus = $this->guru->delete($id);
                if ($hapus) {
                    session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
                } else {
                    session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
                }
            } else {
                session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
            }
        }
        // dd($guru);
        return redirect()->to('/admin/guru');
    }
    public function hapus_siswa($id)
    {
        $hapus = $this->siswa->delete($id);
        if ($hapus) {
            session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
        } else {
            session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
        }
        // dd($siswa);
        return redirect()->to('/admin/siswa');
    }
    public function hapus_sanggar($id)
    {
        $hapus = $this->sanggar->delete($id);
        if ($hapus) {
            session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
        } else {
            session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
        }
        // dd($sanggar);
        return redirect()->to('/admin/sanggar');
    }
    public function hapus_level($id)
    {
        $hapus = $this->level->delete($id);
        if ($hapus) {
            session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
        } else {
            session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
        }
        // dd($siswa);
        return redirect()->to('/admin/level');
    }
    public function hapus_kegiatan($id)
    {
        $hapus = $this->kegiatan->delete($id);
        if ($hapus) {
            session()->setFlashdata(['msg' => 'Data Berhasil dihapus', 'warna' => 'success']);
        } else {
            session()->setFlashdata(['msg' => 'Data gagal dihapus', 'warna' => 'danger']);
        }
        // dd($siswa);
        return redirect()->to('/admin/kegiatan');
    }

    public function user()
    {
        $user = $this->user->getData();
        // dd($user);
        $data = [
            'title' => 'YM  | Master user',
            'user' => $user,

        ];
        return view('master/user', $data);
    }
}
