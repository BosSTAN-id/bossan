<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use johnitvn\ajaxcrud\BulkButtonWidget;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\asettetap\models\TaAsetTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// var_dump(Yii::$app->request->post()['selection']);
switch ($model->Kd_Aset1) {
    case 1:
        $breadCrumbNamaAset = 'Tanah';
        break;
    case 2:
        $breadCrumbNamaAset = 'Peralatan dan Mesin';
        break;
    case 3:
        $breadCrumbNamaAset = 'Gedung dan Bangunan';
        break;
    case 4:
        $breadCrumbNamaAset = 'Jalan Jaringan dan Irigasi';
        break;
    case 5:
        $breadCrumbNamaAset = 'Aset Tetap Lain';
        break;
    case 6:
        $breadCrumbNamaAset = 'KDP';
        break;
                        
    default:
        $breadCrumbNamaAset = 'Pilih dong...';
        break;
}

$this->title = $breadCrumbNamaAset;
$this->params['breadcrumbs'][] = 'Aset Tetap';
$this->params['breadcrumbs'][] = 'Inventarisasi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-index">
    <div class="box box-success collapsed-box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title"><a><i class="glyphicon glyphicon-plus" data-widget="collapse"></i></a> <?= $this->title ?></h3>

            <div class="box-tools pull-right">
                <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button> -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
    <?php ActiveForm::begin(['action' => ['bulk-delete']]); ?>
    <?= GridView::widget([
        'id' => 'ta-aset-tetap',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>[
            'type'=>'primary', 
            'heading'=>$this->title,
            'after'=> Html::submitButton( '<span class="glyphicon glyphicon-trash"></span> Delete', ['class' => 'btn btn-danger', 'data-confirm' => "Yakin menghapus item yang dipilih?",]),
        ],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{toggleData}',
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
            'options' => ['id' => 'ta-aset-tetap-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => '\kartik\grid\CheckboxColumn'
            ],
            ['class' => 'kartik\grid\SerialColumn'],
            'tahun',
            [
                'label' => 'Kode',
                'value' => function($model){
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3.'.'.substr('0'.$model->Kd_Aset4, -2).'.'.substr('0'.$model->Kd_Aset5, -2);
                }
            ],
            [
                'label' => 'Jenis',
                'value' => function($model){
                    return $model->kdAset5->Nm_Aset5;
                }
            ],
            'no_urut',
            // 'Kd_Aset4',
            // 'Kd_Aset5',
            // 'no_urut',
            // 'no_register',
            // 'kepemilikan',
            // 'sumber_perolehan',
            // 'referensi_bukti',
            'tgl_perolehan',
            'nilai_perolehan:decimal',
            // 'masa_manfaat',
            // 'nilai_sisa',
            // 'kondisi',
            'keterangan',
            // 'attr1',
            // 'attr2',
            // 'attr3',
            // 'attr4',
            // 'attr5',
            // 'attr6',
            // 'attr7',
            // 'attr8',
            // 'attr9',
            // 'attr10',
            // 'created_at',
            // 'updated_at',

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
    <?php ActiveForm::end(); ?>
</div>
<?php 
Modal::begin([
    'id' => 'modalAset',
    'header' => '<h4 class="modal-title">Daftar Klasifikasi Aset Tetap...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();
$this->registerJs(<<<JS
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

    $('#modalAset').on('show.bs.modal', function (event) {
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

JS
);
?>