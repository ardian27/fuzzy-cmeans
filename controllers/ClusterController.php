<?php

namespace app\controllers;

use Yii;
use app\models\Cluster;
use app\models\ClusterSearch;
use app\models\Nilai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;

/**
 * ClusterController implements the CRUD actions for Cluster model.
 */
class ClusterController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Cluster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClusterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single Cluster model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                'title' => "Cluster #" . $id,
                'content' => $this->renderAjax('view', [
                    'model' => $this->findModel($id),
                ]),
                'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                    Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
            ];
        } else {
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }
    public function actionProsesDefault()
    {
        $request = Yii::$app->request;
        $model = new Cluster();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tambah Data Proses Kluster Baru",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {



                return $this->redirect(['detail/index']);
            } else {
                return [
                    'title' => "Tambah Data Kluster",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {

                $max_iterasi = $model->max_iterasi;
                $min_error = $model->min_error;


                $nilai = Nilai::find()
                    ->select('nim, nilai')
                    ->asArray()
                    ->limit(580)
                    ->all();

                $result = array();
                $results = array();
                $a = 0;


                foreach ($nilai as $element) {
                    $result[$element['nim']][] = $element['nilai'];
                }

                $results = array_values($result);
 

                $output =  startFCMStatis($results, $max_iterasi, $min_error);

                 
                $hasil = array();
 
                 
                return $this->render('gas', [
                    'data' => $output,
                ]);
            } else {
                return $this->render('createstatis', [
                    'model' => $model,
                ]);
            }
        }
    }

    public function actionProses()
    {
        $request = Yii::$app->request;
        $model = new Cluster();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tambah Data Proses Kluster Baru",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['detail/index']);
            } else {
                return [
                    'title' => "Tambah Data Kluster",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {

                $max_iterasi = $model->max_iterasi;
                $min_error = $model->min_error;


                $nilai = Nilai::find()
                    ->select('nim, nilai')
                    ->asArray()
                    ->all();

                $result = array();
                $results = array();
                $a = 0;


                foreach ($nilai as $element) {
                    $result[$element['nim']][] = $element['nilai'];
                }

                $results = array_values($result);
 

                $output =  startFCM($results, $max_iterasi, $min_error);

                 
                $hasil = array();

                $data = array(
                    array(100, 100, 100, 100, 100, 98, 100, 99, 90, 82),
                    array(89, 76, 80, 85, 78, 98, 76, 80, 90, 59),
                    array(87, 75, 80, 85, 78, 98, 76, 80, 90, 78),
                    array(75, 82, 80, 85, 78, 98, 76, 80, 90, 98),
                );
                 
                return $this->render('gas2', [
                    'data' => $output,
                ]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Creates a new Cluster model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Cluster();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Tambah Data Proses Kluster Baru",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            } else if ($model->load($request->post()) && $model->save()) {

                $max_iterasi = $model->min_error;
                $jumlah_cluster = $model->jumlah_cluster;
                $min_error = $model->min_error;
                $fuzziness = 2;

                $nilai = Nilai::find()
                    ->select('nim, nilai')
                    ->asArray()
                    ->all();

                $result = array();
                $a = 0;
                foreach ($nilai as $element) {
                    $result[$element['nim']][] = $element['nilai'];
                }


                $clusterizer = new CMeansClusterizer(
                    $result,
                    $jumlah_cluster,
                    $max_iterasi,
                    2,
                    $min_error
                );
                $datafix = $clusterizer->clusterize();

                $id_cluster = Cluster::find()->max('id_cluster');

                $datainsert = array();
                foreach ($datafix as $key => $value) {
                    foreach ($value as $key => $nilai) {
                        $datainsert[] = [
                            'id_cluster' => $id_cluster,
                            'nim' => $key,
                            'hasil' => $nilai[0][1]
                        ];
                    }
                }

                if (count($datainsert) > 0) {
                    $columnNameArray = ['id_cluster', 'nim', 'hasil'];
                    // below line insert all your record and return number of rows inserted
                    $insertCount = Yii::$app->db->createCommand()
                        ->batchInsert(
                            'cluster_detail',
                            $columnNameArray,
                            $datainsert
                        )
                        ->execute();
                }


                return $this->redirect(['detail/index']);
            } else {
                return [
                    'title' => "Tambah Data Kluster",
                    'content' => $this->renderAjax('create', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Simpan', ['class' => 'btn btn-primary', 'type' => "submit"])

                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_cluster]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Cluster model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => "Update Cluster #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            } else if ($model->load($request->post()) && $model->save()) {
                return [
                    'forceReload' => '#crud-datatable-pjax',
                    'title' => "Cluster #" . $id,
                    'content' => $this->renderAjax('view', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote'])
                ];
            } else {
                return [
                    'title' => "Update Cluster #" . $id,
                    'content' => $this->renderAjax('update', [
                        'model' => $model,
                    ]),
                    'footer' => Html::button('Kembali', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) .
                        Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"])
                ];
            }
        } else {
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id_cluster]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing Cluster model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $request = Yii::$app->request;
        $this->findModel($id)->delete();

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceKembali' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    public function actionPanduan()
    {
        
        return $this->render('panduan');
        
    }

    /**
     * Delete multiple existing Cluster model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {
        $request = Yii::$app->request;
        $pks = explode(',', $request->post('pks')); // Array or selected records primary keys
        foreach ($pks as $pk) {
            $model = $this->findModel($pk);
            $model->delete();
        }

        if ($request->isAjax) {
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['forceKembali' => true, 'forceReload' => '#crud-datatable-pjax'];
        } else {
            /*
            *   Process for non-ajax request
            */
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Cluster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cluster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cluster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
function startFCMStatis($data, $max_iterasi, $max_error)
{
    $w = sizeof($data);
    $h = sizeof($data[0]);

    $r1 = array(
        0.753,
        0.671,
        0.286,
        0.893,
        0.822,
        0.742,
        0.170,
        0.098,
        0.881,
        0.151,
        0.308,
        0.463,
        0.822,
        0.252,
        0.455,
        0.586,
        0.237,
        0.468,
        0.431,
        0.734
    );
    $r2 = array(
        0.606,
        0.306,
        0.556,
        0.898,
        0.239,
        0.222,
        0.869,
        0.498,
        0.814,
        0.378,
        0.389,
        0.610,
        0.528,
        0.793,
        0.884,
        0.389,
        0.767,
        0.716,
        0.707,
        0.479
    );
    // Nilai Partisi Awal
    $partisiawalC1 = $r1;
    $partisiawalC2 = $r2;
    //  $partisiawalC1 = getRandom($h);
    //  $partisiawalC2 = getRandom($h);


    $pusat_cluster1 = pusatCluster($data, $partisiawalC1);
    $pusat_cluster2 = pusatCluster($data, $partisiawalC2);

    // Hasil bagi dengan pow2 & nilai pow2 partisi 1
    $hasilbagi1 = $pusat_cluster1[0];
    $pow_partisi1 = $pusat_cluster1[1];

    // Hasil bagi dengan pow2 & nilai pow2 partisi 2
    $hasilbagi2 = $pusat_cluster2[0];
    $pow_partisi2 = $pusat_cluster2[1];

    $fungsi_objectif = getFungsiObjectifStatis($data, $pow_partisi1, $pow_partisi2, $hasilbagi1, $hasilbagi2);

    $new_pusat_cluster1 = array();
    $new_pusat_cluster2 = array();
    $new_hasilbagi1 = array();
    $new_hasilbagi2 = array();
    $new_pow_partisi1 = array();
    $new_pow_partisi2 = array();
    $new_fungsi_objectif = array();

    $data_fungsi_objektif = array();
    $partisi_baru1 = array();
    $partisi_baru2 = array();
    $sum_objektif = array();
    $error = array();

    array_push($data_fungsi_objektif, $fungsi_objectif);
    array_push($partisi_baru1, $fungsi_objectif[0]);
    array_push($partisi_baru2, $fungsi_objectif[1]);
    array_push($sum_objektif, $fungsi_objectif[2]);

    


    for ($i = 0; $i < $max_iterasi - 1; $i++) {

        if ($i == 0) {
            $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
            $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

            $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
            $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

            $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
            $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

            $x1 = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


            array_push($partisi_baru1, $x1[0]);
            array_push($partisi_baru2, $x1[1]);
            array_push($sum_objektif, $x1[2]);
        } else if (abs($sum_objektif[$i] - $sum_objektif[$i - 1]) <= $max_error) {
            break;
        } else {
            $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
            $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

            $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
            $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

            $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
            $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

            $x2 = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


            array_push($partisi_baru1, $x2[0]);
            array_push($partisi_baru2, $x2[1]);
            array_push($sum_objektif, $x2[2]);
        }
    }

    $random_statis1= $partisiawalC1 ;
    $random_statis2= $partisiawalC2 ;
    $pow_nilai_u1=array_merge($pow_partisi1,$new_pow_partisi1);
    $pow_nilai_u2=array_merge($pow_partisi2,$new_pow_partisi2);
    $pusat_clusterr1=array_merge($hasilbagi1,$new_hasilbagi1);
    $pusat_clusterr2=array_merge($hasilbagi2,$new_hasilbagi2);
// nilai random1, nilai random 2 
    $panjang_iterasi=sizeof($sum_objektif)-1;
    return [$random_statis1,$random_statis2,$pow_nilai_u1,$pow_nilai_u2,$pusat_clusterr1,$pusat_clusterr2,$sum_objektif,$partisi_baru1[$panjang_iterasi],$partisi_baru2[$panjang_iterasi],$partisi_baru1,$partisi_baru2];
}

function startFCM($data, $max_iterasi, $max_error)
{
    $w = sizeof($data);
    $h = sizeof($data[0]);

     
    // Nilai Partisi Awal
    // $partisiawalC1 = $r1;
    // $partisiawalC2 = $r2;
     $partisiawalC1 = getRandom($h);
     $partisiawalC2 = getRandom($h);


    $pusat_cluster1 = pusatCluster($data, $partisiawalC1);
    $pusat_cluster2 = pusatCluster($data, $partisiawalC2);

    // Hasil bagi dengan pow2 & nilai pow2 partisi 1
    $hasilbagi1 = $pusat_cluster1[0];
    $pow_partisi1 = $pusat_cluster1[1];

    // Hasil bagi dengan pow2 & nilai pow2 partisi 2
    $hasilbagi2 = $pusat_cluster2[0];
    $pow_partisi2 = $pusat_cluster2[1];

    $fungsi_objectif = getFungsiObjectif($data, $pow_partisi1, $pow_partisi2, $hasilbagi1, $hasilbagi2);

    $new_pusat_cluster1 = array();
    $new_pusat_cluster2 = array();
    $new_hasilbagi1 = array();
    $new_hasilbagi2 = array();
    $new_pow_partisi1 = array();
    $new_pow_partisi2 = array();
    $new_fungsi_objectif = array();

    $data_fungsi_objektif = array();
    $partisi_baru1 = array();
    $partisi_baru2 = array();
    $sum_objektif = array();
    $error = array();

    array_push($data_fungsi_objektif, $fungsi_objectif);
    array_push($partisi_baru1, $fungsi_objectif[0]);
    array_push($partisi_baru2, $fungsi_objectif[1]);
    array_push($sum_objektif, $fungsi_objectif[2]);


    for ($i = 0; $i < $max_iterasi - 1; $i++) {

        if ($i == 0) {
            $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
            $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

            $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
            $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

            $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
            $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

            $x = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


            array_push($partisi_baru1, $x[0]);
            array_push($partisi_baru2, $x[1]);
            array_push($sum_objektif, $x[2]);
        } else if (abs($sum_objektif[$i] - $sum_objektif[$i - 1]) <= $max_error) {
            break;
        } else {
            $new_pusat_cluster1[$i] = pusatCluster($data, $partisi_baru1[$i]);
            $new_pusat_cluster2[$i] = pusatCluster($data, $partisi_baru2[$i]);

            $new_hasilbagi1[$i] = $new_pusat_cluster1[$i][0];
            $new_hasilbagi2[$i] = $new_pusat_cluster2[$i][0];

            $new_pow_partisi1[$i] = $new_pusat_cluster1[$i][1];
            $new_pow_partisi2[$i] = $new_pusat_cluster2[$i][1];

            $x = getFungsiObjectif($data, $new_pow_partisi1[$i], $new_pow_partisi2[$i], $new_hasilbagi1[$i], $new_hasilbagi2[$i]);


            array_push($partisi_baru1, $x[0]);
            array_push($partisi_baru2, $x[1]);
            array_push($sum_objektif, $x[2]);
        }
    }


    $random_statis1= $partisiawalC1 ;
    $random_statis2= $partisiawalC2 ;
    $pow_nilai_u1=array_merge($pow_partisi1,$new_pow_partisi1);
    $pow_nilai_u2=array_merge($pow_partisi2,$new_pow_partisi2);
    $pusat_clusterr1=array_merge($hasilbagi1,$new_hasilbagi1);
    $pusat_clusterr2=array_merge($hasilbagi2,$new_hasilbagi2);
// nilai random1, nilai random 2 
    $panjang_iterasi=sizeof($sum_objektif)-1;
    return [$random_statis1,$random_statis2,$pow_nilai_u1,$pow_nilai_u2,$pusat_clusterr1,$pusat_clusterr2,$sum_objektif,$partisi_baru1[$panjang_iterasi],$partisi_baru2[$panjang_iterasi],$partisi_baru1,$partisi_baru2];
}


function  getRandom($width)
{
    $datarandom = array();
    for ($a = 0; $a < $width; $a++) {
        $datarandom[$a] =  rand(0, 999) / 999;
    }

    return $datarandom;
}

function power_2($data_array,  $height)
{

    $hasil = array();

    for ($a = 0; $a < $height; $a++) {
        $hasil[$a] = $data_array[$a] * $data_array[$a];
    }
    return $hasil;
}

function pusatCluster($data, $matrik_partisi)
{
    $w = sizeof($data[0]);
    $h = sizeof($data);
    $pow_matrik_partisi = power_2($matrik_partisi, $h);

    $hasil = array();
    $hasilsum = array();
    $hasilbagi = array();

    for ($a = 0; $a < $h; $a++) {
        for ($b = 0; $b < $w; $b++) {
            $hasil[$a][$b] = $data[$a][$b]  * $pow_matrik_partisi[$a];
        }
    }
    foreach ($hasil as $value) {
        foreach ($value as $key => $number) {
            (!isset($hasilsum[$key])) ?
                $hasilsum[$key] = $number : $hasilsum[$key] += $number;
        }
    }
    $sumpartisi = array_sum($pow_matrik_partisi);
    // echo $sumpartisi;
    for ($i = 0; $i < $w; $i++) {
        $hasilbagi[$i] = $hasilsum[$i] / $sumpartisi;
    }
    return
        [
            // $data,
            // $pow_matrik_partisi,
            // $hasil,
            // $hasilsum,
            // $hasilbagi
            $hasilbagi,
            $pow_matrik_partisi
        ]
        // $hasilbagi
    ;
}

function getSumPusatCluster($data_array)
{
    $hasil = array_sum($data_array);
    return $hasil;
}

function getFungsiObjectif($data, $matrixpow1, $matrixpow2, $matrikpusatcluster1, $matrikpusatcluster2)
{
    $w = sizeof($data[0]);
        $h = sizeof($data);
        $hasil = array();
        $new_matrik_partisi1 = $matrixpow1;
        $new_matrik_partisi2 = $matrixpow2;
        $matrik_hasilchildsum1 = getChildFungsiObjectif($data, $matrikpusatcluster1);
        $hasil_sumchild1 = $matrik_hasilchildsum1[1];
        $hasil_sumkalichild1 = $matrik_hasilchildsum1[0];
        $matrik_hasilchildsum2 = getChildFungsiObjectif($data, $matrikpusatcluster2);
        $hasil_sumchild2 = $matrik_hasilchildsum2[1];
        $hasil_sumkalichild2 = $matrik_hasilchildsum2[0];
        $matrik_hasilkalichildsum1 = array();
        $matrik_hasilkalichildsum2 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $hasil1 = array();
        $hasil2 = array();
        $partisibaru1 = array();
        $partisibaru2 = array();

        for ($a = 0; $a < $h; $a++) {
            $matrik_hasilkalichildsum1[$a] = ($hasil_sumkalichild1[$a] * $new_matrik_partisi1[$a]);
            $matrik_hasilkalichildsum2[$a] = ($hasil_sumkalichild2[$a] * $new_matrik_partisi2[$a]);

            $matrik_hasilkalichildsumMin1[$a] = pow($hasil_sumkalichild1[$a], -1);
            $matrik_hasilkalichildsumMin2[$a] = pow($hasil_sumkalichild2[$a], -1);
        }

        for ($a = 0; $a < $h; $a++) {
            $hasil1[$a] =  $matrik_hasilkalichildsum1[$a] + $matrik_hasilkalichildsum2[$a];
            $hasil2[$a] = ($matrik_hasilkalichildsumMin1[$a] + $matrik_hasilkalichildsumMin2[$a]);
        }

        for ($a = 0; $a < $h; $a++) {
            $partisibaru1[$a] =  $matrik_hasilkalichildsumMin1[$a] / $hasil2[$a];
            $partisibaru2[$a] =  $matrik_hasilkalichildsumMin2[$a] / $hasil2[$a];
        }



        return
            [
                $partisibaru1,
                $partisibaru2,
                array_sum($hasil1)
            ];
}

function getFungsiObjectifStatis($data, $matrixpow1, $matrixpow2, $matrikpusatcluster1, $matrikpusatcluster2)
{
    $w = sizeof($data[0]);
        $h = sizeof($data);
        $hasil = array();
        $new_matrik_partisi1 = $matrixpow1;
        $new_matrik_partisi2 = $matrixpow2;
        $matrik_hasilchildsum1 = getChildFungsiObjectif($data, $matrikpusatcluster1);
        $hasil_sumchild1 = $matrik_hasilchildsum1[1];
        $hasil_sumkalichild1 = $matrik_hasilchildsum1[0];
        $matrik_hasilchildsum2 = getChildFungsiObjectif($data, $matrikpusatcluster2);
        $hasil_sumchild2 = $matrik_hasilchildsum2[1];
        $hasil_sumkalichild2 = $matrik_hasilchildsum2[0];
        $matrik_hasilkalichildsum1 = array();
        $matrik_hasilkalichildsum2 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $matrik_hasilkalichildsumMin1 = array();
        $hasil1 = array();
        $hasil2 = array();
        $partisibaru1 = array();
        $partisibaru2 = array();

        for ($a = 0; $a < $h; $a++) {
            $matrik_hasilkalichildsum1[$a] = ($hasil_sumkalichild1[$a] * $new_matrik_partisi1[$a]);
            $matrik_hasilkalichildsum2[$a] = ($hasil_sumkalichild2[$a] * $new_matrik_partisi2[$a]);

            $matrik_hasilkalichildsumMin1[$a] = pow($hasil_sumkalichild1[$a], -1);
            $matrik_hasilkalichildsumMin2[$a] = pow($hasil_sumkalichild2[$a], -1);
        }

        for ($a = 0; $a < $h; $a++) {
            $hasil1[$a] =  $matrik_hasilkalichildsum1[$a] + $matrik_hasilkalichildsum2[$a];
            $hasil2[$a] = ($matrik_hasilkalichildsumMin1[$a] + $matrik_hasilkalichildsumMin2[$a]);
        }

        for ($a = 0; $a < $h; $a++) {
            $partisibaru1[$a] =  $matrik_hasilkalichildsumMin1[$a] / $hasil2[$a];
            $partisibaru2[$a] =  $matrik_hasilkalichildsumMin2[$a] / $hasil2[$a];
        }



        return
            [
                $partisibaru1,
                $partisibaru2,
                array_sum($hasil1)
            ];
}

function getChildFungsiObjectif($data, $matrikpusatcluster)
{

    $w = sizeof($data[0]);
    $h = sizeof($data);
    $index = array();
    $hasil = array();
    $hasilsum = array();

    for ($a = 0; $a < $h; $a++) {
        for ($b = 0; $b < $w; $b++) {
            $hasil[$a][$b] =  pow(($data[$a][$b] - $matrikpusatcluster[$b]), 2);
            // echo $hasil[$a][$b]."======";
        }
    }

    foreach ($hasil as $key => $value) {
        $hasilsum[$key] = array_sum($value);
    }
     

    return [$hasilsum, $hasil];
}

 

function round_4($nilai)
{
    return round($nilai, 4);
}

function round_6($nilai)
{
    return round($nilai, 6);
}


 
