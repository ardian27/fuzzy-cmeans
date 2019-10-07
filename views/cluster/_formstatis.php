<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cluster */
/* @var $form yii\widgets\ActiveForm */
print("<pre>Proses Cluster Fuzzy & C-Means dengan data dan Nilai Bobot Statis</pre>");

?>

<div class="cluster-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'min_error')->textInput(['required'=>true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'max_iterasi')->textInput(['required'=>true]) ?>

        </div>
    </div>


    <?php if (!Yii::$app->request->isAjax) { ?>
        <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Proses' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    <?php } ?>

    <?php ActiveForm::end(); ?>

</div>