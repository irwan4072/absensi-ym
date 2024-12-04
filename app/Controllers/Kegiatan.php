<?php

namespace App\Controllers;

use App\Models\KegiatanModel;
use App\Models\PesertaKegiatanModel;
use App\Models\SiswaModel;
use CodeIgniter\I18n\Time;

class Kegiatan extends BaseController
{
    protected $kegiatan;
    protected $pesertaKegiatan;
    protected $db;
    protected $siswa;

    function __construct()
    {
        $this->kegiatan = new KegiatanModel();
        $this->pesertaKegiatan = new PesertaKegiatanModel();
        $this->db      = \Config\Database::connect();
        $this->siswa = new SiswaModel();
    }
    public function index()
    {
        session();
        // dd(session()->get());
        if (isset($_SESSION['id_kegiatan'])) {
            // dd($_SESSION['id']);
            $kegiatanAktif = $_SESSION['id_kegiatan'];
        } else {
            $kegiatanAktif = NULL;
        }
        $kegiatan = $this->db->query("SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal
                    FROM kegiatan k
                    WHERE k.tanggal >= CURDATE() && k.status = 1
                    ORDER BY k.tanggal ASC")->getResultArray();
        // $kegiatan = $this->db->query("SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal FROM kegiatan k
        // WHERE k.tanggal >= CURDATE() ORDER BY k.tanggal ASC")->getResultArray();
        // $pesertaKegiatan = $this->pesertaKegiatan->getData();

        // dd($kegiatan);

        // dd(session()->get());
        $id_sanggar = session()->get('id_sanggar');
        // $id_sanggar = ;
        $db = $this->db;
        // $siswa = $this->siswa->getWhere(['id_sanggar' => 1])->getResultArray();


        // $sql = "SELECT siswa.*, level.*, COUNT(kehadiran.id_kehadiran) AS jumlah_kehadiran
        //         FROM kehadiran
        //         JOIN siswa ON kehadiran.id_siswa = siswa.id_siswa
        //         JOIN level ON siswa.id_level = level.id_level
        //         WHERE siswa.id_sanggar = 1
        //         AND kehadiran.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        //         AND kehadiran.kehadiran = 'hadir'
        //         GROUP BY siswa.id_siswa
        //         ORDER BY jumlah_kehadiran DESC";
        // $sql = "SELECT siswa.*, COUNT(kehadiran.id_kehadiran) AS jumlah_kehadiran
        // FROM kehadiran JOIN siswa ON kehadiran.id_siswa = siswa.id_siswa 
        // JOIN 
        // WHERE siswa.id_sanggar = $id_sanggar AND kehadiran.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        // AND kehadiran.kehadiran = 'hadir' 
        // GROUP BY siswa.id_siswa ORDER BY jumlah_kehadiran DESC LIMIT 5";
        // $sql = "SELECT siswa.*, level.*, kegiatan_terdekat.nama_kegiatan, kegiatan_terdekat.tanggal, COUNT(kehadiran.id_kehadiran) AS jumlah_kehadiran
        // FROM kehadiran JOIN siswa ON kehadiran.id_siswa = siswa.id_siswa JOIN level ON siswa.id_level = level.id_level
        // JOIN ( SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal FROM kegiatan k WHERE k.tanggal >= CURDATE() ORDER BY k.tanggal ASC LIMIT 1 ) AS kegiatan_terdekat
        //  ON 1 = 1 WHERE siswa.id_sanggar = 1 AND kehadiran.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH) AND kehadiran.kehadiran = 'hadir' 
        //  GROUP BY siswa.id_siswa, siswa.nama_siswa, siswa.id_level, siswa.id_sanggar, level.id_level, level.level, kegiatan_terdekat.id_kegiatan, kegiatan_terdekat.nama_kegiatan, kegiatan_terdekat.tanggal ORDER BY jumlah_kehadiran DESC";

        // $sql = "SELECT siswa.*, level.*, kegiatan_terdekat.nama_kegiatan, kegiatan_terdekat.tanggal,
        // COUNT(kehadiran.id_kehadiran) AS jumlah_kehadiran FROM kehadiran
        // JOIN siswa ON kehadiran.id_siswa = siswa.id_siswa
        // JOIN level ON siswa.id_level = level.id_level
        // JOIN ( SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal FROM kegiatan k
        // WHERE k.tanggal >= CURDATE() ORDER BY k.tanggal ASC LIMIT 1 ) AS kegiatan_terdekat
        // ON 1 = 1 WHERE siswa.id_sanggar = 1 AND kehadiran.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        // AND kehadiran.kehadiran = 'hadir' GROUP BY siswa.id_siswa, level.id_level,kegiatan_terdekat.id_kegiatan
        // ORDER BY jumlah_kehadiran DESC";
        if ($kegiatanAktif != NULL) {
            $id_kegiatan = $kegiatanAktif;
        } else {
            if (!empty($kegiatan)) {
                $id_kegiatan = $kegiatan[0]['id_kegiatan'];
            } else {
                $id_kegiatan = null;
            }
        }
        // $id_kegiatan = 8;
        // $id_sanggar = 8;

        // dd($id_kegiatan);

        $sql = "SELECT siswa.*, level.*, kegiatan_terdekat.nama_kegiatan, kegiatan_terdekat.tanggal,
        COUNT(kehadiran.id_kehadiran) AS jumlah_kehadiran FROM kehadiran
        JOIN siswa ON kehadiran.id_siswa = siswa.id_siswa
        JOIN level ON siswa.id_level = level.id_level
        JOIN ( SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal FROM kegiatan k
        WHERE k.id_kegiatan = $id_kegiatan ) AS kegiatan_terdekat
        ON 1 = 1 WHERE siswa.id_sanggar = $id_sanggar AND kehadiran.tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
        AND kehadiran.kehadiran = 'hadir' GROUP BY siswa.id_siswa, level.id_level,kegiatan_terdekat.id_kegiatan
        ORDER BY jumlah_kehadiran DESC";
        // dd($sql);
        $siswa = $db->query($sql)->getResultArray();
        // dd($siswa);
        $batasPeserta =  [];
        $jumlahPesertaTerdaftar = [];
        foreach ($kegiatan as $k) {
            // $query = "SELECT pk.*, COUNT(pk.*) FROM peserta_kegiatan pk WHERE id_kegiatan = " . $k['id_kegiatan'] . " AND id_sanggar = $id_sanggar";

            $batasPeserta[] = $db->table('batas_kegiatan')->where(['id_kegiatan' => $k['id_kegiatan'], 'id_sanggar' => $id_sanggar])->get()->getResultArray();
            $jumlahPesertaTerdaftar[] = $db->query("SELECT pk.*, (SELECT COUNT(*) FROM peserta_kegiatan WHERE id_kegiatan = " . $k['id_kegiatan'] . " AND id_sanggar = $id_sanggar) AS jumlah_peserta
                    FROM peserta_kegiatan pk
                    WHERE pk.id_kegiatan = " . $k['id_kegiatan'] . "  AND pk.id_sanggar = $id_sanggar;
                    ")->getResultArray();
        }
        // dd($query);
        // dd($jumlahPesertaTerdaftar);


        // $siswa = $db->table('siswa')->getWhere(['id_sanggar' => 1])->getResultArray();
        // $peserta = $db->table('siswa')->select('*')->join('peserta_kegiatan', 'siswa.id_siswa = peserta_kegiatan.id_siswa')->join('sanggar', 'siswa.id_sanggar = sanggar.id_sanggar')->where(["peserta_kegiatan.id_kegiatan = '$id_kegiatan'"])->get()->getResultArray();
        $peserta = $db->query("SELECT siswa.*, peserta_kegiatan.*, sanggar.*, kegiatan.id_kegiatan, kegiatan.nama_kegiatan, kegiatan.tanggal
                FROM siswa
                JOIN peserta_kegiatan ON siswa.id_siswa = peserta_kegiatan.id_siswa
                JOIN sanggar ON siswa.id_sanggar = sanggar.id_sanggar
                JOIN kegiatan ON peserta_kegiatan.id_kegiatan = kegiatan.id_kegiatan
                WHERE kegiatan.id_kegiatan = '$id_kegiatan'")->getResultArray();
        // dd($peserta);
        // $peserta = $db->query("SELECT siswa.*, peserta_kegiatan.*, sanggar.*, kegiatan.id_kegiatan, kegiatan.nama_kegiatan, kegiatan.tanggal
        //     FROM siswa
        //     JOIN peserta_kegiatan ON siswa.id_siswa = peserta_kegiatan.id_siswa
        //     JOIN sanggar ON siswa.id_sanggar = sanggar.id_sanggar
        //     JOIN (
        //         SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal
        //         FROM kegiatan k
        //         WHERE k.id_kegiatan = '$id_kegiatan'
        //     ) AS kegiatan ON peserta_kegiatan.id_kegiatan = kegiatan.id_kegiatan")->getResultArray();
        // $peserta = $db->query("SELECT siswa.*, peserta_kegiatan.*, sanggar.*, kegiatan.id_kegiatan, kegiatan.nama_kegiatan, kegiatan.tanggal
        //     FROM siswa
        //     JOIN peserta_kegiatan ON siswa.id_siswa = peserta_kegiatan.id_siswa
        //     JOIN sanggar ON siswa.id_sanggar = sanggar.id_sanggar
        //     JOIN (
        //         SELECT k.id_kegiatan, k.nama_kegiatan, k.tanggal
        //         FROM kegiatan k
        //         WHERE k.tanggal >= CURDATE()
        //         ORDER BY k.tanggal ASC
        //         LIMIT 1
        //     ) AS kegiatan ON peserta_kegiatan.id_kegiatan = kegiatan.id_kegiatan")->getResultArray();
        // dd($siswa);
        // $siswa = $db->table('kegiatan')->getWhere(['id_siswa' => 1]);
        $data = [
            'title' => 'YM | Kegiatan',
            'siswa' => $siswa,
            'peserta' => $peserta,
            'kegiatan' => $kegiatan,
            'kegiatanAktif' => $kegiatanAktif,
            'id_kegiatan' => $id_kegiatan,

        ];
        return view('/kegiatan/index', $data);
    }
    // public function index()
    // {
    //     $pesertaKegiatan = $this->pesertaKegiatan->getData();
    //     $kegiatan = $this->kegiatan->getData();
    //     $db = $this->db;
    //     $siswa = $db->table('siswa')->join('peserta_kegiatan', 'siswa.id_siswa = peserta_kegiatan.id_siswa')->get()->getResultArray();
    //     // $siswa = $db->table('kegiatan')->getWhere(['id_siswa' => 1]);

    //     dd($siswa);




    //     $data = [
    //         'title' => 'YM | Kegiatan',
    //         'peserta' => $siswa,
    //         'kegiatan' => $kegiatan

    //     ];
    //     return view('/kegiatan/index', $data);
    // }
    public function simpan_pesertaKegiatan()
    {
        session();
        $db = db_connect();

        $idPesertaNew = $this->request->getVar('id_siswa');
        $id_kegiatanModal = $this->request->getVar('id_kegiatanModal');
        $jumlahPeserta = $db->table('peserta_kegiatan')->where('id_sanggar', session()->get('id_sanggar'))->countAllResults();
        $batasPeserta = $db->table('batas_kegiatan')->select('batas')->Where(['id_kegiatan' => 1, 'id_sanggar' => session()->get('id_sanggar')])->get()->getResultArray();
        if ($batasPeserta) {
            $batasPeserta = $batasPeserta[0]['batas'];
        }
        if ($jumlahPeserta >= $batasPeserta) {
            return redirect()->back()->with('error', 'Jumlah peserta sudah melebihi batas.');
        }
        $data = [];
        foreach ($idPesertaNew as $idPeserta) {

            $siswa = $this->siswa->getData($idPeserta);
            // $siswa = $this->siswa->getWhere(['id_kartu' => '11522919315'])->getResultArray();
            // dd($siswa[0]['nama_siswa']);
            $id = $idPeserta;
            $idSanggar = $siswa['id_sanggar'];


            $dataNew = [
                'id_siswa' => $id,
                'id_sanggar' => $idSanggar,
                'id_kegiatan' => $id_kegiatanModal,

            ];
            $data[] = $dataNew;
        }
        // dd($data);

        $this->pesertaKegiatan->insertBatch($data);

        return redirect()->to('/kegiatan');
    }

    public function modalKegiatan()
    {
        dd($_POST);
    }
    public function pengalihanSementara($data)
    {
        // dd($data);
        $_SESSION['id'] = $data;
        return redirect()->to('/kegiatan');
    }
    public function kegiatan()
    {
        $session = session();
        // dd($_SESSION);
        $data = [
            'title' => 'YM | Kegiatan',

        ];
        return view('home', $data);
    }
    public function buat_laporan()
    {
        $session = session();
        // dd($_SESSION);
        $data = [
            'title' => 'YM | Laporan Kegiatan',

        ];
        return view('kegiatan/laporan', $data);
    }
    public function laporan()
    {
        $session = session();
        $db = db_connect();
        if (session('role') == 'guru') {
            $laporan_kegiatan = $db->table('laporan_kegiatan')->join('kegiatan', 'laporan_kegiatan.id_kegiatan = kegiatan.id_kegiatan')
                ->join('guru', 'laporan_kegiatan.id_guru = guru.id_guru')
                ->join('sanggar', 'laporan_kegiatan.id_sanggar = sanggar.id_sanggar')
                ->where('guru.id_guru', session('id_guru'))
                ->get()->getResultArray();
        } else {
            $laporan_kegiatan = $db->table('laporan_kegiatan')->join('kegiatan', 'laporan_kegiatan.id_kegiatan = kegiatan.id_kegiatan')
                ->join('guru', 'laporan_kegiatan.id_guru = guru.id_guru')
                ->join('sanggar', 'laporan_kegiatan.id_sanggar = sanggar.id_sanggar')
                ->get()->getResultArray();
        }
        $kegiatan = $db->table('kegiatan')->get()->getResultArray();
        // dd($kegiatan);
        $data = [
            'title' => 'YM | Laporan Kegiatan',
            'laporan_kegiatan' => $laporan_kegiatan,
            'kegiatan' => $kegiatan

        ];
        return view('kegiatan/laporan', $data);
    }




    public function updateStatusKegiatan()
    {
        $currentDate = date('Y-m-d');
        $this->db->query("UPDATE kegiatan SET status = 0 WHERE tanggal < '$currentDate' AND status = 1");

        return $this->response->setJSON(['status' => 'success']);
    }


    public function simpan_laporan_kegiatan()
    {
        $db = db_connect();
        $validation = \Config\Services::validation();
        $rule = [
            'id_kegiatan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama kegiatan harus diisi.',
                ]
            ],
            'pemasukan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pemasukan harus diisi.'
                ]
            ],
            'pengeluaran' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Pengeluaran harus diisi.'
                ]
            ],
        ];
        $validation->setRules($rule);

        if (!$validation->run($this->request->getPost())) {
            session()->setFlashdata(['msg' => $validation->getErrors(), 'warna' => 'danger']);
            return redirect()->back()->withInput();
        }

        $id_laporan_kegiatan = $this->request->getVar('id_laporan_kegiatan');
        $id_kegiatan = $this->request->getVar('id_kegiatan');
        $pemasukan = $this->request->getVar('pemasukan');
        $pengeluaran = $this->request->getVar('pengeluaran');
        $id_sanggar = session('id_sanggar');
        $id_guru = session('id_guru');
        $waktu = Time::now();
        $data = [
            'id_kegiatan' => $id_kegiatan,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'id_sanggar' => $id_sanggar,
            'id_guru' => $id_guru,
            'created_at' => $waktu
        ];

        if ($id_laporan_kegiatan) {
            $hasil = $db->table('laporan_kegiatan')->where('id_laporan_kegiatan', $id_laporan_kegiatan)->update($data);
            if ($hasil) {
                session()->setFlashdata(['msg' => 'Data Berhasil diubah', 'warna' => 'success']);
            } else {
                session()->setFlashdata(['msg' => 'Data gagal diubah', 'warna' => 'danger']);
            }
        } else {
            $hasil = $db->table('laporan_kegiatan')->insert($data);
            if ($hasil) {
                session()->setFlashdata(['msg' => 'Data Berhasil ditambahkan', 'warna' => 'success']);
            } else {
                session()->setFlashdata(['msg' => 'Data gagal ditambahkan', 'warna' => 'danger']);
            }
        }

        return redirect()->to('/kegiatan/laporan');
    }
}
