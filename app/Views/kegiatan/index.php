<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col">


            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Daftar Peserta Kegiatan</h1>
                    <div class="d-grid gap-2 d-md-block mb-3">
                        <form class="row row-cols-lg-auto g-3 align-items-center form-inline">
                            <div class="form-group">
                                <select class="form-select" aria-label="Default select example" name="id_kegiatan" id="id_kegiatan">
                                    <!-- <option selected>Kegiatan Terdekat</option> -->
                                    <?php if (count($kegiatan) == 0) : ?>
                                        <option value="" selected> Pilih Kegiatan</option>
                                    <?php endif ?>
                                    <?php foreach ($kegiatan as $k) : ?>
                                        <option value="<?= $k['id_kegiatan']; ?>" <?= ($k['id_kegiatan'] == $kegiatanAktif) ? 'selected' : '' ?>><?= $k['nama_kegiatan']; ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pesertaModal" data-value=""> -->
                                <button type="button" class="btn btn-primary" id="pesertaModal" data-value="<?= $id_kegiatan; ?>" <?= (count($kegiatan) == 0) ? 'disabled' : ''; ?>>
                                    Daftarkan siswa
                                </button>
                            </div>
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
                            Daftar Peserta Kegiatan
                        </div>
                        <div class="card-body" id="user">
                            <table id="datatablesSimple" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Sanggar</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $i = 1 ?>
                                    <?php foreach ($peserta as $s) : ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $s['nama_siswa']; ?></td>
                                            <td><?= $s['jenis_kelamin']; ?></td>
                                            <td><?= $s['alamat_siswa']; ?></td>
                                            <td><?= $s['telp_siswa']; ?></td>
                                            <td><?= $s['sanggar']; ?></td>
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

<div class="modal fade" id="pesertaModalView" tabindex="-1" aria-labelledby="pesertaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/kegiatan/simpan_pesertaKegiatan" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="pesertaModalLabel">Daftarkan Siswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama Siswa</th>
                                <th scope="col">level</th>
                                <th scope="col">Jumlah kehadiran</th>
                                <th scope="col">Pilih</th>
                            </tr>
                        </thead>
                        <tbody>
                            <input type="hidden" name="id_kegiatanModal" id="id_kegiatanModal">
                            <?php $i = 1 ?>
                            <?php foreach ($siswa as $sis) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $sis['nama_siswa']; ?></td>
                                    <td><?= $sis['level']; ?></td>
                                    <td><?= $sis['jumlah_kehadiran']; ?></td>
                                    <td>
                                        <div>

                                            <input class="form-check-input" type="checkbox" name="id_siswa[<?= $i++; ?>]" id="id_siswa" value="<?= $sis['id_siswa']; ?>" aria-label="...">
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {

        $('#pesertaModal').click(function() {
            var id = $(this).data('value');
            // console.log(id);
            $('#id_kegiatanModal').val(id);
            $('#pesertaModalView').modal('show');
            // console.log(minuman);
        });
        $('#id_kegiatan').change(function() {
            var selectedValue = $(this).val();
            console.log(selectedValue);

            window.location.href = '/kegiatan/pengalihanSementara/' + selectedValue;
        });
    });


    // 
</script>
<?= $this->endSection(); ?>