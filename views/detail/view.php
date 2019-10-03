<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\ClusterDetail */
?>
<div class="cluster-detail-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cluster_detail',
            'id_cluster',
            'nim',
            'hasil',
        ],
    ]) ?>

</div>
