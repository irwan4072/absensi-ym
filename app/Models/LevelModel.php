<?php

namespace App\Models;

use CodeIgniter\Model;

class LevelModel extends Model
{
    protected $table = 'level';
    protected $primaryKey = 'id_level';
    protected $useTimeStamps = true;
    protected $allowedFields = ['jilid', 'materi', 'level', 'tema', 'urutan'];

    public function getData($data = false)
    {
        if ($data == false) {
            return $this->findAll();
        } else {
            return $this->where('id_level', $data)->first();
        }
    }


    function coba($data)
    {
        $db = db_connect();
        // dd($data);
        // $data = ['jilid' => "b"];
        // $levelHurufDanAngka = $this->__pisahkanHurufDanAngka($data);

        // -------------cek ketersediaan dan akhir melalui jilid-----
        $cekKetersediaanJilid = $this->select()->like('level', $data['jilid'] . '%')->orderBy('urutan', "DESC")->first();
        // dd($cekKetersediaanJilid);

        if (!$cekKetersediaanJilid) {
            $urutanMax = $this->selectMax('urutan')->first();
            if ($urutanMax) {
                $urutan = $urutanMax['urutan'] + 1;
                $data['urutan'] = $urutan;
                // dd($data);
                return $data;
            } else {
                return false;
            }
        } else {
            // dd($cekKetersediaanJilid);
            // ---------------------- cek apakah level baru melebihi nilai level maksimal------------------
            $levelMax = substr($cekKetersediaanJilid['level'], 1);
            // d($data['level']);
            // dd($levelMax);
            if ($data['level'] > $levelMax) {
                $data['combinedLevel'] = $data['jilid'] . $levelMax + 1;
                $urutanPadaLevelbaru = $cekKetersediaanJilid['urutan'] + 1;
                // dd($urutanPadaLevelbaru);

                if ($urutanPadaLevelbaru) {
                    $data['urutan'] = $urutanPadaLevelbaru;

                    // dd($data);
                    $query = "
                    UPDATE level
                    SET urutan = urutan + 1
                    WHERE urutan >=" . $urutanPadaLevelbaru;
                    // dd($query);

                    $db->query($query);
                    if ($query) {
                        return $data;
                    } else {
                        return false;
                    }
                    return $data;
                } else {
                    return false;
                }


                // ----------------- jika level dan urutan level berada ditengah data---------------------
            } else {
                $urutanPadaLevelTersedia = $this->select('urutan')->where('level', $data['combinedLevel'])->first();
                // dd($urutanPadaLevelTersedia);
                if ($urutanPadaLevelTersedia) {
                    $urutanPadaLevelBaru = $urutanPadaLevelTersedia['urutan'];
                    $query = "
                UPDATE level
                SET urutan = urutan + 1,
                    level = CONCAT(SUBSTRING(level, 1, 1), CAST(SUBSTRING(level, 2) AS UNSIGNED) + 1)
                WHERE urutan >=" . $urutanPadaLevelBaru;
                    $data['urutan'] = $urutanPadaLevelBaru;

                    $db->query($query);
                    if ($query) {
                        return $data;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    function urutkanLevelHapus($id)
    {
        // dd($id);
        $db = db_connect();
        $urutanUntukDihapus = $this->select('urutan')->where('id_level', $id)->first();
        // dd($urutanUntukDihapus);
        if ($urutanUntukDihapus) {
            $urutan = $urutanUntukDihapus['urutan'];
            // dd($urutan);
            $query = "
                UPDATE level
                SET urutan = urutan - 1,
                    level = CONCAT(SUBSTRING(level, 1, 1), CAST(SUBSTRING(level, 2) AS UNSIGNED) - 1)
                WHERE urutan > " . $urutan;
            // $data['urutan'] = $urutan;

            $db->query($query);
            if ($query) {

                return true;
            } else {
                return false;
            }
        } else {
            die;
            return false;
        }
    }
    private function __pisahkanHurufDanAngka($string)
    {
        // Memisahkan huruf dan angka
        preg_match('/^([a-zA-Z]+)(\d+)$/', $string, $matches);

        // Mengembalikan hasil
        return [
            'huruf'  => $matches[1] ?? '', // Bagian huruf
            'angka'  => $matches[2] ?? '' // Bagian angka
        ];
    }


    public function insertLevel($newLevel)
    {
        $db = db_connect();
        $builder = $db->table($this->table);

        // Temukan posisi di mana level baru harus disisipkan
        $result = $builder->select('id, level')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResult();

        $insertId = null;

        // Cari ID penyisipan yang sesuai
        foreach ($result as $row) {
            if ($this->compareLevels($newLevel, $row->level) <= 0) {
                $insertId = $row->id;
                break;
            }
        }

        // Jika insertId masih null, berarti newLevel lebih besar dari semua level yang ada
        if (is_null($insertId)) {
            $insertId = end($result)->id + 1;
        }

        // Geser data yang ada
        $builder->set('id', 'id + 1', false)
            ->where('id >=', $insertId)
            ->update();

        // Sisipkan data baru
        $data = [
            'id' => $insertId,
            'level' => $newLevel
        ];
        $builder->insert($data);
    }

    public function deleteLevel($levelToDelete)
    {
        $db = db_connect();
        $builder = $db->table($this->table);

        // Temukan ID dari level yang akan dihapus
        $result = $builder->select('id, level')
            ->where('level', $levelToDelete)
            ->get()
            ->getRow();

        if ($result) {
            $deleteId = $result->id;

            // Temukan level setelah yang dihapus
            $nextRows = $builder->select('id, level')
                ->where('id >', $deleteId)
                ->orderBy('id', 'ASC')
                ->get()
                ->getResult();

            // Hapus level
            $builder->where('id', $deleteId)->delete();

            foreach ($nextRows as $row) {
                $nextLevel = $this->getNextLevel($row->level);
                $builder->where('id', $row->id)
                    ->update(['level' => $nextLevel, 'id' => $row->id - 1]);
            }
        }
    }

    public function updateLevel($oldLevel, $newLevel)
    {
        $db = db_connect();
        $builder = $db->table($this->table);

        // Temukan ID dari level yang akan diubah
        $result = $builder->select('id, level')
            ->where('level', $oldLevel)
            ->get()
            ->getRow();

        if ($result) {
            $updateId = $result->id;

            // Temukan level-level setelah level yang diubah
            $nextRows = $builder->select('id, level')
                ->where('id >', $updateId)
                ->orderBy('id', 'ASC')
                ->get()
                ->getResult();

            // Update level
            $builder->where('id', $updateId)->update(['level' => $newLevel]);

            // Geser level yang lebih tinggi jika perlu
            foreach ($nextRows as $row) {
                if ($this->isSamePrefix($row->level, $newLevel)) {
                    $previousLevel = $this->incrementLevel($row->level);
                    $builder->where('id', $row->id)
                        ->update(['level' => $previousLevel]);
                }
            }
        }
    }

    // Fungsi untuk mendapatkan level berikutnya (misalnya dari a2 menjadi a3)
    private function getNextLevel($level)
    {
        preg_match('/([a-jA-J]+)(\d+)/', $level, $matches);
        $prefix = $matches[1];
        $number = (int)$matches[2] + 1;
        return $prefix . $number;
    }

    // Fungsi untuk menginkremen level (misalnya dari a2 menjadi a3)
    private function incrementLevel($level)
    {
        preg_match('/([a-jA-J]+)(\d+)/', $level, $matches);
        $prefix = $matches[1];
        $number = (int)$matches[2] + 1;
        return $prefix . $number;
    }

    // Fungsi untuk memeriksa apakah prefix level sama
    private function isSamePrefix($level1, $level2)
    {
        return $level1[0] === $level2[0];
    }

    // Fungsi untuk membandingkan level
    private function compareLevels($level1, $level2)
    {
        preg_match('/([a-jA-J]+)(\d+)/', $level1, $matches1);
        preg_match('/([a-jA-J]+)(\d+)/', $level2, $matches2);

        $prefix1 = $matches1[1];
        $number1 = (int)$matches1[2];

        $prefix2 = $matches2[1];
        $number2 = (int)$matches2[2];

        if ($prefix1 === $prefix2) {
            return $number1 - $number2;
        }
        return strcmp($prefix1, $prefix2);
    }
}
