<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>



<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Guru</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="user" method="post">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUser">
                                Tambah Guru
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
                            Daftar Guru
                        </div>
                        <div class="card-body" id="user">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Sanggar</th>
                                        <th>pelajaran</th>
                                        <th>Terdaftar</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($guru as $s) : ?>
                                        <tr>
                                            <td><?= $s['nama_guru']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['alamat_guru']; ?></td>
                                            <td><?= $s['telp_guru']; ?></td>
                                            <td><?= $s['id_sanggar']; ?></td>
                                            <td><?= $s['pelajaran']; ?></td>
                                            <td><?= $s['daftar']; ?></td>
                                            <?php $id = $s['id_guru'] ?>
                                            <?php
                                            $cipher = "aes-256-cbc"; // Algoritma enkripsi
                                            $key = "UNIPI2020804118"; // Kunci enkripsi (harus cukup panjang untuk algoritma yang dipilih)
                                            $ivlen = openssl_cipher_iv_length($cipher);
                                            $iv = openssl_random_pseudo_bytes($ivlen);
                                            $ciphertext = openssl_encrypt($id, $cipher, $key, $options = 0, $iv);
                                            $ciphertext_iv = base64_encode($ciphertext . '::' . $iv);
                                            // dd(urlencode($ciphertext_iv));

                                            ?>
                                            <td>

                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-primary btn-sm me-2" href="/admin/guru/<?= $id; ?>">edit</a>
                                                    <!-- <a class="btn btn-primary btn-sm mb-2" href="/admin/edit_guru/<?php
                                                                                                                        //  urlencode($ciphertext_iv); 
                                                                                                                        ?>">edit</a> -->
                                                    <a class="btn btn-danger btn-sm" onclick="confirm('anda yakin ingin menghapus data ini?')" href="/admin/hapus_guru/<?= $id; ?>">hapus</a>

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
            <form action="/admin/simpan_guru" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUserLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="mb-3 row">
                        <label for="nama_guru" class="col-sm-2 col-form-label">Nama Guru</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Nama Guru" name="nama_guru" id="nama_guru" class="form-control" value="<?= old('nama_guru'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="pria" <?= old('jenis_kelamin') == 'pria' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin1">Pria</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="wanita" <?= old('jenis_kelamin') == 'wanita' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin2">Wanita</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat_guru" class="col-sm-2 col-form-label">Alamat Guru</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat Guru" name="alamat_guru" id="alamat_guru" value="<?= old('alamat_guru'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" value="<?= old('telepon'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="id_sanggar" class="col-sm-2 col-form-label">Sanggar</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="id_sanggar" id="id_sanggar">
                                <option value="">Pilih Sanggar</option>
                                <?php foreach ($sanggar as $s) : ?>
                                    <option value="<?= $s['id_sanggar']; ?>" <?= old('id_sanggar') == $s['id_sanggar'] ? 'selected' : ''; ?>>
                                        <?= $s['sanggar']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <!-- <div class="mb-3 row">
                        <label for="pelajaran" class="col-sm-2 col-form-label">Pelajaran</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="pelajaran" id="pelajaran">
                                <option value="">Pilih Pelajaran</option>
                                <option value="umum" <?php
                                                        // old('pelajaran') == 'umum' ? 'selected' : ''; 
                                                        ?>>Umum</option>
                                <option value="agama" <?php
                                                        // old('pelajaran') == 'agama' ? 'selected' : ''; 
                                                        ?>>Agama</option>
                            </select>
                        </div>
                    </div> -->

                    <div class="mb-3 row">
                        <label for="pelajaran" class="col-sm-2 col-form-label">Pelajaran</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Pelajaran" name="pelajaran" id="pelajaran" class="form-control-plaintext" readonly value="matematika">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Username" name="username" id="username" class="form-control" value="<?= old('username'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" placeholder="Password" name="password" id="password" class="form-control" value="<?= old('password'); ?>">
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