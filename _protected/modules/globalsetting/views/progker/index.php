<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\globalsetting\models\RefKegiatanSekolahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$programlist = ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program, " ", uraian_program) AS uraian_program'])->asArray()->all(), 'kd_program', 'uraian_program');
$subprogramlist = ArrayHelper::map(\app\models\RefSubProgramSekolah::find()->select(['CONCAT(kd_program,".",kd_sub_program) AS kd_sub_program', 'CONCAT(kd_program,".",kd_sub_program, " ", uraian_sub_program) AS uraian_sub_program'])->asArray()->all(), 'kd_sub_program', 'uraian_sub_program');
// Pjax::begin(['enablePushState' => true]);
$this->registerJs("$('.select2').remove();", \yii\web\View::POS_END); 

$this->title = 'Kegiatan';
$this->params['breadcrumbs'][] = 'Pengaturan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-kegiatan-sekolah-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Tambah Kegiatan Sekolah', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Kegiatan",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ref-kegiatan-sekolah',    
        'dataProvider' => $dataProvider,
        // 'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
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
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Kode',
                'attribute' => 'kode',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
                }
            ],
            [
                'label'=>'Program', 
                'attribute' => 'kd_program',
                'filter' => \kartik\select2\Select2::widget([
                    'options' => ['placeholder' => 'Pilih Program ...'],
                    'model' => $searchModel,
                    'attribute' => 'kd_program',
                    'data' => $programlist,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value'=>function ($model, $index, $widget) {
                    return $model->refProgram->uraian_program;
                }
            ],
            [
                'label'=>'SubProgram', 
                'attribute' => 'kd_sub_program',
                'filter' => \kartik\select2\Select2::widget([
                    'options' => ['placeholder' => 'Pilih Sub ...'],
                    'model' => $searchModel,
                    'attribute' => 'kd_sub_program_gb',
                    'data' => $subprogramlist,
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
                'value'=>function ($model, $index, $widget) {
                    return $model->refSubProgram->uraian_sub_program;
                }
            ],            
            'uraian_kegiatan',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
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
    ]); ?>
</div>

<?php Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalubah',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
$this->registerJs("
    $('#myModalubah').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
       
");            
?>