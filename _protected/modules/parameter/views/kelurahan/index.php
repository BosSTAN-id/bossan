<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="ref-desa-index">
    <h1><?= Html::encode($kecamatan->Nm_Kecamatan) ?></h1>
    <?= Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Kelurahan', ['/parameter/kelurahan/create', 'Kd_Kecamatan' => $Kd_Kecamatan], [
                                'class' => 'btn btn-xs btn-success',
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=>"Tambah Kelurahan",
                                ]).
        GridView::widget([
            'id' => 'ref-desa',    
            'dataProvider' => $dataProvider,
            'export' => false, 
            'responsive'=>true,
            'hover'=>true,
            'striped' => true,
            'resizableColumns'=>true,
            // 'panel'=>['type'=>'primary', 'heading'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Kecamatan', ['create'], [
            //                                             'class' => 'btn btn-xs btn-success',
            //                                             'data-toggle'=>"modal",
            //                                             'data-target'=>"#myModal",
            //                                             'data-title'=>"Tambah Kecamatan",
            //                                             ])
            // ],
            'responsiveWrap' => false,        
            'toolbar' => [
                [
                    'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
                ],
            ],       
            'pager' => [
                'firstPageLabel' => 'Awal',
                'lastPageLabel'  => 'Akhir'
            ],
            'pjax'=>true,
            'pjaxSettings'=>[
                'options' => ['id' => 'ref-desa-pjax', 'timeout' => 5000],
            ],        
            'filterModel' => $searchModel,          
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'Kd_Kecamatan',
                'Kd_Desa',
                'Nm_Desa',

                [
                    'class' => 'kartik\grid\ActionColumn',
                    'template' => '{view} {update} {delete}',
                    'controller' => 'kelurahan',
                    'noWrap' => true,
                    'vAlign'=>'top',
                    'buttons' => [
                            'update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                [  
                                    'title' => Yii::t('yii', 'ubah'),
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModalubah",
                                    'data-title'=> "Ubah",                                 
                                    // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                    // 'data-method' => 'POST',
                                    // 'data-pjax' => 1
                                ]);
                            },
                            'view' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                                [  
                                    'title' => Yii::t('yii', 'lihat'),
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModalubah",
                                    'data-title'=> "Lihat",
                                ]);
                            },                        
                    ]
                ],
            ],
        ]);  ?>
</div>