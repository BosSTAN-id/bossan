<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Belanja';
$this->params['breadcrumbs'][] = ['label' => 'RKAS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Belanja Langsung', 'url' => ['kegiatan']];
$this->params['breadcrumbs'][] = $kegiatan->refKegiatan->uraian_kegiatan;
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $kegiatan->kd_program.'.'.$kegiatan->kd_sub_program.'.'.$kegiatan->kd_kegiatan.' '.$kegiatan->refKegiatan->uraian_kegiatan ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">

        <?= DetailView::widget([
            'model' => $kegiatan,
            'attributes' => [
                [
                    'label' => 'Sumber Dana',
                    'value' => $kegiatan->penerimaan2->uraian,
                ],
                'pagu_anggaran:decimal',
            ],
        ]) ?>
        </div><!-- /.box-body -->
    </div>        

    <p>
        <?= Html::a('Tambah Belanja', [
            'createbelanja',
                'tahun' => $kegiatan->tahun,
                'sekolah_id' => $kegiatan->sekolah_id,
                'kd_program' => $kegiatan->kd_program,
                'kd_sub_program' => $kegiatan->kd_sub_program,
                'kd_kegiatan' => $kegiatan->kd_kegiatan,
            ], [
                'class' => 'btn btn-xs btn-success',
                'data-toggle'=>"modal",
                'data-target'=>"#myModal",
                'data-title'=>"Tambah Belanja",
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
            'options' => ['id' => 'belanja-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'sekolah_id',        
            [
                'label' => 'Kd Kegiatan',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
                }
            ],
            'refProgram.uraian_program',
            'refSubProgram.uraian_sub_program',
            'refKegiatan.uraian_kegiatan',
            [
                'label' => 'Sumber Dana',
                'value' => function($model){
                    return $model->penerimaan2->uraian;
                }
            ],
            // 'pagu_anggaran',
            // 'kd_penerimaan_1',
            // 'kd_penerimaan_2',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{updatebelanja} {delete} {rkasbelanjarinc}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'updatebelanja' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Ubah Unit",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'rkasbelanjarinc' => function ($url, $model) {
                          return Html::a('Rincian Belanja <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Input Belanja'),
                                 'class'=>"btn btn-xs btn-default",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                ]
            ],
        ],
    ]); ?>
</div><!--col-->
<div class="col-md-3">
    <div class="well">
                <ul class="tree arrow">
                    <li class="open root">
                        <i></i><a href="#">ROOT</a>
                        <ul>
                            <li class="open">
                                <i></i><a href="#">Item 1</a>
                                <ul>
                                    <li class="leaf">
                                        <i></i><a href="#">Item 1.1</a>
                                        <ul></ul>
                                    </li>
                                    <li class="leaf">
                                        <i></i><a href="#">Item 1.2</a>
                                        <ul></ul>
                                    </li>
                                    <li class="fold last">
                                        <i></i><a href="#">Item 1.3</a>
                                        <ul></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="open">
                                <i></i><a href="#">Item 2</a>
                                <ul>
                                    <li class="leaf">
                                        <i></i><a href="#">Item 2.1</a>
                                        <ul></ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="leaf last">
                                <i></i><a href="#">Item 3</a>
                                <ul></ul>
                            </li>
                        </ul>
                    </li>
                </ul>
    </div>
</div><!--col-->
</div><!--row-->
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