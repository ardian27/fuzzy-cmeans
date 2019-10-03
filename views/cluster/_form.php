<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cluster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cluster-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'min_error')->textInput() ?>

    <?= $form->field($model, 'jumlah_cluster')->textInput() ?>

    <?= $form->field($model, 'max_iterasi')->textInput() ?>

    <?= $form->field($model, 'fuzziness')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
