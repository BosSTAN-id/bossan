<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

?>

    <?= GridView::widget([
        'id' => 'ta-info-bos',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=> 'Info Lainnya'],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' =>  Html::a(Yii::t('app', 'Tambah Info BOS'), ['infobos/create'], ['class' => 'btn btn-xs btn-info', 'data-toggle'=>"modal", 'data-target'=>"#myModal", 'data-title'=>"Tambah Info BOS",]),
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ta-info-bos-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'tahun_ajaran',
            'jumlah_guru',
            'jumlah_siswa',
            'satuan_bos:currency',
            'jumlah_dana_bos:currency',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'controller' => 'infobos',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModal",
                                 'data-title'=> "Lihat",
                              ]);
                        },                        
                ]
            ],
        ],
    ]); ?>