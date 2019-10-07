<?php

use app\models\Mahasiswa;
use app\models\Nilai;
use dosamigos\chartjs\ChartJs;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cluster */

print("<pre>Proses Cluster Fuzzy & C-Means dengan data dan Nilai Bobot awal dinamis</pre>");

$nilai = Nilai::find()
    ->select('nim, nilai')
    // ->where(['nim'=>11351105880])
    ->asArray()
    ->all();
?>

<?php
$result = array();
$a = 0;
foreach ($nilai as $element) {
    $result[$element['nim']][] = $element['nilai'];
}
?>

<!-- <label>Jumlah Kluster</label><?= Html::textInput('kluster', $value = "2", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?>
<label>Maksimal Iterasi</label><?= Html::textInput('max_iterasi', $value = "10000", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?>
<label>Minimal Error</label><?= Html::textInput('min_error', $value = "0.00001", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?> -->



<?php

print("<pre><h4>Data Nilai Mahasiswa</h4></pre>");

$dataProvider = new ActiveDataProvider([
    'query' => Nilai::find()->limit(580),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
// echo GridView::widget([
//     'dataProvider' => $dataProvider,
// ]);

$size = sizeof($data[6]);
$mhs = Mahasiswa::find()
    ->select('nama,nim')
    // ->where(['nim'=>11351105880])
    ->asArray()
    ->all();

$result_mhs = array();
foreach ($mhs as $key => $element) {
    $result_mhs[$key] = $element['nama'];
}
$result_nim = array();
foreach ($mhs as $key => $element) {
    $result_nim[$key] = $element['nim'];
}
// print_r($result_mhs);

?>
<div class="row">
    <table style="width: 100%; text-align: center;" border="1">
        <tbody>
            <tr>
                <td colspan="5">Warna Hijau Merepresentasikan Nilai Tersebut Masuk kedalam Kolum Klusternya</td>
            </tr>
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Nim</td>
                <td>C1</td>
                <td>C2</td>
            </tr>

            <?php
            $c1 = 0;
            $c2 = 0;

            for ($i = 0; $i < $size; $i++) {

                if ($data[7][$i] > $data[8][$i]) {
                    $c1++;
                } else {
                    $c2++;
                }

                $color1 = $data[7][$i] > $data[8][$i] ? 'green'  : 'white';
                $color2 = $data[7][$i] < $data[8][$i] ? 'grey'  : 'white';


                echo
                    '
                    <tr>
                    <td > ' . ($i + 1) . '</td>
                    <td >' . $result_mhs[$i] . ' </td>
                    <td >' . $result_nim[$i] . ' </td>
                    <td bgcolor="' . $color1 . '"> ' . $data[7][$i] . '</td>
                    <td bgcolor="' . $color2 . '"> ' . $data[8][$i] . '</td>
                       
                    </tr>
                    ';
                ?>
            <?php

            }
            $color =  ['green', 'amber' ];
            ?>

        </tbody>
    </table>
</div>
<br>
<br>
<div class="row">
    <div class="col-lg-3">
    </div>
    <div class="col-lg-4">
        <?= ChartJs::widget([
            'type' => 'pie',
            'options' => [
                'height' => 20,
                'width' => 20,
            ],
            'data' => [

                'labels' => ["Kluster 1 (C1)","Kluster 2 (C2)"],
                'datasets' => [
                    [
                        'data' => [$c1,$c2], // Your dataset
                        'label' => "Grafik Data Perbandingan Kluster 1 dan Kluster 2",
                        'backgroundColor' => $color,
                        'borderColor' =>  [
                            '#fff',
                            '#fff',

                        ],
                        'borderWidth' => 5,
                        'hoverBorderColor' => ["#999", "#999"],
                    ],
                ],
            ]
        ]);
        ?>
    </div>
    <div class="col-lg-3">
    </div>
</div>
<?php


print("<p><pre><h4>Matrix Partisi Awal R1 (Statis) <h4> </pre> ");
print("<p><pre> " . print_r($data[0], true) . "</pre> ");

print("<p><pre><h4>Matrix Partisi Awal R2 (Statis)  <h4> </pre> ");
print("<p><pre> " . print_r($data[1], true) . "</pre> ");

print("<p><pre><h4>Matrix Data (R1)^2  dan Matrix Partisi U / (R(n))^2 dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[2], true) . "</pre> ");

print("<p><pre><h4>Matrix Data (R2)^2  dan Matrix Partisi U / (R(n))^2 dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[3], true) . "</pre> ");

print("<p><pre><h4>Matrix Data Pusat Kluster (V1) dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[4], true) . "</pre> ");

print("<p><pre><h4>Matrix Data Pusat Kluster (V2) dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[5], true) . "</pre> ");

print("<p><pre><h4> Matrix Partisi U1 Baru dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[9], true) . "</pre> ");

print("<p><pre><h4> Matrix Partisi U2 Baru dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[10], true) . "</pre> ");

print("<p><pre><h4>Matrix Data Nilai (P(n)) dari Keseluruhan Iterasi<h4> </pre> ");
print("<p><pre> " . print_r($data[6], true) . "</pre> ");



?>