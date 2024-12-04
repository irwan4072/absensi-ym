<?php

namespace App\Controllers;

use \App\Models\userModel;
use App\Models\SiswaModel;
use App\Models\KehadiranModel;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Reader\Word2007 as ReaderWord2007;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Writer\Word2007;

class Laporan extends BaseController
{
    protected $siswa;
    protected $user;
    protected $kehadiran;
    protected $session;

    public function __construct()
    {
        $this->siswa = new SiswaModel();
        $this->user = new userModel();
        $this->kehadiran = new KehadiranModel();
        $this->session = \Config\Services::session();
        helper('App\Helpers\kehadiran');
    }
    public function index()
    {
        session();
        $siswa = $this->siswa->findAll();
        $kehadiran = $this->kehadiran->findAll();
        // dd($siswa);

        $data = [
            'title' => 'YM | Kehadiran',
            'siswa' => $siswa,
            'kehadiran' => $kehadiran,


        ];

        return view('/kehadiran/laporan', $data);
    }

    public function word()
    {
        require_once 'vendor/autoload.php';

        $db = \Config\Database::connect();
        // $bln = $_GET['bulan'];
        // $thn = $_GET['tahun'];
        // $blnThn = (string)$thn . '-' . $bln;
        // dd(date('d'));
        $tgl = $this->request->getVar('tgl');

        $str = explode('-', $tgl);
        $thn = $str[0];
        $bln = $str[1];
        $tanggal = [];


        $siswa = $this->siswa->where('id_cabang', 1)->get()->getResultArray();
        // $kehadiran = $db->table('kehadiran')->like('tanggal', $tgl . '%')->get()->getResultArray();
        $bulanSkrg = $tgl . '-25';
        $bulanLalu = jarak_waktu($tgl);
        $siswa = $this->siswa->findAll();
        $query = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg')";
        // $kehadiran = $this->kehadiran->findAll();
        $kehadiran = $db->query($query)->getResultArray();

        // dd($kehadiran);

        $cabang = $db->table('cabang')->where('id', 1)->get()->getResultArray()[0];
        $guru = $db->table('user')->where('id_cabang', 1)->get()->getResultArray()[0];



        for ($i = 0; $i < count($kehadiran); $i++) {
            $tgl = substr($kehadiran[$i]['tanggal'], 8);
            if (is_bool(array_search($tgl, $tanggal)) == true) {
                $tanggal[] = intval($tgl);
            }

            $i++;
        }
        // dd($tanggal);



        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $template = new \PhpOffice\PhpWord\TemplateProcessor('assets/document/laporan.docx');


        // $styleTable = ['borderSize' => 6, 'borderColor' => '999999'];

        $section = $phpWord->addSection();
        $table = $section->addTable('Colspan Rowspan');
        $styleTable = [
            'borderTopColor' => '000000',
            'borderTopSize'  => 10,
            'borderRightColor' => '000000',
            'borderRightSize'  => 10,
            'borderBottomColor' => '000000',
            'borderBottomSize'  => 10,
            'borderLeftColor' => '000000',
            'borderLeftSize'  => 10,
            'cellMargin'  => 50,

        ];
        $phpWord->addTableStyle('Colspan Rowspan', $styleTable);
        $tengah = \PhpOffice\PhpWord\SimpleType\Jc::CENTER;

        // $table = new Table(array('borderSize' => 12, 'borderColor' => 'green', 'width' => 6000, 'unit' => TblWidth::TWIP));
        // $table->addRow('', array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable));
        $table->addRow();
        $table->addCell(600, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('NO', [], ['alignment' => $tengah]);
        $table->addCell(3000, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('NAMA ANAK');
        $table->addCell(600, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('L/P');
        $table->addCell(600, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('KELAS');
        $table->addCell(600, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('Y/NY');
        $table->addCell(1000, array_merge(['gridSpan' => count($tanggal), 'valign' => 'center', 'alignment' => 'center'], $styleTable))->addText('LAPORAN PERKEMBANGAN BULAN ' . strtoupper(nama_bulan($bln)), [], ['alignment' => $tengah]);
        $table->addCell(1000, array_merge(['vMerge' => 'restart', 'valign' => 'center'], $styleTable))->addText('Total Masuk', [], ['alignment' => $tengah]);

        $table->addRow();
        $table->addCell(600, array_merge(['vMerge' => 'continue'], $styleTable));
        $table->addCell(600, array_merge(['vMerge' => 'continue'], $styleTable));
        $table->addCell(600, array_merge(['vMerge' => 'continue'], $styleTable));
        $table->addCell(600, array_merge(['vMerge' => 'continue'], $styleTable));
        $table->addCell(600, array_merge(['vMerge' => 'continue'], $styleTable));
        for ($i = 0; $i < count($tanggal); $i++) {
            $table->addCell(1000, $styleTable)->addText("tgl : " . $tanggal[$i]);
        }
        $table->addCell(1000, array_merge(['vMerge' => 'continue'], $styleTable));

        $i = 0;
        $x = 1;
        $y = 0;
        $ny = 0;
        foreach ($siswa as $sis) {
            // dd($sis);
            $masuk = 0;
            $j = 0;
            $table->addRow();
            $table->addCell(600, $styleTable)->addText($x, [], ['alignment' => $tengah]);
            $table->addCell(600, $styleTable)->addText($sis['nama_siswa']);
            $table->addCell(600, $styleTable)->addText(substr($sis['jenis_kelamin'], 0, 1), [], ['alignment' => $tengah]);
            $table->addCell(600, $styleTable)->addText($sis['kelas'], [], ['alignment' => $tengah]);
            if ($sis['status'] == "Yatim") {
                $status = "Y";
                $y += 1;
            } else {
                $status = "NY";
                $ny += 1;
            }
            $table->addCell(600, $styleTable)->addText($status, [], ['alignment' => $tengah]);

            $id = $sis['id'];
            $query = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND (id_siswa = '$id')";
            // $kehadiran = $this->kehadiran->findAll();
            $kehadiran = $db->query($query)->getResultArray();
            // dd($kehadiran);
            for ($i = 0; $i < count($tanggal); $i++) {

                if (isset($kehadiran[$i]['kehadiran'])) {
                    if ($kehadiran[$i]['kehadiran'] == 'hadir') {
                        $table->addCell(800, $styleTable)->addText(strtoupper($kehadiran[$i]['level_hadir']), [], ['alignment' => $tengah]);
                        // $hadir = $kehadiran['level_hadir'];
                        $masuk += 1;
                    } elseif ($kehadiran[$i]['kehadiran'] == 'alfa') {
                        $table->addCell(800, ['bgColor' => '000000'], $styleTable)->addText(strtoupper(substr($kehadiran[$i]['kehadiran'], 0, 1)), [], ['alignment' => $tengah, 'color' => 'FFFFFF']);
                    } elseif ($kehadiran[$i]['kehadiran'] == 'izin' || $kehadiran[$i]['kehadiran'] == 'sakit') {
                        $table->addCell(800, ['bgColor' => '00BFFF'], $styleTable)->addText(strtoupper(substr($kehadiran[$i]['kehadiran'], 0, 1)), [], ['alignment' => $tengah]);
                    } else {
                        $table->addCell(800, $styleTable)->addText('', [], ['alignment' => $tengah]);
                        // $hadir = substr($kehadiran['kehadiran'], 0, 1);
                    }
                } else {

                    $table->addCell(800, $styleTable)->addText('', [], ['alignment' => $tengah]);
                }
                // $table->addCell(800, $styleTable)->addText($hadir, [], ['alignment' => $tengah]);

            }


            if ($masuk > 5) {
                $table->addCell(1000, $styleTable)->addText($masuk, [], ['alignment' => $tengah]);
            } else {

                $table->addCell(1000, ['bgColor' => '000000'], $styleTable)->addText($masuk, [], ['alignment' => $tengah, 'color' => 'FFFFFF']);
            }
            $x++;
        }

        $phpWord->addTitleStyle(1, ['size' => 14, 'bold' => true], ['keepNext' => true, 'spaceBefore' => 240]);
        $phpWord->addTitleStyle(2, ['size' => 14, 'bold' => true], ['keepNext' => true, 'spaceBefore' => 240]);

        // 2D charts
        $section2 = $phpWord->addSection();

        $categories = $tanggal;



        // coba
        $showAxisLabels = true;
        $showLegend = true;
        $legendPosition = 'b';
        $dataLabel = [];
        $style = [
            "color" => '#FFD701',
            "color" => '#FFD700',
            "color" => '#F1D700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700',
            "color" => '#FFD700'
        ];
        $section2->addTitle('ok');
        $section2->addChartStyle([
            // 'legend' => 'false',
            'pageSizeH' => Converter::inchToEmu(6),
            "color" => '#FFD700',
        ],);
        $i = 0;
        $color = [];
        foreach ($siswa as $key => $value) {
            $id = $value['id'];
            $query = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND (id_siswa = '$id')";
            // $kehadiran = $this->kehadiran->findAll();
            $kehadiran = $db->query($query)->getResultArray();
            // dd($kehadiran);
            $series = [];
            for ($i = 0; $i < count($tanggal); $i++) {
                if (isset($kehadiran[$i]['kehadiran'])) {
                    if ($kehadiran[$i]['kehadiran'] == 'hadir') {
                        $index = $kehadiran[$i]['level_hadir'];
                        $lvl = $db->table('level')->select('id')->getWhere(['level' => $index])->getResultArray()[0];
                        $series[] = $lvl['id'];
                    } else {
                        $series[] = 0;
                    }
                } else {
                    $series[] = 0;
                }
            }
            if ($key == 0) {

                $chart = $section2->addChart('bar', $categories, $series, $style, $value['nama_siswa']);
                $chart->getStyle()->showGridX(true);
                $chart->getStyle()->showGridY(true, Converter::inchToEmu(8));
                $chart->getStyle()->setWidth(Converter::inchToEmu(8))->setHeight(Converter::inchToEmu(4));

                $chart->getStyle()->setShowAxisLabels($showAxisLabels);
                $chart->getStyle()->setAuto(false);
            } else {
                $chart->addSeries($categories, $series, $value['nama_siswa']);
                // $color[] = '0000FF';
                // for ($i = 0; $i < 6; $i++) {
                //     $warnaRand = '';
                //     $rand = rand(0, 10);
                //     $warnaRand .= $rand;
                // }
                // $chart->getStyle()->setColors($warnaRand);
            }
            // $dataLabel[] = $series;
            // d($key);
            // $i++;
        }
        // $section2->addTextBreak(50);
        // die;

        // $chart->getStyle()->setColors($color);
        $chart->getStyle()->setDataLabelOptions([
            'showVal' => true,
            'showCatName' => false,
            'showLegendKey' => false,
            'showSerName' => false
        ]);
        // $chart->getStyle()->setShowLegend($showLegend);
        // $chart->getStyle()->setLegendPosition($legendPosition);




        //akhircoba

        // $showAxisLabels = true;
        // $showLegend = true;
        // $legendPosition = 'b';
        // $dataLabel = [];
        // // $id = $s[1];
        // $section2->addTitle('ok');
        // $section2->addChartStyle([
        //     // 'legend' => 'false',
        //     'pageSizeH' => Converter::inchToEmu(6),
        // ],);
        // $i = 0;
        // $color = [];
        // foreach ($siswa as $key => $value) {
        //     $id = $value['id'];
        //     $query = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND (id_siswa = '$id')";
        //     // $kehadiran = $this->kehadiran->findAll();
        //     $kehadiran = $db->query($query)->getResultArray();
        //     // dd($kehadiran);
        //     $series = [];
        //     for ($i = 0; $i < count($tanggal); $i++) {
        //         if (isset($kehadiran[$i]['kehadiran'])) {
        //             if ($kehadiran[$i]['kehadiran'] == 'hadir') {
        //                 $index = $kehadiran[$i]['level_hadir'];
        //                 $lvl = $db->table('level')->select('id')->getWhere(['level' => $index])->getResultArray()[0];
        //                 $series[] = $lvl['id'];
        //             } else {
        //                 $series[] = 0;
        //             }
        //         } else {
        //             $series[] = 0;
        //         }
        //     }
        //     if ($key == 0) {

        //         $chart = $section2->addChart('line', $categories, $series, '', $value['nama_siswa']);
        //         // $dataLabel[] = $series;
        //         $chart->getStyle()->showGridX(false);
        //         $chart->getStyle()->showGridY(false);
        //         // $chart->getStyle()->setColors(['0000FF']);
        //         $chart->getStyle()->setWidth(Converter::inchToEmu(8))->setHeight(Converter::inchToEmu(4));
        //         // $chart->getStyle()->getLegendOverlay();
        //         // $color[] = '0000FF';
        //         $chart->getStyle()->setColors('#0000FF');

        //         $chart->getStyle()->setShowAxisLabels($showAxisLabels);
        //         // $chart->getStyle()->legendOverlay();
        //         $chart->getStyle()->setAuto(false);
        //         // $chart->getStyle()->setTitle(strtoupper('Grafik Kemajuan Siswa'));
        //         // $chart->getStyle()->setTitle(strtoupper('Grafik Kemajuan Siswa Yatim mandiri cabang ' . $cabang['kecamatan']));

        //         // $section3 = $phpWord->addSection();
        //         // $chartLegend = $section3->getStyle->setShowLegend($showLegend);
        //         // $chart->getStyle()->setShowLegend($showLegend);
        //         // $chart->getStyle()->setLegendPosition($legendPosition);
        //         // $chartLegend->getStyle()->setLegendPosition($legendPosition);
        //         // d($value);
        //     } else {
        //         $chart->addSeries($categories, $series, $value['nama_siswa']);
        //         // $color[] = '0000FF';
        //         $chart->getStyle()->setColors('#0000FF');
        //     }
        //     $dataLabel[] = $series;
        //     // d($key);
        //     $i++;
        // }
        // // $section2->addTextBreak(50);

        // // $chart->getStyle()->setColors($color);
        // $chart->getStyle()->setDataLabelOptions([
        //     'showVal' => true,
        //     'showCatName' => false,
        //     'showLegendKey' => false,
        //     'showSerName' => false
        // ]);
        // $chart->getStyle()->setShowLegend($showLegend);
        // $chart->getStyle()->setLegendPosition($legendPosition);
        // echo 'ok';
        // die;
        // dd($dataLabel);


        // $chart->addSeries($categories, $series2);
        // $chart->addSeries($categories, $series3);
        // $chart->addSeries($categories, $series4);
        // $chart->addSeries($categories, $series5,);

        // $j = 0;

        // foreach ($siswa as $sis) {
        //     $id = $sis['id'];
        //     $query = "SELECT * FROM kehadiran WHERE (tanggal > '$bulanLalu' AND tanggal < '$bulanSkrg') AND (id_siswa = '$id')";
        //     // $kehadiran = $this->kehadiran->findAll();
        //     $kehadiran = $db->query($query)->getResultArray();
        //     // dd($kehadiran);
        //     $series = [];
        //     if (condition) {
        //         # code...
        //     }
        //     // continue;

        //     for ($i = 0; $i < count($tanggal); $i++) {
        //         if (isset($kehadiran[$i]['kehadiran'])) {
        //             if ($kehadiran[$i]['kehadiran'] == 'hadir') {
        //                 $index = $kehadiran[$i]['level_hadir'];
        //                 $lvl = $db->table('level')->select('id')->getWhere(['level' => $index])->getResultArray()[0];
        //                 $series[] = $lvl['id'];
        //             } else {
        //                 $series[] = 0;
        //             }
        //         } else {
        //             $series[] = 0;
        //         }
        //         $j++;
        //     }

        //     // d($series);
        //     // $serie =
        //     // $chart->getStyle()->setValueAxisTitle();
        //     $chart->addSeries($categories, $series, $sis['nama_siswa']);
        // }
        // if (in_array($chartType, $threeSeries)) {
        //     $chart->addSeries($categories, $series3);
        // }
        // $section2->addTextBreak();
        // }

        // die;







        // $j++;
        // if ($k == 0) {

        //     $chart = $section2->addChart('line', $categories, $series);
        //     $chart->getStyle()->showGridX(true);
        //     $chart->getStyle()->showGridY(true);
        //     $chart->getStyle()->setWidth(Converter::inchToEmu(2.5))->setHeight(Converter::inchToEmu(2));
        // } else {
        //     $chart->addSeries($categories, $series);
        // }
        // $k++;
        // dd($series);
        // die;


        // $series1 = [1, 3, 2, 5, 4];
        // $series2 = [3, 1, 7, 2, 6];
        // $series3 = [8, 3, 2, 5, 4];
        // $chart = $section2->addChart('line', $categories, $series1);
        // $chart->getStyle()->showGridX(false);
        // $chart->getStyle()->showGridY(false);
        // $chart->getStyle()->setWidth(Converter::inchToEmu(2.5))->setHeight(Converter::inchToEmu(2));
        // // $chart->addSeries($categories, $series1);
        // $chart->addSeries($categories, $series2);
        // $chart->addSeries($categories, $series3);


        $tanggal_lengkap = (date('d') . ' ' . nama_bulan($bln) . ' ' . $thn);
        // dd($guru);

        $template->setValue('status', " $y Yatim, $ny Non Yatim");
        $template->setValue('tahun', $thn);
        $template->setValue('guru', $guru['nama']);
        $template->setValue('cabang_kota', strtoupper($cabang['kota']));
        $template->setValue('cabang_kecamatan', $cabang['kecamatan']);
        $template->setValue('alamat_sanggar', 'kp. Kadu Sabrang Rt 002/002');
        $template->setValue('tanggal_lengkap', $tanggal_lengkap);
        $template->setComplexBlock('database', $table);
        $template->setChart('chart', $chart);


        // $writer = new \PhpOffice\PhpWord\IOFactory::createWriter($template, 'word-2007');
        // $writer->saveAs('coba.docx');
        // $template = new Word2007;
        $filename = "coba.docx";

        // $pathToSave = "assets/coba/" . $filename;
        // $template->saveAs($pathToSave, $filename);
        // die;
        // 
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=" . $filename);
        header("Cache-Control: max-age-0");

        $template->saveAs("php://output");
    }
}
