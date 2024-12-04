<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Staff Program</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="staff" method="post">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahStaff">
                                Tambah Staff
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
                            Staff
                        </div>
                        <div class="card-body" id="staff">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>jenis kelamin</th>
                                        <th>Alamat Staff</th>
                                        <th>Telepon</th>
                                        <th>jabatan</th>
                                        <th>Terdaftar</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($staff as $s) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $s['nama_staff']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['alamat_staff']; ?></td>
                                            <td><?= $s['telp_staff']; ?></td>
                                            <td><?= $s['jabatan']; ?></td>
                                            <td><?= $s['daftar']; ?></td>
                                            <td>
                                                <?php $id = $s['id_staff'] ?>
                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-primary btn-sm me-2" href="/admin/staff/<?= $id; ?>">edit</a>
                                                    <!-- <a class="btn btn-primary btn-sm mb-2" href="/admin/edit_staff/<?php
                                                                                                                        //  urlencode($ciphertext_iv); 
                                                                                                                        ?>">edit</a> -->
                                                    <a class="btn btn-danger btn-sm" onclick="confirm('anda yakin ingin menghapus data ini?')" href="/admin/hapus_staff/<?= $id; ?>">hapus</a>
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

<div class="modal fade" id="tambahStaff" tabindex="-1" aria-labelledby="tambahStaffLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/admin/simpan_staff" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahStaffLabel">Tambah Staff</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if (isset($validation) && $validation->getErrors()) : ?>
                    <div class="alert alert-danger">
                        <?= $validation->listErrors(); ?>
                    </div>
                <?php endif; ?>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="mb-3 row">
                        <label for="nama_staff" class="col-sm-2 col-form-label">Nama Staff</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Nama Staff" name="nama_staff" id="nama_staff" aria-label="default input example" value="<?= old('nama_staff'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="pria" <?= old('jenis_kelamin') === 'pria' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin1">
                                    Pria
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="wanita" <?= old('jenis_kelamin') === 'wanita' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin2">
                                    Wanita
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="alamat_staff" class="col-sm-2 col-form-label">Alamat Staff</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat Staff" name="alamat_staff" id="alamat_staff" aria-label="default input example" value="<?= old('alamat_staff'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" aria-label="default input example" value="<?= old('telepon'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                        <div class="col-sm-10">
                            <input class="form-control-plaintext" type="text" placeholder="Jabatan" name="jabatan" id="jabatan" aria-label="default input example" value="staff program" readonly>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Username" name="username" id="username" aria-label="default input example" value="<?= old('username'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="password" placeholder="Password" name="password" id="password" aria-label="default input example">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>