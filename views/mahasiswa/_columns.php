<?php

use yii\bootstrap\Html;
use yii\helpers\Url;

return [
    
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ],
        [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nim',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'nama',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'tahun_masuk',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ],
    [

        'class' => 'kartik\grid\ActionColumn',

        'template' => '{detail}' ,

        'hAlign' => 'center',

        'width' => '10%',

        'buttons' => [            
            
            'detail' => function ($url,$model) {
                return Html::a('<span class="btn btn-info" >Detail</span>', Url::toRoute(['nilai/data-nilai','id' => $model->nim]), ['title' => 'Lihat & Update Data Nilai Mahasiswa']);
            }, 
            
        ],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   