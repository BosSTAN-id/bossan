<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

$programlist = ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program, " ", uraian_program) AS uraian_program'])->asArray()->all(), 'kd_program', 'uraian_program');
$subprogramlist = ArrayHelper::map(\app\models\RefSubProgramSekolah::find()->select(['CONCAT(kd_program,".",kd_sub_program) AS kd_sub_program', 'CONCAT(kd_program,".",kd_sub_program, " ", uraian_sub_program) AS uraian_sub_program'])->asArray()->all(), 'kd_sub_program', 'uraian_sub_program');
// Pjax::begin(['enablePushState' => true]);
$this->registerJs("$('.select2').remove();", \yii\web\View::POS_END); 

$this->registerJs(<<<JS
$("a[id*='kegiatan-link-']").on('click', function(e){
    e.preventDefault()
    var target = e.target;
    var href = $(this).attr('href');
    $('#sub-program-tab').removeClass('active');
    // $('#program-tab').html('<a href=\"#program-content\"  data-toggle=\"tab\" role=\"tab\" title=\"program\"><i class=\"glyphicon glyphicon-program-content\"></i> Program</a>');
    $('#kegiatan-tab').attr('class', 'active');
    $('#sub-program-link').click();
    $('#sub-program-content').removeClass('active in');
    $('#kegiatan-content').addClass('active in');
    $('#kegiatan-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
    $.get(href).done(function(data){
        $('#kegiatan-content').html(data);
    });
});
JS
);
?>
<div class="ref-kegiatan-sekolah-index">
    <p>
        <?= Html::a('Tambah Sub Program Sekolah', ['tambahsubprogram', 'id' => $model->kd_program], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Sub Program",
                                                    ]) ?>
    </p>

    <?= GridView::widget([
        'id' => 'ref-kegiatan-sekolah',    
        'dataProvider' => $dataSubProgramProvider,
        // 'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=> $model->uraian_program],
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
            'options' => ['id' => 'ref-sub-program-sekolah-pjax', 'timeout' => 5000, 'enablePushState' => true],
        ],        
        // 'filterModel' => $searchSubProgramModel,
        'columns' => [
            [
                'label' => 'Kode',
                'attribute' => 'kd_sub_program',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2);
                }
            ],
            [
                'label'=>'Sub Program', 
                'attribute' => 'uraian_sub_program',
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
                    return $model->uraian_sub_program;
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{ubahsubprogram} {deletesubprogram} {kegiatantab}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'ubahsubprogram' => function ($url, $model) {
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
                        'deletesubprogram' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                                [  
                                    'title' => Yii::t('yii', 'hapus'),                               
                                    'data-confirm' => "Yakin menghapus sasaran ini?",
                                    'data-method' => 'POST',
                                    'data-pjax' => 1
                                ]);
                        },
                        'kegiatantab' => function ($url, $model) {
                            return Html::a('<i class="glyphicon glyphicon-menu-right"></i>', $url,
                                [
                                    'id' => 'kegiatan-link-'.$model->kd_program.$model->kd_sub_program,
                                    'title' => Yii::t('yii', 'Kegiatan'),
                                    'class'=>"btn btn-xs btn-default",
                                    'data-pjax' => 0
                                ]);
                        },                      
                ]
            ],
        ],
    ]); ?>
</div>