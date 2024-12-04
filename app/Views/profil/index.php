<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container mt-5">
                <?php if ($user['role'] == 'staff program') : ?>
                    <div class="container mt-5">
                        <h2 class="mb-4">Profil Staff Program</h2>
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
                        <div class="row mb-3">
                            <label for="nama_staff" class="col-sm-2 col-form-label">Nama Staff Program</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" id="nama_staff" value="<?= $user['nama_staff'] ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" id="jenis_kelamin" value="<?= $user['jenis_kelamin'] ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="alamat_staff" class="col-sm-2 col-form-label">Alamat Staff</label>
                            <div class="col-sm-10">
                                <textarea readonly class="form-control" id="alamat_staff" rows="3"><?= $user['alamat_staff'] ?></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="telp_staff" class="col-sm-2 col-form-label">Telepon Staff</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" id="telp_staff" value="<?= $user['telp_staff'] ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" id="jabatan" value="<?= $user['jabatan'] ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="username" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control" id="username" value="<?= $user['username'] ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <!-- Button trigger modal Ubah Password -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Ubah Password
                                </button>
                            </div>
                        </div>
                    </div>

                <?php else : ?>
                    <h2 class="mb-4">Profil Guru</h2>

                    <div class="row mb-3">
                        <label for="nama_guru" class="col-sm-2 col-form-label">Nama Guru</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="nama_guru" value="<?= $user['nama_guru'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="jenis_kelamin" value="<?= $user['jenis_kelamin'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="alamat_guru" class="col-sm-2 col-form-label">Alamat Guru</label>
                        <div class="col-sm-10">
                            <textarea readonly class="form-control" id="alamat_guru" rows="3"><?= $user['alamat_guru'] ?></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="telp_guru" class="col-sm-2 col-form-label">Telepon Guru</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="telp_guru" value="<?= $user['telp_guru'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="id_sanggar" class="col-sm-2 col-form-label">ID Sanggar</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="id_sanggar" value="<?= $user['id_sanggar'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="pelajaran" class="col-sm-2 col-form-label">Pelajaran</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="pelajaran" value="<?= $user['pelajaran'] ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                        <div class="col-sm-10">
                            <input type="text" readonly class="form-control" id="username" value="<?= $user['username'] ?>">
                        </div>
                    </div>
                <?php endif ?>
            </div>

        </div>
    </div>
</div>





<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="/profil/ubah_password" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="old_password" class="form-label">Password Lama</label>
                        <div class="input-group">
                            <input type="password" name="old_password" id="old_password" class="form-control">
                            <span class="input-group-text password-toggle" data-target="#old_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="new_password" class="form-label">Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="new_password" id="new_password" class="form-control">
                            <span class="input-group-text password-toggle" data-target="#new_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                            <span class="input-group-text password-toggle" data-target="#confirm_password">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>







<?= $this->endSection(); ?>