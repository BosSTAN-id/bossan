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
$this->registerJs(<<<JS
$("a[id*='sub-program-link-']").on('click', function(e){
    e.preventDefault()
    var target = e.target;
    var href = $(this).attr('href');
    $('#program-tab').removeClass('active');
    // $('#program-tab').html('<a href=\"#program-content\"  data-toggle=\"tab\" role=\"tab\" title=\"program\"><i class=\"glyphicon glyphicon-program-content\"></i> Program</a>');
    $('#sub-program-tab').attr('class', 'active');
    $('#program-link').click();
    $('#program-content').removeClass('active in');
    $('#sub-program-content').addClass('active in');
    $('#sub-program-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
    $.get(href).done(function(data){
        $('#sub-program-content').html(data);
    });
});
JS
);
?>
<div class="ref-kegiatan-sekolah-index">

<div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <li id="program-tab" role="presentation" class="active"><a href="#program-content" aria-controls="program-content" role="tab" data-toggle="tab">Program</a></li>
        <li id="sub-program-tab" role="presentation"><a href="#sub-program-content" aria-controls="sub-program-content" role="tab" data-toggle="tab">Sub Program</a></li>
        <li id="kegiatan-tab" role="presentation"><a href="#kegiatan-content" aria-controls="kegiatan-content" role="tab" data-toggle="tab">Kegiatan</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="program-content">
            <?= GridView::widget([
                'id' => 'ref-kegiatan-sekolah',    
                'dataProvider' => $dataProgramProvider,
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
                    'options' => ['id' => 'ref-program-sekolah-pjax', 'timeout' => 5000, 'enablePushState' => true],
                ],        
                'filterModel' => $searchProgramModel,
                'columns' => [
                    [
                        'label' => 'Kode',
                        'attribute' => 'kode',
                        'value' => function($model){
                            return $model->kd_program;
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
                            return $model->uraian_program;
                        }
                    ],
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{subprogramtab}',
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
                                'subprogramtab' => function ($url, $model) {
                                    return Html::a('<i class="glyphicon glyphicon-menu-right"></i>', $url,
                                        [
                                            'id' => 'sub-program-link-'.$model->kd_program,
                                           'title' => Yii::t('yii', 'Sub Program'),
                                           'class'=>"btn btn-xs btn-default",
                                           'data-pjax' => 0
                                        ]);
                                },                      
                        ]
                    ],
                ],
            ]); ?>        
        </div>
        <div role="tabpanel" class="tab-pane" id="sub-program-content">...</div>
        <div role="tabpanel" class="tab-pane" id="kegiatan-content">...</div>
    </div>

</div>

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