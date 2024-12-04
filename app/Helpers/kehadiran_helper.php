<?php

function kehadiran($id_siswa)
{
    $db = db_connect();
    $hadir = $db->table('kehadiran')->getWhere(['id_siswa' => $id_siswa])->getResultArray();


    return $hadir;
}
function cari_hadir($table, $fields, $id)
{
    $db = db_connect();
    $hadir = $db->table($table)->getWhere([$fields => $id])->getResultArray();


    return $hadir;
}
function nama_bulan($index)
{
    $bln = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];
    return $bln[$index];
}
function jarak_waktu($waktu)
{
    $thnBln = explode('-', $waktu);
    $bulanSebelum = intval($thnBln[1]) - 1;
    if ($bulanSebelum == 0) {
        $thnBln[0] -= 1;
        $bulanSebelum = 12;
    }
    $jarak = implode('-', [$thnBln[0], $bulanSebelum]) . '-20';
    // dd($jarak);
    return $jarak;
}
