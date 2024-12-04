<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>



<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Laporan Kegiatan</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <?php if (session()->get('role') == 'guru') : ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUser">
                                Buat Laporan Kegiatan
                            </button>
                        <?php endif ?>
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
                        <div class="card-body" id="user">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama Kegiatan</th>
                                        <th>Pemasukan</th>
                                        <th>pengeluaran</th>
                                        <th>Sanggar</th>
                                        <th>Pembuat Laporan</th>
                                        <th>Dibuat</th>
                                        <?php if (session()->get('role') == 'guru') : ?>
                                            <th>Tindakan</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($laporan_kegiatan as $s) : ?>
                                        <tr>
                                            <td><?= $s['nama_kegiatan']; ?></td>
                                            <td><?= $s['pemasukan']; ?></td>
                                            <td><?= $s['pengeluaran']; ?></td>
                                            <td><?= $s['sanggar']; ?></td>
                                            <td><?= $s['nama_guru'] ?> </td>
                                            <td><?= $s['created_at'] ?> </td>
                                            <?php if (session()->get('role') == 'guru') : ?>
                                                <td>
                                                    <?php $id = $s['id_laporan_kegiatan']; ?>
                                                    <div class="d-flex align-items-center">
                                                        <a class="btn btn-primary btn-sm me-2" href="/kegiatan/laporan/<?= $id ?>">edit</a>
                                                        <!-- <a class="btn btn-primary btn-sm mb-2" href="/admin/edit_kegiatan/<?php
                                                                                                                                //  urlencode($ciphertext_iv); 
                                                                                                                                ?>">edit</a> -->
                                                        <a class="btn btn-danger btn-sm" onclick="confirm('anda yakin ingin menghapus data ini?')" href="/kegiatan/hapus_laporan/<?= $id; ?>">hapus</a>

                                                        <div class="d-flex align-items-center">
                                                </td>
                                            <?php endif ?>
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
            <form action="/kegiatan/simpan_laporan_kegiatan" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUserLabel">Laporan Kegiatan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="mb-3 row">
                        <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                        <div class="col-sm-10">
                            <select name="id_kegiatan" id="id_kegiatan" class="form-control">
                                <option value="" disabled selected>Pilih Kegiatan</option>
                                <?php foreach ($kegiatan as $k): ?>
                                    <option value="<?= $k['id_kegiatan']; ?>" <?= old('id_kegiatan') == $k['id_kegiatan'] ? 'selected' : ''; ?>>
                                        <?= $k['nama_kegiatan']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                    </div>

                    <div class="mb-3 row">
                        <label for="pemasukan" class="col-sm-2 col-form-label">Pemasukan</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Pemasukan" name="pemasukan" id="telepon" value="<?= old('pemasukan'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="pengeluaran" class="col-sm-2 col-form-label">Pengeluaran</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Pengeluaran" name="pengeluaran" id="telepon" value="<?= old('pengeluaran'); ?>">
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
<?= $this->endSection(); ?>