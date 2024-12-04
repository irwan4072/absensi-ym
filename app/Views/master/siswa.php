<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Siswa</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="siswa" method="post">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahSiswa">
                                Tambah Siswa
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
                            siswa bulan
                        </div>
                        <div class="card-body" id="siswa">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>id Kartu Siswa</th>
                                        <th>Nama</th>
                                        <th>Kelas</th>
                                        <th>Alamat Siswa</th>
                                        <th>Telepon</th>
                                        <th>JK</th>
                                        <th>Status</th>
                                        <th>Level</th>
                                        <th>Sanggar</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($siswa as $s) : ?>
                                        <tr>
                                            <td><?= $s['id_kartu']; ?></td>
                                            <td><?= $s['nama_siswa']; ?></td>
                                            <td><?= $s['kelas']; ?></td>
                                            <td><?= $s['alamat_siswa']; ?></td>
                                            <td><?= $s['telp_siswa']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['status']; ?></td>
                                            <td><?= $s['level']; ?></td>
                                            <td><?= $s['id_sanggar']; ?></td>
                                            <td>
                                                <?php $id = $s['id_siswa']; ?>
                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-primary btn-sm me-2" href="/admin/siswa/<?= $id; ?>">edit</a>
                                                    <a class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?')" href="/admin/hapus_siswa/<?= $id; ?>">hapus</a>
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

<div class="modal fade" id="tambahSiswa" tabindex="-1" aria-labelledby="tambahSiswaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url(); ?>/admin/simpan_siswa" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahSiswaLabel">siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <?= csrf_field(); ?>

                    <div class="mb-3 row">
                        <label for="nama_siswa" class="col-sm-2 col-form-label">Nama Siswa</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Nama Siswa" name="nama_siswa" id="nama_siswa" class="form-control" value="<?= old('nama_siswa'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="kelas" id="kelas">
                                <option value="">Pilih Kelas</option>
                                <?php for ($i = 1; $i <= 6; $i++) : ?>
                                    <option value="<?= $i; ?>" <?= old('kelas') == $i ? 'selected' : ''; ?>><?= $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="alamat_siswa" class="col-sm-2 col-form-label">Alamat Siswa</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Alamat siswa" name="alamat_siswa" id="alamat_siswa" value="<?= old('alamat_siswa'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" placeholder="Telepon" name="telepon" id="telepon" value="<?= old('telepon'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin1" value="laki-laki" <?= old('jenis_kelamin') == 'laki-laki' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin1">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="jenis_kelamin2" value="perempuan" <?= old('jenis_kelamin') == 'perempuan' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="jenis_kelamin2">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status1" value="yatim" <?= old('status') == 'yatim' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status1">
                                    Yatim
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="status2" value="non yatim" <?= old('status') == 'non yatim' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="status2">
                                    Non Yatim
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Level" name="level" id="level" class="form-control" value="<?= old('level'); ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="id_sanggar" class="col-sm-2 col-form-label">Sanggar</label>
                        <div class="col-sm-10">
                            <select class="form-select" aria-label="Default select example" name="id_sanggar" id="id_sanggar">
                                <option value="">Pilih Sanggar</option>
                                <?php foreach ($sanggar as $s) : ?>
                                    <option value="<?= $s['id_sanggar']; ?>" <?= old('id_sanggar') == $s['id_sanggar'] ? 'selected' : ''; ?>><?= $s['sanggar']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="id_kartu" class="col-sm-2 col-form-label">Id Kartu</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Id Kartu" name="id_kartu" id="id_kartu" class="form-control" value="<?= old('id_kartu'); ?>">
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