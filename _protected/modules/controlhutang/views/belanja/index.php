<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
BootboxAsset::register($this);
/* @var $this yii\web\View */
/* @var $searchModel app\models\TaRASKArsipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
function cekSPH($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
    $sph = \app\models\TaRASKArsipHutang::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID]);
    return $sph['No_SPH'];
}

$this->title = 'Anggaran Hutang';
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-index">
<?php
$this->registerJs("
$(document).on('ready pjax:success', function () {
  $('.ajaxDelete').on('click', function (e) {
    e.preventDefault();
    var deleteUrl     = $(this).attr('delete-url');
    var pjaxContainer = $(this).attr('pjax-container');
    bootbox.confirm('Anda Yakin?',
            function (result) {
              if (result) {
                $.ajax({
                  url:   deleteUrl,
                  type:  'post',
                  error: function (xhr, status, error) {
                    alert('There was an error with your request.' 
                          + xhr.responseText);
                  }
                }).done(function (data) {
                  $.pjax.reload({container: '#' + $.trim(pjaxContainer)});
                });
              }
            }
    );
  });
});

");
?>    
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=> $this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'sphawal-pjax', 'timeout' => 5000],
        ],           
        'columns' => [
            //'Tahun',
            //'Kd_Perubahan',
            //'Kd_Urusan',
            //'Kd_Bidang',
            //'Kd_Unit',
            // 'Kd_Sub',
            //'refSubUnit.Nm_Sub_Unit',
            // 'Kd_Prog',
            // 'ID_Prog',
            // 'Kd_Keg',
            //'taKegiatan.Ket_Kegiatan',            
            [
                'attribute'=>'kd_keg', 
                'width'=>'310px',
                /*'value'=>function ($model, $key, $index, $widget) { 
                    return $model->renjaKegiatan->sub->Nm_Sub_Unit;
                },*/
                //'value' => 'taKegiatan.Ket_Kegiatan',
                'value' =>function($model){
                    return $model->Kd_Prog.'.'.$model->Kd_Keg.' Kegiatan :'.$model->taKegiatan->Ket_Kegiatan;
                    //return print_r(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID));
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
            ],                       
            // 'Kd_Rek_1',
            // 'Kd_Rek_2',
            // 'Kd_Rek_3',
            // 'Kd_Rek_4',
            // 'Kd_Rek_5',
            //'refRek5.Nm_Rek_5',
            [
                'attribute'=>'Kd_Rek_5', 
                'width'=>'310px',
                //'value' => 'refRek5.Nm_Rek_5',
                'value' =>function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.' '.$model->refRek5->Nm_Rek_5;
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
            ],             
            // 'No_Rinc',
            //'taBelanjaRinc.Keterangan',
            [
                'attribute'=>'No_Rinc', 
                'width'=>'310px',
                'value' =>function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.$model->No_Rinc.' '.$model->Keterangan_Rinc;
                },               
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
            ],            
            [
                'attribute'=>'Kd', 
                'width'=>'60px',
                'value' =>function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.$model->No_Rinc.'.'.$model->No_ID;
                },               
            ], 
            'taBelanjaRincSub.Keterangan',
            //'Keterangan_Rinc',
            // 'Sat_1',
            // 'Nilai_1',
            // 'Sat_2',
            // 'Nilai_2',
            // 'Sat_3',
            // 'Nilai_3',
            // 'Satuan123',
            // 'Jml_Satuan',
            // 'Nilai_Rp',
            'Total:decimal',
            // 'Keterangan',
            // 'Kd_Ap_Pub',
            // 'Kd_Sumber',
            // 'DateCreate',
            [
                'label' => 'Aksi',
                'format'=>'raw',
                'noWrap' => true,
                'value' => function($model){
                    IF(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID) == NULL)
                    {
                        return 
                        Html::a('<i class"fa fa-check-circle"></i> Utang', ['sph', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], [
                                'class' => 'btn btn-xs btn-default', 
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModalkegiatan",
                                'data-title'=>"Surat Pengakuan Hutang atas ".$model->Keterangan_Rinc,                        
                            ]); //if utang sudah di klik
                    }ELSE{
                        return 
                        Html::a('<button class="btn btn-xs btn-danger"><i class="fa fa-trash-o bg-white"></i> Hapus</button>', ['deletesph', 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], ['class' => 'btn btn-xs btn-danger','data' => ['confirm' => 'Yakin hapus status hutang?','method' => 'post',],]).
                        /*
                        Html::a(
                                '<button class="btn btn-xs btn-danger"><i class="fa fa-trash-o bg-white"></i> Hapus</button>',
                                false,
                                [
                                    'class'          => 'ajaxDelete',
                                    'delete-url'     => 'belanja/deletesph',
                                    'pjax-container' => 'pjax-list',
                                    'title'          => Yii::t('app', 'Delete')
                                ]
                            ).
                        */
                        ' No SPH: '.cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID);
                    }
                    
                },
            ],
            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
</div>

<?php
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
    'id' => 'myModalkegiatan',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
    'options' => [
        'id' => 'myModalkegiatan',
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
    $('#myModalkegiatan').on('show.bs.modal', function (event) {
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