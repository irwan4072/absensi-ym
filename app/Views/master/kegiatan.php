<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>



<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Kegiatan</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="/admin/simpan_kegiatan" method="post">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUser">
                                Tambah Kegiatan
                            </button>

                        </form>
                    </div>
                    <?php if ($message = session()->getFlashdata('msg')): ?>
                        <div class="alert alert-<?= session('warna'); ?>">
                            <ul>
                                <?php if (is_array(session('msg'))) : ?>
                                    <?php foreach (session('msg') as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <li><?= session('msg') ?></li>
                                <?php endif ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar Kegiatan
                        </div>
                        <div class="card-body" id="kegiatan">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Syarat</th>
                                        <th>tanggal Pelaksanaan</th>
                                        <th>Lokasi</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Tindakan Status</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($kegiatan as $s) : ?>
                                        <tr>
                                            <td><?= $s['nama_kegiatan']; ?></td>
                                            <td><?= $s['syarat']; ?></td>
                                            <td><?= $s['tanggal']; ?></td>
                                            <td><?= $s['lokasi']; ?></td>
                                            <td><?= $s['jumlah_peserta']; ?></td>
                                            <td>
                                                <button class="toggle-status btn <?= $s['status'] == 1 ? 'btn-danger' : 'btn-success'; ?>" data-id="<?= $s['id_kegiatan'] ?>">
                                                    <?= $s['status'] == 1 ? 'Non Aktifkan' : 'Aktifkan'; ?>
                                                </button>
                                            </td>
                                            <?php $id = $s['id_kegiatan'] ?>
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-primary btn-sm me-2" href="/admin/kegiatan/<?= $id; ?>">edit</a>
                                                    <!-- <a class="btn btn-primary btn-sm mb-2" href="/admin/edit_kegiatan/<?php
                                                                                                                            //  urlencode($ciphertext_iv); 
                                                                                                                            ?>">edit</a> -->
                                                    <a class="btn btn-danger btn-sm" onclick="confirm('anda yakin ingin menghapus data ini?')" href="/admin/hapus_kegiatan/<?= $id; ?>">hapus</a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

        </div>
    </div>
</div>

<div class="modal fade" id="tambahUser" tabindex="-1" aria-labelledby="tambahUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/admin/simpan_kegiatan" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUserLabel">Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="mb-3 row">
                        <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="nama kegiatan" name="nama_kegiatan" id="nama_kegiatan" class="form-control" value="<?= old('nama_kegiatan') ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="syarat" class="col-sm-2 col-form-label">Syarat</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="syarat" id="syarat">
                                <option value="" <?= old('syarat') ? '' : 'selected' ?>>Syarat</option>
                                <option value="yatim" <?= old('syarat') == 'yatim' ? 'selected' : '' ?>>Yatim</option>
                                <option value="semua" <?= old('syarat') == 'semua' ? 'selected' : '' ?>>Semua Siswa</option>

                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Pelaksanaan</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" placeholder="Tanggal Pelaksanaan" name="tanggal" id="tanggal" class="form-control" value="<?= old('tanggal') ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi Pelaksanaan</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Lokasi Pelaksanaan" name="lokasi" id="lokasi" class="form-control" value="<?= old('lokasi') ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jumlah_peserta" class="col-sm-2 col-form-label">Jumlah Peserta</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Jumlah Peserta" name="jumlah_peserta" id="jumlah_peserta" class="form-control" value="<?= old('jumlah_peserta') ?>">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     // $('.toggle-status').click(function() {
    //     //     var button = $(this);
    //     //     var id = button.data('id');
    //     //     var status = button.text().trim();
    //     //     console.log(id);

    //     //     var newStatus = status == 'Aktifkan' ? 'Non Aktif' : 'Aktif';
    //     //     var confirmMessage = 'Apakah Anda yakin ingin mengubah status menjadi ' + newStatus + '?';

    //     //     if (confirm(confirmMessage)) {
    //     //         $.ajax({
    //     //             url: '<?= site_url('/admin/toggleStatus'); ?>',
    //     //             type: 'POST',
    //     //             data: {
    //     //                 id: id
    //     //             },
    //     //             success: function(response) {
    //     //                 if (response.success) {
    //     //                     button.text(newStatus);
    //     //                 } else {
    //     //                     alert('Gagal mengubah status');
    //     //                 }
    //     //             },
    //     //             error: function() {
    //     //                 alert('Terjadi kesalahan');
    //     //             }
    //     //         });
    //     //     }
    //     // });
    // });
</script>

<?= $this->endSection(); ?>