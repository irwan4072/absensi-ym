<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<?php
if (session()->get('role') == 'staff program') {
    $cardLength = 'col-xl-3 col-md-6';
} else {

    $cardLength = 'col-xl-4 col-md-4';
}
// dd(session()->get('role'));
?>
<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-4">Dashboard</h1>
            <div class="row mt-3">
                <div class="row">
                    <div class="<?= $cardLength; ?> mt-3">
                        <div class="card bg-primary text-white mb-4 h-100 d-flex flex-column">
                            <div class="card-body text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                Persentase Kehadiran Keseluruhan<br>
                                <?= round($persentase_kehadiran['persentase_kehadiran']); ?>%
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="/kehadiran">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <?php if (session()->get('role') == 'staff program') : ?>
                        <div class="<?= $cardLength; ?> mt-3">
                            <div class="card bg-warning text-white mb-4 h-100 d-flex flex-column">
                                <div class="card-body text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                    Jumlah Guru<br>
                                    <?= $jml_guru['jml']; ?>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="/admin/guru">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    <?php endif ?>
                    <div class="<?= $cardLength; ?> mt-3">
                        <div class="card bg-success text-white mb-4 h-100 d-flex flex-column">
                            <div class="card-body text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                Jumlah Siswa<br>
                                <?= $jml_siswa['jml']; ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="/admin/siswa">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="<?= $cardLength; ?> mt-3">
                        <div class="card bg-danger text-white mb-4 h-100 d-flex flex-column">
                            <div class="card-body text-center flex-grow-1 d-flex align-items-center justify-content-center">
                                Kegiatan Aktif<br>
                                <?= $jml_kegiatanAktif['jml']; ?>
                            </div>
                            <div class="card-footer d-flex align-items-center justify-content-between">
                                <a class="small text-white stretched-link" href="admin/kegiatan">View Details</a>
                                <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid px-4 mt-3">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Persentase Kehadiran Setiap Sanggar
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama <?= (session('role') == 'staff program') ? 'Sanggar' : 'Siswa';; ?></th>
                                        <th>Persentase Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($persentase_detail as $a) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <?php if (session('role') == 'staff program') : ?>
                                                <td><?= htmlspecialchars($a['sanggar']); ?></td>
                                            <?php else : ?>
                                                <td><?= htmlspecialchars($a['nama_siswa']); ?></td>
                                            <?php endif ?>
                                            <td><?= round($a['persentase_kehadiran'], 2); ?>%</td>
                                        </tr>
                                    <?php endforeach ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>