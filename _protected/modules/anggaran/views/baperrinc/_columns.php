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
        'template' => '<li>{k2all}</li> <li>{k2bos}</li> <li>{bos}</li>',
        'controller' => 'baperrinc',
        'noWrap' => true,
        'vAlign'=>'middle',
        'dropdown' => true,
        'dropdownOptions' => ['class' => 'dropdown pull-right'],
        'dropdownMenu' => ['class'=>'text-left'],
        'dropdownButton' => [
            'class'=> 'btn btn-xs btn-info',
            'label' => 'Preview'
        ],
        'buttons' => [
                'k2all' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span> FORM-K2', $url,
                    [  
                       'title' => Yii::t('yii', 'FORM BOS K-2 Semua Dana'),
                       'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
                    ]);
                },
                'k2bos' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span> FORM-K2 BOS', $url,
                    [  
                       'title' => Yii::t('yii', 'FORM BOS K-2 Sumber Dana BOS'),
                       'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
                    ]);
                },
                'bos' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-print"></span> BOS-03', $url,
                    [  
                       'title' => Yii::t('yii', 'FORM BOS-03 Sumber Dana BOS'),
                       'onClick' => "return !window.open(this.href, 'RKA 1', 'width=1024,height=768')"
                    ]);
                },
        ]
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
];   