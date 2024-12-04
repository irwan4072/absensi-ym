<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="container">
                <div class="row">
                    <div class="col align-self-center">
                        <form action="/admin/simpan_sanggar" method="post">
                            <h1 class="mt-4">Ubah Data Sanggar</h1>
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
                                    <input type="hidden" name="id_sanggar" value="<?= $sanggar['id_sanggar']; ?>">
                                    <div class="mb-3 row">
                                        <label for="sanggar" class="col-sm-2 col-form-label">Nama Sanggar</label>
                                        <div class="col-sm-10">
                                            <input type="text" placeholder="Nama Sanggar" name="sanggar" id="sanggar" class="form-control" value="<?= $sanggar['sanggar']; ?>">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label for="alamat_sanggar" class="col-sm-2 col-form-label">Alamat Sanggar</label>
                                        <div class="col-sm-10">
                                            <input class="form-control" type="text" placeholder="Alamat sanggar" name="alamat_sanggar" id="alamat_sanggar" aria-label="default input example" value="<?= $sanggar['alamat_sanggar']; ?>">
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