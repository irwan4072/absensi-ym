<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_staff" method="post">
                            <h1 class="mt-4 text-center">Ubah Data Staff</h1>
                            <div class="card">
                                <div class="card-body">
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
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id_staff" value="<?= $staff['id_staff']; ?>">
                                    <input type="hidden" name="id_user" value="6">

                                    <div class="mb-3 row">
                                        <label for="nama_staff" class="col-sm-2 col-form-label">Nama Staff</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Nama Staff" name="nama_staff" id="nama_staff" aria-label="default input example" value="<?= old('nama_staff') ?: $staff['nama_staff']; ?>">
                                        </div>
                                    </div>



                                    <div class="mb-3 row">
                                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">jenis kelamin</label>
                                        <div class="col-sm-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="pria" <?= (old('jenis_kelamin') ?? $staff['jenis_kelamin']) == 'pria' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin1">
                                                    Pria
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="wanita" <?= (old('jenis_kelamin') ?? $staff['jenis_kelamin']) == 'wanita' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin2">
                                                    Wanita
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="alamat_staff" class="col-sm-2 col-form-label">Alamat Staff</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Alamat Staff" name="alamat_staff" id="alamat_staff" aria-label="default input example" value="<?= old('alamat_staff') ?: $staff['alamat_staff']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" aria-label="default input example" value="<?= old('telepon') ?: $staff['telp_staff']; ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Jabatan" name="jabatan" id="jabatan" aria-label="default input example" value="<?= old('jabatan') ?: $staff['jabatan']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Username" name="username" id="username" aria-label="default input example" value="<?= old('username') ?: $staff['username']; ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="d-grid gap-2 d-md-block">
                                            <button class="btn btn-primary" type="submit" name="perbarui">Perbarui</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?= $this->endSection(); ?>