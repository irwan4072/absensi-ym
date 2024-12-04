<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_kegiatan" method="post">
                            <h1 class="mt-4 text-center">Ubah Data Kegiatan</h1>
                            <div class="card">
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
                                <!-- </div> -->
                                <div class="card-body">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="<?= $kegiatan['id_kegiatan']; ?>">
                                    <div class="mb-3 row">
                                        <label for="nama_kegiatan" class="col-sm-2 col-form-label">Nama Kegiatan</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="nama kegiatan" name="nama_kegiatan" id="nama_kegiatan" class="form-control" value="<?= old('nama_kegiatan') ?: $kegiatan['nama_kegiatan'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="syarat" class="col-sm-2 col-form-label">Syarat</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" aria-label="Default select example" name="syarat" id="syarat">
                                                <option value="" <?= old('syarat') ? '' : (!$kegiatan['syarat'] ? 'selected' : '') ?>>Syarat</option>
                                                <option value="yatim" <?= old('syarat') == 'yatim' ? 'selected' : ($kegiatan['syarat'] == 'yatim' ? 'selected' : '') ?>>Yatim</option>
                                                <option value="level tertinggi" <?= old('syarat') == 'level tertinggi' ? 'selected' : ($kegiatan['syarat'] == 'level tertinggi' ? 'selected' : '') ?>>Level Tertinggi</option>
                                                <option value="semua" <?= old('syarat') == 'semua' ? 'selected' : ($kegiatan['syarat'] == 'semua' ? 'selected' : '') ?>>Semua Siswa</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Pelaksanaan</label>
                                        <div class="col-sm-10">
                                            <input type="datetime-local" placeholder="Tanggal Pelaksanaan" name="tanggal" id="tanggal" class="form-control" value="<?= old('tanggal') ?: $kegiatan['tanggal'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi Pelaksanaan</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Lokasi Pelaksanaan" name="lokasi" id="lokasi" class="form-control" value="<?= old('lokasi') ?: $kegiatan['lokasi'] ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="jumlah_peserta" class="col-sm-2 col-form-label">Jumlah Peserta</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Jumlah Peserta" name="jumlah_peserta" id="jumlah_peserta" class="form-control" value="<?= old('jumlah_peserta') ?: $kegiatan['jumlah_peserta'] ?>">
                                        </div>
                                    </div>

                                    <div class="row text-center">
                                        <div class="d-grid gap-2 d-md-block">
                                            <a class="btn btn-primary" href="/admin/kegiatan">batal</a>
                                            <button class="btn btn-primary" type="submit" name="perbarui">Perbarui</button>
                                        </div>
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