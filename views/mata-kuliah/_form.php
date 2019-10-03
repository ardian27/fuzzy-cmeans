<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MataKuliah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mata-kuliah-form">

    <?php $form = ActiveForm::begin(); ?>

	<?= $form->field($model, 'mata_kuliah')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'bidang')->dropDownList([  'IK' => 'Ilmu Komputer', 'TI' => 'Teknologi Informasi', ], ['prompt' => 'Pilih Jenis Bidang Mata Kuliah']) ?>
       
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
