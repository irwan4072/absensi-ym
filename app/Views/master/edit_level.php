<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container text-center">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_level" method="post">
                            <h1 class="mt-4">Ubah Data Level</h1>
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
                                    <div class="mb-3 row">
                                        <input type="hidden" value="<?= $level['id_level']; ?>" name="id_level">
                                        <div class="mb-3 row">
                                            <label for="jilid" class="col-sm-2 col-form-label">Jilid</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Jilid" name="jilid" id="jilid" class="form-control" value="<?= old('jilid') ?: $level['jilid']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="materi" class="col-sm-2 col-form-label">Materi</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Materi" name="materi" id="materi" class="form-control" value="<?= old('materi') ?: $level['materi']; ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="level" class="col-sm-2 col-form-label">Level</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Level" name="level" id="level" class="form-control" value="<?= old('level') ?: substr($level['level'], 1); ?>">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="tema" class="col-sm-2 col-form-label">Tema</label>
                                            <div class="col-sm-10">
                                                <input type="text" placeholder="Tema" name="tema" id="tema" class="form-control" value="<?= old('tema') ?: $level['tema']; ?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="d-grid gap-2 d-md-block">
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