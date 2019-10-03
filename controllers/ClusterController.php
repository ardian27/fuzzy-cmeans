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

                $id_cluster=Cluster::find()->max('id_cluster');

                $datainsert=array();
                foreach ($datafix as $key => $value) {
                    foreach ($value as $key => $nilai) {
                        $datainsert[]=[
                            'id_cluster'=>$id_cluster,
                            'nim'=>$key,
                            'hasil'=>$nilai[0][1]
                        ];
                    }
                }

                if(count($datainsert)>0){
                    $columnNameArray=['id_cluster','nim','hasil'];
                    // below line insert all your record and return number of rows inserted
                    $insertCount = Yii::$app->db->createCommand()
                                   ->batchInsert(
                                         'cluster_detail', $columnNameArray, $datainsert
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
