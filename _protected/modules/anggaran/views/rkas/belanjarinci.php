<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="ta-rkas-kegiatan-index">
<div class="col-md-12">
    <p>
        <?= Html::a('Tambah Rincian Belanja', [
            'createbelanjarinci',
                'tahun' => $model->tahun,
                'sekolah_id' => $model->sekolah_id,
                'kd_program' => $model->kd_program,
                'kd_sub_program' => $model->kd_sub_program,
                'kd_kegiatan' => $model->kd_kegiatan,
                'Kd_Rek_1' => $model->Kd_Rek_1,
                'Kd_Rek_2' => $model->Kd_Rek_2,
                'Kd_Rek_3' => $model->Kd_Rek_3,
                'Kd_Rek_4' => $model->Kd_Rek_4,
                'Kd_Rek_5' => $model->Kd_Rek_5,
            ], [
                'class' => 'btn btn-xs btn-success',
                'data-toggle'=>"modal",
                'data-target'=>"#myModalrinci",
                'data-title'=>"Tambah Rincian Belanja",
            ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-belanja_rinci',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        // 'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'belanjarinci-pjax'.$model->Kd_Rek_3.$model->Kd_Rek_4.$model->Kd_Rek_5, 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            'no_rinc',        
            [
                'label' => 'Rincian',
                'group' => true,
                'value' => function($model){
                    return $model->keterangan;
                }
            ],
            // [
            //     'class' => 'kartik\grid\ActionColumn',
            //     'template' => '{updatebelanja} {deletebelanja} {rkasbelanjarinc}',
            //     'noWrap' => true,
            //     'vAlign'=>'top',
            //     'buttons' => [
            //             'updatebelanja' => function ($url, $model) {
            //               return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
            //                   [  
            //                      'title' => Yii::t('yii', 'ubah'),
            //                      'data-toggle'=>"modal",
            //                      'data-target'=>"#myModalubah",
            //                      'data-title'=> "Ubah Belanja",                                 
            //                      // 'data-confirm' => "Yakin menghapus sasaran ini?",
            //                      // 'data-method' => 'POST',
            //                      // 'data-pjax' => 1
            //                   ]);
            //             },
            //             'deletebelanja' => function ($url, $model) {
            //               return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
            //                   [  
            //                      'title' => Yii::t('yii', 'hapus'),
            //                      // 'data-toggle'=>"modal",
            //                      // 'data-target'=>"#myModalubah",
            //                      // 'data-title'=> "Ubah Unit",                                 
            //                      'data-confirm' => "Yakin menghapus belanja ini?",
            //                      'data-method' => 'POST',
            //                      'data-pjax' => 1
            //                   ]);
            //             },                        
            //             'rkasbelanjarinc' => function ($url, $model) {
            //               return Html::a('Rincian Belanja <i class="glyphicon glyphicon-menu-right"></i>', $url,
            //                   [  
            //                      'title' => Yii::t('yii', 'Input Rincian Belanja'),
            //                      'class'=>"btn btn-xs btn-default",                                 
            //                      // 'data-confirm' => "Yakin menghapus sasaran ini?",
            //                      // 'data-method' => 'POST',
            //                      // 'data-pjax' => 1
            //                   ]);
            //             },
            //     ]
            // ],
        ],
    ]); ?>
</div><!--col-->
</div>