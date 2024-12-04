<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_siswa" method="post">
                            <h1 class="mt-4">Ubah Data Siswa</h1>
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
                            <div class="card">
                                <div class="card-body">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">
                                    <div class="mb-3 row">
                                        <label for="nama_siswa" class="col-sm-2 col-form-label">Nama Siswa</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa" class="form-control" value="<?= old('nama_siswa') ?: $siswa['nama_siswa']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                                        <?php $selected_kelas = old('kelas') ?? $siswa['kelas'];  ?>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="kelas" id="kelas">
                                                <option selected value="">Kelas</option>
                                                <option value="1" <?= ($selected_kelas == 1) ? 'selected' : ''; ?>>1</option>
                                                <option value="2" <?= ($selected_kelas == 2) ? 'selected' : ''; ?>>2</option>
                                                <option value="3" <?= ($selected_kelas == 3) ? 'selected' : ''; ?>>3</option>
                                                <option value="4" <?= ($selected_kelas == 4) ? 'selected' : ''; ?>>4</option>
                                                <option value="5" <?= ($selected_kelas == 5) ? 'selected' : ''; ?>>5</option>
                                                <option value="6" <?= ($selected_kelas == 6) ? 'selected' : ''; ?>>6</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="alamat_siswa" class="col-sm-2 col-form-label">Alamat Siswa</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Alamat siswa" name="alamat_siswa" id="alamat_siswa" aria-label="default input example" value="<?= old('alamat_siswa') ?: $siswa['alamat_siswa']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" aria-label="default input example" value="<?= old('telepon') ?:  $siswa['telp_siswa']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jenis_kelamin" class="col-sm-2 col-form-label">jenis kelamin</label>
                                        <div class="col-sm-10">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="laki-laki" <?= (old('jenis_kelamin') ?? $siswa['jenis_kelamin']) == 'laki-laki' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin1">
                                                    laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="perempuan" <?= (old('jenis_kelamin') ?? $siswa['jenis_kelamin']) == 'perempuan' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="jenis_kelamin2">
                                                    perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-10">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status1" value="yatim" <?= (old('status') ?? $siswa['status']) == 'yatim' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="status1">
                                                    Yatim
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="status2" value="non yatim" <?= (old('status') ?? $siswa['status']) == 'non yatim' ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="status2">
                                                    Non Yatim
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Level" name="level" id="level" class="form-control" value="<?= old('level') ?:  $siswa['level']; ?>">
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="id_sanggar" class="col-sm-2 col-form-label">Sanggar</label>
                                        <div class="col-sm-10">
                                            <?php $selected_sanggar = old('id_sanggar') ?? $siswa['id_sanggar'];  ?>
                                            <!-- <input class="form-control" type="text" placeholder="Jenis Kelamin" name="id_sanggar" id="id_sanggar" aria-label="default input example"> -->
                                            <select class="form-select" aria-label="Default select example" name="id_sanggar" id="id_sanggar">

                                                <option selected>Pilih Sanggar</option>
                                                <?php foreach ($sanggar as $s) : ?>
                                                    <option value="<?= $s['id_sanggar']; ?>" <?= ($selected_sanggar == $s['id_sanggar']) ? 'selected' : ''; ?>><?= $s['sanggar']; ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="id_kartu" class="col-sm-2 col-form-label">Id Kartu</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Id Kartu" name="id_kartu" id="id_kartu" class="form-control" value="<?= old('id_kartu') ?: $siswa['id_kartu']; ?>">
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