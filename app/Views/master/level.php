<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Data Level</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahLevel">
                            Tambah Level
                        </button>
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
                            Level
                        </div>
                        <div class="card-body" id="siswa">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jilid</th>
                                        <th>Materi</th>
                                        <th>Level</th>
                                        <th>Tema</th>
                                        <th>Tindakan</th>
                                    </tr>
                                </thead>
                                <?php $i = 1; ?>
                                <tbody>
                                    <?php foreach ($level as $s) : ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= $s['jilid']; ?></td>
                                            <td><?= $s['materi']; ?></td>
                                            <td><?= $s['level']; ?></td>
                                            <td><?= $s['tema']; ?></td>
                                            <td>
                                                <?php $id = $s['id_level'] ?>

                                                <div class="d-flex align-items-center">
                                                    <a class="btn btn-primary btn-sm me-2" href="/admin/level/<?= $id; ?>">edit</a>
                                                    <!-- <a class="btn btn-primary btn-sm mb-2" href="/admin/edit_level/<?php
                                                                                                                        //  urlencode($ciphertext_iv); 
                                                                                                                        ?>">edit</a> -->
                                                    <a class="btn btn-danger btn-sm" onclick="confirm('anda yakin ingin menghapus data ini?')" href="/admin/hapus_level/<?= $id; ?>">hapus</a>
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

<div class="modal fade" id="tambahLevel" tabindex="-1" aria-labelledby="tambahLevelLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url(); ?>/admin/simpan_level" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahLevelLabel">Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <?php if ($validation->getErrors()) {
                    echo 'ok';
                } ?>
                <div class="modal-body">
                    <?= csrf_field(); ?>

                    <div class="mb-3 row">
                        <label for="jilid" class="col-sm-2 col-form-label">Jilid</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Jilid" name="jilid" id="jilid" class="form-control" value="<?= old('jilid'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="materi" class="col-sm-2 col-form-label">Materi</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Materi" name="materi" id="materi" class="form-control" value="<?= old('materi'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="level" class="col-sm-2 col-form-label">Level</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Level" name="level" id="telepon" class="form-control" value="<?= old('level'); ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="tema" class="col-sm-2 col-form-label">Tema</label>
                        <div class="col-sm-10">
                            <input type="text" placeholder="Tema" name="tema" id="tema" class="form-control" value="<?= old('tema'); ?>">
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