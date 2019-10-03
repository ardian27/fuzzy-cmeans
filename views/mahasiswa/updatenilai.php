<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\depdrop\DepDrop;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\Nilai;
use app\models\Mahasiswa;
use app\models\MataKuliah;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $modelCustomer app\modules\yii2extensions\models\Customer */
/* @var $modelsAddress app\modules\yii2extensions\models\Address */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Data Item ke: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-address").each(function(index) {
        jQuery(this).html("Data Item ke: " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="customer-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($modelMahasiswa, 'nim')->textInput(['maxlength' => true , 'required'=>true]) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($modelMahasiswa, 'nama')->textInput(['maxlength' => true , 'required'=>true]) ?>
        </div>

        <div class="col-lg-4">
            <?= $form->field($modelMahasiswa, 'tahun_masuk')->textInput(['maxlength' => true , 'required'=>true]) ?>
        </div>

    </div>


    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
    <?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
        'widgetBody' => '.container-items', // required: css class selector
        'widgetItem' => '.item', // required: css class
        'limit' => 500, // the maximum times, an element can be cloned (default 999)
        'min' => 1, // 0 or 1 (default 1)
        'insertButton' => '.add-item', // css class
        'deleteButton' => '.remove-item', // css class
        'model' => $modelNilai[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'mata_kuliah',
            'nilai',
        ],
    ]); ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <i class="fa fa-envelope"></i> Data Mata Kuliah
            <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="fa fa-plus"></i> Add
                Item</button>
            <div class="clearfix"></div>
        </div>
        <div class="panel-body container-items">
            <!-- widgetContainer -->
            <?php foreach ($modelNilai as $index => $modelNilai): ?>
            <div class="item panel panel-default">
                <!-- widgetBody -->
                <div class="panel-heading">
                    <span class="panel-title-address">Item : <?= ($index + 1) ?></span>
                    <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i
                            class="fa fa-minus"></i></button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                    <?php
                            // necessary for update action.
                            if (!$modelNilai->isNewRecord) {
                                echo Html::activeHiddenInput($modelNilai, "[{$index}]nim");
                            }
                        ?>

                    <div class="row">
                        <div class="col-sm-4">
                            <?= $form->field($modelNilai, "[{$index}]mata_kuliah")->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(MataKuliah::find()->all(),'mata_kuliah','mata_kuliah'),
                                    'options' => ['placeholder' => 'Pilih Mata Kuliah ...'],
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                        </div>
                        <div class="col-sm-2">
                            <?= $form->field($modelNilai, "[{$index}]nilai")->textInput(['maxlength' => true , 'required'=>true]) ?>
                        </div>
                    </div><!-- end:row -->


                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php DynamicFormWidget::end(); ?>

    <span class="pull-right">
        <button class="btn btn-warning " onclick="goBack()">Kembali</button>

        <?php
        echo Html::submitButton($modelNilai->isNewRecord ? 'Simpan' : 'Update', ['class' => 'btn btn-primary pull-right']);

    ActiveForm::end(); ?>
        <br>
    </span>
</div>