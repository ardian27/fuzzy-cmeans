<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Nilai */
?>
<div class="nilai-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [ 
            'nim',
            'mata_kuliah',
            'nilai',
        ],
    ]) ?>

</div>
