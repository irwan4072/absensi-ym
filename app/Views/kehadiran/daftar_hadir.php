<?php

use PhpParser\Node\Stmt\Echo_;

helper('App\Helpers\kehadiran');
$db      = \Config\Database::connect();
// dd($bulanLalu);

// dd($kehadiran[11]);
$tanggal = [];

for ($i = 0; $i < count($kehadiran); $i++) {
    $tgl = substr($kehadiran[$i]['tanggal'], 8);
    // dd(array_search('02', $tanggal));
    // dd(is_bool(array_search($tgl, $tanggal)));
    if (is_bool(array_search($tgl, $tanggal)) == true) {
        $tanggal[] = intval($tgl);
    }

    $i++;
}
// dd($kehadiran);
?>



<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Daftar Hadir</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="kehadiran" method="post">
                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKehadiran">
                                Tambah Daftar Hadir
                            </button> -->
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <input type="month" name="date" id="date" value="<?= (isset($bulan) ? $bulan : date('Y-m')); ?>" class="form-control">
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" aria-label="Default select example" name="sanggarHadir" id="sanggarHadir">
                                        <option selected>pilih sanggar</option>
                                        <?php foreach ($sanggar as $s): ?>
                                            <option value="<?= $s['id_sanggar']; ?>" <?= ($id_sanggar == $s['id_sanggar']) ? 'selected' : ''; ?>><?= $s['sanggar']; ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="card mb-4 alert alert-<?= session()->getFlashdata('warna'); ?>">
                            <div class="card-body">
                                <?= session()->getFlashdata('pesan'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <!-- <i class="fas fa-table me-1"></i>
                            kehadiran bulan  -->
                            <div class="d-flex justify-content-start" role="group">
                            </div>
                        </div>
                        <div class="card-body" id="kehadiran">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th rowspan="2" class="kepalaTabel">Nama</th>
                                        <th rowspan="2" class="kepalaTabel">Jenis Kelamin</th>
                                        <th rowspan="2" class="kepalaTabel">kelas</th>
                                        <th rowspan="2" class="kepalaTabel">status</th>
                                        <th colspan="<?= count($tanggal) ?>" class="kepalaTabel">laporan perkembangan bulan <?= nama_bulan($bln); ?></th>
                                        <th rowspan="2" class="kepalaTabel  text-center">Total masuk</th>
                                        <!-- <th>Salary</th> -->
                                    </tr>
                                    <?php
                                    // dd($kehadiran)
                                    ?>
                                    <tr>
                                        <?php for ($i = 0; $i < count($tanggal); $i++) : ?>

                                            <th class=" text-center">tgl : <?= $tanggal[$i]; ?></th>
                                        <?php endfor ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($kehadiran) > 0) : ?>
                                        <?php foreach ($siswa as $sis) : ?>
                                            <?php $masuk = 0 ?>
                                            <tr>
                                                <td><?= $sis['nama_siswa']; ?></td>
                                                <td class=" text-center"><?= $sis['jenis_kelamin']; ?></td>
                                                <td class=" text-center"><?= $sis['kelas']; ?></td>
                                                <td class=" text-center"><?= $sis['status']; ?></td>
                                                <?php
                                                $id = $sis['id_siswa'];
                                                // $query = "SELECT * 
                                                //                 FROM kehadiran 
                                                //                 WHERE tanggal >= DATE_SUB(DATE_FORMAT(CURDATE(), '%Y-%m-01'), INTERVAL 1 MONTH) + INTERVAL 20 DAY
                                                //                 AND tanggal < DATE_FORMAT(CURDATE(), '%Y-%m-01') + INTERVAL 19 DAY
                                                //                 AND id_siswa = '$id'
                                                //                 ";
                                                $query = "SELECT kehadiran.*, level.level as level_kehadiran FROM kehadiran JOIN level ON kehadiran.level = level.id_level WHERE tanggal >  '$bulanLalu' AND tanggal < '$bulanSkrg' AND kehadiran.id_siswa = '$id'";
                                                // $kehadiran = $this->kehadiran->findAll();
                                                $daftarHadir = $db->query($query)->getResultArray();
                                                // dd($query);

                                                ?>
                                                <?php for ($i = 0; $i < count($tanggal); $i++) : ?>
                                                    <?php
                                                    // dd($daftarHadir[9]['kehadiran']);
                                                    ?>
                                                    <?php if (!isset($daftarHadir[$i]['kehadiran'])) : ?>

                                                        <td></td>
                                                    <?php elseif ($daftarHadir[$i]['kehadiran'] == 'hadir') : ?>
                                                        <td style="background-color: #7FFF00;"><?= strtoupper($daftarHadir[$i]['level_kehadiran']) ?></td>
                                                        <?php $masuk += 1; ?>
                                                    <?php else : ?>
                                                        <td style="background-color: <?= ($daftarHadir[$i]['kehadiran'] == 'alfa' ? 'red' : ($daftarHadir[$i]['kehadiran'] == 'izin' || $daftarHadir[$i]['kehadiran'] == 'sakit' ? 'yellow' : '')); ?>;"><?= ucwords($daftarHadir[$i]['kehadiran']); ?></td>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                                <td style="text-align: center; background-color: <?= ($masuk < (count($tanggal) / 2) ? 'red' : ''); ?>"><?= $masuk; ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
</div>


<?= $this->endSection(); ?>