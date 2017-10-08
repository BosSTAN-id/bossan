<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\asettetap\models\TaAsetTetapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
// var_dump(Yii::$app->request->post());
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
$this->params['breadcrumbs'][] = 'Penghapusan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-aset-tetap-index">
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
            'after'=>
                '<div class="row"><div class="col-md-3">'. 
                DatePicker::widget([
                    'name' => 'tgl_pemutakhiran',
                    'type' => DatePicker::TYPE_INPUT,
                    // 'value' => date('Y-m-d'),
                    'options' => ['placeholder' => 'Tgl Pemutakhiran'],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ]).
                '</div><div class="col-md-3">'.
                Html::submitButton( '<span class="glyphicon glyphicon-pencil"></span> Penghapusan', ['class' => 'btn btn-danger', 'data-confirm' => "Yakin menghapus item yang dipilih?",]).
                '</div></div>',
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
            [
                'attribute' => 'kondisi',
                'format' => 'raw',
                'value' => function($model){
                    switch ($model->kondisi) {
                        case 1:
                            $return = '<i class="fa fa-check-circle text-info"></i> Baik';
                            break;
                        case 2:
                            $return = '<i class="fa fa-question-circle text-warning"></i> Rusak Ringan/Sedang';
                            break;
                        case 3:
                            $return = '<i class="fa fa-times-circle text-danger"></i> Rusak Berat';
                            break;
                        case 4:
                            $return = '<i class="fa fa-trash"></i> Dihapuskan';
                            break;
                        default:
                            # code...
                            break;
                    }
                    return $return;
                }
            ],
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