<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_bukti',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'date',
        'attribute'=>'tgl_bukti',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => Select2::widget([
                    // 'model' => $model,
                    // 'attribute' => 'pembayaran',
                    'name' => 'TaSPJRincSearch[pembayaran]',
                    'data' => [1 => 'Bank', 2 => 'Tunai'],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Metode...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
        'attribute'=>'pembayaran',
        'value' => function($model){
            return $model->pembayaran == 1 ? 'Bank' : 'Tunai';
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'decimal',
        'attribute'=>'nilai',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'uraian',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                // return Url::to([$action,'tahun, $no_bukti, $tgl_bukti'=>$key]);
                return Url::to([$action, 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
        },
        'viewOptions'=>[
            // 'role'=>'modal-remote',
            'title'=>'View',
            // 'data-toggle'=>'tooltip'
        ],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
        'buttons' => [
            'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModal",
                                //  'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
        ]
    ],

];