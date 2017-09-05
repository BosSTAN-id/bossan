<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;

return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
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
        'attribute'=>'perubahan.riwayat',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_peraturan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'date',
        'attribute'=>'tgl_peraturan',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'raw',
        'label'=>'Terlampir',
        'value' => function ($model) use($no_ba){
            if($model['terlampir']['no_peraturan'] != NULL){
                // return '<i class="glyphicon glyphicon-ok"></i>';
                return Html::a('<span class="glyphicon glyphicon-ok"></span>', ['deleterinc', 'tahun' => $model->tahun, 'no_ba' => $no_ba, 'sekolah_id' => $model->sekolah_id, 'no_peraturan' => $model->no_peraturan],
                [  
                    'title' => Yii::t('yii', 'Hapus dari Rincian'),           
                    'data-confirm' => "Yakin menghapus dari berita acara ini?",
                    'data-method' => 'POST',
                    'data-pjax' => 1
                ]);
            }
            if($model['terlampir']['no_peraturan'] == NULL) return '';
        }
    ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'penandatangan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'nip',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'jabatan',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'komite_sekolah',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'jabatan_komite',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'verifikasi',
    // ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'template' => '{preview}',
        'controller' => 'baperrinc',
        'noWrap' => true,
        'dropdown' => true,
        'vAlign'=>'middle',
        'buttons' => [
                'preview' => function ($url, $model) {
                    // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                    //     [  
                    //         'title' => Yii::t('yii', 'lihat RKAS'),
                    //         'data-toggle'=>"modal",
                    //         'data-target'=>"#myModal",
                    //         'data-title'=> "RKAS ".$model->no_peraturan,
                    //     ]);
                    return ButtonDropdown::widget([
                        'split' => true,
                        'label' => 'Action',
                        'dropdown' => [
                            'items' => [
                                ['label' => 'DropdownA', 'url' => '/'],
                                ['label' => 'DropdownB', 'url' => '#'],
                            ],
                        ],
                    ]);
                },
        ]
    ],

];   