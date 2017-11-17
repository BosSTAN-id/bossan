<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

$programlist = ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program, " ", uraian_program) AS uraian_program'])->asArray()->all(), 'kd_program', 'uraian_program');
$subprogramlist = ArrayHelper::map(\app\models\RefSubProgramSekolah::find()->select(['CONCAT(kd_program,".",kd_sub_program) AS kd_sub_program', 'CONCAT(kd_program,".",kd_sub_program, " ", uraian_sub_program) AS uraian_sub_program'])->asArray()->all(), 'kd_sub_program', 'uraian_sub_program');
// Pjax::begin(['enablePushState' => true]);
$this->registerJs("$('.select2').remove();", \yii\web\View::POS_END); 
?>
<div class="ref-kegiatan-sekolah-index">
    <p>
        <?= Html::a('Tambah Kegiatan Sekolah', ['tambahkegiatan', 'id' => $model->id], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Kegiatan",
                                                    ]) ?>
    </p>

    <?= GridView::widget([
        'id' => 'ref-kegiatan-sekolah',    
        'dataProvider' => $dataKegiatanProvider,
        // 'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=> $model->uraian_sub_program],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
            '{export}',
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
            'options' => ['id' => 'ref-kegiatan-sekolah-pjax', 'timeout' => 5000, 'enablePushState' => true],
        ],        
        // 'filterModel' => $searchSubProgramModel,
        'columns' => [
            [
                'label' => 'Kode',
                'attribute' => 'kd_kegiatan',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
                }
            ],
            [
                'label'=>'Kegiatan', 
                'attribute' => 'uraian_kegiatan',
                // 'filter' => \kartik\select2\Select2::widget([
                //     'options' => ['placeholder' => 'Pilih Program ...'],
                //     'model' => $searchModel,
                //     'attribute' => 'kd_program',
                //     'data' => $programlist,
                //     'pluginOptions' => [
                //         'allowClear' => true
                //     ],
                // ]),
                'value'=>function ($model, $index, $widget) {
                    return $model->uraian_kegiatan;
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{ubahkegiatan} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'ubahkegiatan' => function ($url, $model) {
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
                ]
            ],
        ],
    ]); ?>
</div>