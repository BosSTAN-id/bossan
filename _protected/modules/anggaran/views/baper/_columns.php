<?php
use yii\helpers\Url;
use yii\helpers\Html;

return [
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'sekolah.nama_sekolah',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'peraturan.perubahan.riwayat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_peraturan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'date',
        'attribute'=>'peraturan.tgl_peraturan',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{preview}',
        'controller' => 'baper',
        'dropdown' => false,
        'vAlign'=>'middle',
        'buttons' => [
                'preview' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                        [  
                            'title' => Yii::t('yii', 'lihat RKAS'),
                            'data-toggle'=>"modal",
                            'data-target'=>"#myModal",
                            'data-title'=> "RKAS ".$model->no_peraturan,
                        ]);
                },
        ]
    ],

];   