<?php

use app\models\Mahasiswa;
use app\models\Nilai;
use dosamigos\chartjs\ChartJs;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model app\models\nilai */
/* @var $form ActiveForm */
?>
<div class="nilai-proses_fcm">


    <p>
        <code><?= __FILE__; ?></code>.
    </p>

</div><!-- nilai-proses_fcm -->

<?php

$data = array(
    array(70, 89, 80, 85, 78, 98, 76, 80, 90, 32),
    array(89, 76, 80, 85, 78, 98, 76, 80, 90, 59),
    array(87, 75, 80, 85, 78, 98, 76, 80, 90, 78),
    array(75, 82, 80, 85, 78, 98, 76, 80, 90, 98),
    array(77, 62, 80, 85, 78, 98, 76, 80, 90, 78),
    array(76, 92, 80, 85, 78, 98, 76, 80, 90, 89),
    array(78, 72, 80, 85, 78, 98, 76, 80, 90, 76),
    array(89, 82, 80, 85, 78, 98, 76, 80, 90, 87),
    array(98, 92, 80, 85, 78, 98, 76, 80, 90, 69),
    array(78, 52, 80, 85, 78, 98, 76, 80, 90, 98), 
);

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
<!-- Table goes in the document BODY -->
<!-- <h4>Data Awal -> Dari Array Statis , Bukan Dari Database</h4>
<h4>Data Awal -> Matrix [10][10]</h4>
<h4>Cluster -> 2</h4>
<h4>Max Iterasi -> 1000</h4>
<h4>Min -> 0.0001</h4> -->
<!-- <label>Jumlah Kluster</label><?= Html::textInput('kluster', $value = "2", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?>
<label>Maksimal Iterasi</label><?= Html::textInput('max_iterasi', $value = "10000", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?>
<label>Minimal Error</label><?= Html::textInput('min_error', $value = "0.00001", $options = ['class' => 'form-control', 'maxlength' => 10, 'style' => 'width:350px']) ?> -->



<?php
$s = (int) Html::getAttributeName('tes');
$clusterizer = new CMeansClusterizer(
    $result,
    // $result,
    2,
    10000,
    2,
    0.0001
);
print("<pre><h4>Data Nilai Mahasiswa</h4></pre>");

$dataProvider = new ActiveDataProvider([
    'query' => Nilai::find(),
    'pagination' => [
        'pageSize' => 10,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
]);



$datafix = $clusterizer->clusterize();
// print("<pre>" . print_r($result, true) . "</pre>");
print("<pre><h4>Data HASIL <i>Clustering </i> Menggunakan Metode <i>Fuzzy C-Means</i></h4></pre>");

$data1 = array();
$data2 = array();

print_r($datafix);

?>



<table style="width: 100%; text-align: center;" border="1">
    <tbody>
        <tr>
            <td colspan="4">Warna Hijau </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td>NIM</td>
            <td>C1</td>
            <td>C2</td>
        </tr>
        <?php

        foreach ($datafix as $key => $value) {
            foreach ($value as $key => $nilai) {

                $mhs = Mahasiswa::findOne(['nim' => $key]);
                $color1 = $nilai[0] > $nilai[1] ? 'green'  : 'grey';
                $color2 = $nilai[1] > $nilai[0] ? 'green'  : 'grey';

                // $data1 = array_push($data1, $nilai[0]);
                // $data2 = array_push($data2, $nilai[1]);

                echo 
                '
                <tr>
                    <td>' . $mhs['nama'] . '</td>
                    <td > ' . $key . '</td>
                    <td bgcolor="' . $color1 . '"> ' . $nilai[0] . '</td>
                    <td bgcolor="' . $color2 . '"> ' . $nilai[1] . '</td>
                </tr>
                ';
                ?>
        <?php
            }
        }
        ?>
    </tbody>
</table>

<?php
// $x1 = sizeOf($data1[0]);
// $x2 = sizeOf($nilai[1]);
$label =  ["C1", "C2"];
$color =  ['#512c62', '#c93838'];
$datahasilmining =  [$data1, $data2];
?>

<div class="row">
    <div class="col-md-8">
        <?= ChartJs::widget([
            'type' => 'pie',
            'options' => [
                'height' => 20,
                'width' => 20,
            ],
            'data' => [

                'labels' => $label,
                'datasets' => [
                    [
                        'data' => $datahasilmining, // Your dataset
                        'label' => "FCM Mining",
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
</div>
<!-- 
<pre>Problem
<p>Setelah nilai perhitungan diatas didapatkan , Bagaimana Cara Menentukan nilai tersebut masuk ke dalam cluster yang mana nya  </p>
<p>Diexcel & di Proposal hanya ada sampai tahap seperti diatas<p>
</pre> -->

<!-- <table class="gridtable" width="100%">
<tr>
    <th>No</th>
    <th>X1</th>
    <th>X2</th>
    <th>X3</th>
    <th>X4</th>
    <th>X5</th>
    <th>X6</th>
    <th>X7</th>
    <th>X8</th>
    <th>X9</th>
    <th>X10</th>
</tr>

<tr>
    
</tr>
<tr>

</table> -->
<?php
function getData($categoryArray, $key)
{
    foreach ($categoryArray as $k => $value) {
        if ($k == $key) return $value;
        if (is_array($value)) {
            $find = getData($value, $key);
            if ($find) {
                return $find;
            }
        }
    }
    return null;
}

class CMeansClusterizer
{
    public function __construct($data, $n_clusters, $n_iterations, $fuzziness, $min_error)
    {
        $this->data = $data;
        $this->n_clusters = $n_clusters;
        $this->n_iterations = $n_iterations;
        $this->fuzziness = $fuzziness;
        $this->min_error = $min_error;
        $this->initialize();
    }
    private function initialize()
    {
        $this->features = array_keys(reset($this->data));
        $this->membership_degrees = [];
        foreach ($this->data as $key => $value) {
            $this->membership_degrees[$key] = [];
            for ($i = 0; $i < $this->n_clusters; ++$i) {
                $this->membership_degrees[$key][$i] = rand(0, 10) / 10;
            }
        }
    }
    private function compute_centroids()
    {
        for ($i = 0; $i < $this->n_clusters; $i++) {
            foreach ($this->features as $feature) {
                $num = 0;
                $den = 0;
                foreach ($this->membership_degrees as $key => $membership_degree) {
                    $num += pow($membership_degree[$i], $this->fuzziness) * $this->data[$key][$feature];
                    $den += pow($membership_degree[$i], $this->fuzziness);
                }
                $this->centroids[$i][$feature] = $num / $den;
            }
        }
    }
    private function distance($vec_a, $vec_b, $keys)
    {
        $total = 0;
        foreach ($keys as $key) {
            $total += pow($vec_a[$key] - $vec_b[$key], 2);
        }
        return sqrt($total);
    }
    private function update_membership_degrees()
    {
        foreach ($this->membership_degrees as $key => $membership_degree) {
            for ($i = 0; $i < $this->n_clusters; $i++) {
                $total = 0.0;
                for ($j = 0; $j < $this->n_clusters; $j++) {

                    $total += pow(
                        $this->distance($this->data[$key], $this->centroids[$i], $this->features) /
                            $this->distance($this->data[$key], $this->centroids[$j], $this->features),
                        2.0 / ($this->fuzziness - 1.0)
                    );
                }
                $this->membership_degrees[$key][$i] = 1.0 / $total;
            }
        }
    }
    public function clusterize()
    {
        for ($i = 0; $i < $this->n_iterations; ++$i) {

            $this->compute_centroids();
            $this->update_membership_degrees();
        }
        // OFF ON
        // return ["centroids" => $this->centroids, "membership_degrees" => $this->membership_degrees];
        return ["membership_degrees" => $this->membership_degrees];
    }
}

?>


<style type="text/css">
    table.gridtable {
        font-family: verdana, arial, sans-serif;
        font-size: 11px;
        color: #333333;
        border-width: 1px;
        border-color: #666666;
        border-collapse: collapse;
    }

    table.gridtable th {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #dedede;
    }

    table.gridtable td {
        border-width: 1px;
        padding: 8px;
        border-style: solid;
        border-color: #666666;
        background-color: #ffffff;
    }
</style>