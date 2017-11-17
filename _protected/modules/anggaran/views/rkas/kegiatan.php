<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kegiatan';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = ['label' => 'RKAS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Belanja Langsung'];
?>
<div class="ta-rkas-kegiatan-index">
<!-- <h3 class="text-center">Rencana Kegiatan Anggaran Sekolah Tahun Ajaran <?= $Tahun.'-'.($Tahun+1) ?></h3>
<h3 class="text-center"><?= Yii::$app->user->identity->refSekolah->nama_sekolah ?></h3> -->
    <p>
<?php
// echo Yii::$app->controller->id.'<br>'; //the name of the current controller
// //Yii::$app->controller get a controller as an object
// echo Yii::$app->controller->action->id.'<br>'; //name of the current action
// echo Yii::$app->controller->module->id.'<br>'; //the name of the current module
// echo Yii::$app->controller->module->getUniqueId().'<br>';
// echo Yii::$app->controller->getUniqueId().'<br>';
?>
        <?= Html::a('Tambah Kegiatan', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Kegiatan",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-rkas-kegiatan',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
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
            'options' => ['id' => 'kegiatan-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->tahun.'.'.$model->sekolah_id.'.'.$model->kd_program.'.'.$model->kd_sub_program.'.'.$model->kd_kegiatan];
        },    
        'columns' => [
            [
                'label' => 'Program',
                'attribute' => 'refProgram.uraian_program',
                'group' => true,
            ],
            [
                'label' => 'Sub Program',
                'attribute' => 'refSubProgram.uraian_sub_program',
                'group' => true,
            ],
            [
                'label' => 'Kd Kegiatan',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
                }
            ],
            'refKegiatan.uraian_kegiatan',
            // [
            //     'label' => 'Sumber Dana',
            //     'value' => function($model){
            //         return $model['penerimaan2']['uraian'];
            //     }
            // ],
            'pagu_anggaran:decimal',
            // 'kd_penerimaan_1',
            // 'kd_penerimaan_2',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete} {rkasbelanja}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Ubah Kegiatan",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'rkasbelanja' => function ($url, $model) {
                          return Html::a('Belanja <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Input Belanja'),
                                 'class'=>"btn btn-xs btn-default",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 'data-pjax' => 0
                              ]);
                        },
                ]
            ],
        ],
    ]); ?>
</div>
<?php
//row click link
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id').split('.');
        if(e.target == this)
            location.href = '" . \Yii\helpers\Url::to(['rkasbelanja']) . "?tahun=' + id[0] +'&sekolah_id=' + id[1] +'&kd_program=' + id[2] +'&kd_sub_program=' + id[3] +'&kd_kegiatan=' + id[4];
    });

");
Modal::begin([
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