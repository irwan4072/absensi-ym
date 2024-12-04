<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Master User</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form action="user" method="post">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahUser">
                                Tambah User
                            </button>

                        </form>
                    </div>
                    <?php if (session()->getFlashdata('pesan')) : ?>
                        <div class="card mb-4 alert alert-<?= session()->getFlashdata('warna'); ?>">
                            <div class="card-body">
                                <?= session()->getFlashdata('pesan'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Daftar User
                        </div>
                        <div class="card-body" id="user">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id User</th>
                                        <th>Nama</th>
                                        <th>JK</th>
                                        <th>Alamat</th>
                                        <th>No Telp</th>
                                        <th>Level</th>
                                        <th>Terdaftar</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($user as $s) : ?>
                                        <tr>
                                            <td><?= $s['id']; ?></td>
                                            <td><?= $s['nama']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['alamat']; ?></td>
                                            <td><?= $s['telp']; ?></td>
                                            <td><?= $s['level']; ?></td>
                                            <td><?= $s['created_at']; ?></td>
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
            <form action="/admin/simpan_User" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahUserLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input class="form-control mb-1" type="text" placeholder="Nama" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Kelas" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Alamat" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Telp" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Jenis Kelamin" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Status" aria-label="default input example">
                    <input class="form-control mb-1" type="text" placeholder="Level" aria-label="default input example">
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