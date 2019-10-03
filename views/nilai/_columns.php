<?php
use yii\helpers\Url;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mata_kuliah',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ], 
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'mataKuliah.bidang',
        'hAlign'=>'center',
        'vAlign'=>'middle',
    ], 
    [
        'class'=>'\kartik\grid\EditableColumn',
        'header'=>'Nilai',
        'hAlign'=>'center',
        'vAlign'=>'middle',
        'attribute'=>'nilai',
        'value'=>function($model){  
            return ''.$model->nilai;
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => true,
        'hAlign'=>'center',
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