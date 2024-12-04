<?php
helper('App\Helpers\kehadiran');

// dd();
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
                        <a href="/laporan/word" class="btn btn-primary" type="button">words</a>
                        <a href="/laporan/pdf" class="btn btn-primary" type="button">PDF</a>
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
                            <i class="fas fa-table me-1"></i>
                            kehadiran bulan januari
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>kelas</th>
                                        <th>status</th>
                                        <th colspan="10">laporan perkembangan bulan</th>
                                        <!-- <th>Salary</th> -->
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                </tfoot> -->

                                <tbody>
                                    <?php foreach ($siswa as $sis) : ?>
                                        <tr>
                                            <td><?= $sis['nama_siswa']; ?></td>
                                            <td><?= $sis['jenis_kelamin']; ?></td>
                                            <td><?= $sis['kelas']; ?></td>
                                            <td><?= $sis['status']; ?></td>
                                            <?php $daftarHadir = kehadiran($sis['id']) ?>
                                            <?php foreach ($daftarHadir as $hadir) : ?>
                                                <?php if ($hadir['kehadiran'] == 'hadir') : ?>
                                                    <td><?= $hadir['level_hadir']; ?></td>
                                                <?php else : ?>
                                                    <td><?= $hadir['kehadiran']; ?></td>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach ?>

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