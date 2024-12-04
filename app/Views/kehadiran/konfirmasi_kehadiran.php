<?= $this->extend('templates/home_template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h1 class="mt-3">Konfirmasi Kehadiran</h1>
            <form action="/kehadiran/simpan_kehadiran" method="post">
                <?= csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahKehadiranLabel">Kehadiran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col" class="text-center">Kehadiran</th>
                                <th scope="col" class="text-center">Level Meningkat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php $a = 0; ?>
                            <?php foreach ($siswa as $a => $sis) : ?>
                                <tr>
                                    <th scope="row"><?= $i++; ?></th>
                                    <td><?= $sis['nama_siswa']; ?></td>
                                    <input type="hidden" value="<?= $sis['id_siswa']; ?>" name="idSiswa[]">
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kehadiran[<?= $a; ?>]" id="inlineRadio1" value="hadir" required <?= in_array($sis['id_siswa'], array_column($kehadiran_sementara, 'id_siswa')) ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="inlineRadio1">Hadir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kehadiran[<?= $a; ?>]" id="inlineRadio2" value="izin" required>
                                            <label class="form-check-label" for="inlineRadio2">Izin</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kehadiran[<?= $a; ?>]" id="inlineRadio3" value="sakit" required>
                                            <label class="form-check-label" for="inlineRadio3">Sakit</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="kehadiran[<?= $a; ?>]" id="inlineRadio4" value="alfa" required <?= in_array($sis['id_siswa'], array_column($kehadiran_sementara, 'id_siswa')) ? '' : 'checked' ?>>
                                            <label class="form-check-label" for="inlineRadio4">Alfa</label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <input class="form-check-input" type="checkbox" id="checkboxNoLabel" value="" aria-label="..." name="naikLevel[<?= $a; ?>]" <?= in_array($sis['id_siswa'], array_column($kehadiran_sementara, 'id_siswa')) ? 'checked' : '' ?>>
                                        </div>
                                    </td>
                                </tr>
                                <?php $a++ ?>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button> -->
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>