<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\MataKuliah */
?>
<div class="mata-kuliah-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_mata_kuliah',
            'mata_kuliah',
            'bidang',
        ],
    ]) ?>

</div>
