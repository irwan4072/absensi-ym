<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_guru" method="post">
                            <h1 class="mt-4 text-center">Ubah Data Guru</h1>
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
                                    <?= csrf_field(); ?> <div class="mb-3 row">
                                        <input type="hidden" value="<?= $guru['id_guru']; ?>" name="id_guru">
                                        <label for="nama_guru" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="nama guru" name="nama_guru" id="nama_guru" class="form-control" value="<?= old('nama_kegiatan') ?: $guru['nama_guru']; ?>">
                                        </div>
                                    </div>
                                    <div class=" mb-3 row align-self-center">
                                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">jenis kelamin</label>

                                        <div class="col-sm-10  ">
                                            <div class="form-check  form-check-inline align-self-start">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="pria" <?= (old('jenis_kelamin') ?? $guru['jenis_kelamin']) == 'pria' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin1">
                                                    Pria
                                                </label>
                                            </div>
                                            <div class="form-check  form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="wanita" <?= (old('jenis_kelamin') ?? $guru['jenis_kelamin']) == 'wanita' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin2">
                                                    Wanita
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="alamat_guru" class="col-sm-2 col-form-label">Alamat guru</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Alamat guru" name="alamat_guru" id="alamat_guru" aria-label="default input example" value="<?= old('alamat_guru') ?:  $guru['alamat_guru']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" aria-label="default input example" value="<?= old('telepon') ?:  $guru['telp_guru']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="id_sanggar" class="col-sm-2 col-form-label">Sanggar</label>
                                        <div class="col-sm-10">
                                            <?php $selected_sanggar = old('id_sanggar') ?? $guru['id_sanggar'];  ?>
                                            <!-- <input class="form-control" type="text" placeholder="Jenis Kelamin" name="id_sanggar" id="id_sanggar" aria-label="default input example"> -->
                                            <select class="form-select" aria-label="Default select example" name="id_sanggar" id="id_sanggar">

                                                <option selected>Pilih Sanggar</option>
                                                <?php foreach ($sanggar as $s) : ?>
                                                    <option value="<?= $s['id_sanggar']; ?>" <?= ($selected_sanggar  == $s['id_sanggar']) ? 'selected' : ''; ?>><?= $s['sanggar']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- <div class="mb-3 row">
                                        <label for="pelajaran" class="col-sm-2 col-form-label">pelajaran</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="pelajaran" id="pelajaran" value="<?= $guru['pelajaran']; ?>">

                                                <option selected>Pilih Pelajaran</option>
                                                <option value="umum" <?= ($guru['pelajaran'] == 'umum') ? 'selected' : ''; ?>>Umum</option>
                                                <option value="agama" <?= ($guru['pelajaran'] == 'agama') ? 'selected' : ''; ?>>Agama</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <div class="mb-3 row">
                                        <label for="pelajaran" class="col-sm-2 col-form-label">Pelajaran</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Pelajaran" name="pelajaran" id="pelajaran" class="form-control-plaintext" value="matematika">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="username" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Username" name="username" id="username" class="form-control" value="<?= old('username') ?:  $guru['username']; ?>">
                                        </div>
                                    </div>
                                    <!-- <div class="mb-3 row">
                                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" placeholder="Password" name="password" id="password" class="form-control">
                                        </div>
                                    </div> -->
                                    <div class="row text-center">
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