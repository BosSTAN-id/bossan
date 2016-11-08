<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\web\Controller;
BootboxAsset::register($this);
use kartik\tabs\TabsX;
use yii\helpers\Url;

/* 
$items = [
    [
        'label'=>'<i class="glyphicon glyphicon-home"></i> Home',
        'content'=>$content1,
        'active'=>true,
        'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=1'])]
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-user"></i> Profile',
        'content'=>$content2,
        'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=2'])]
    ],
    [
        'label'=>'<i class="glyphicon glyphicon-list-alt"></i> Dropdown',
        'items'=>[
             [
                 'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Option 1',
                 'encode'=>false,
                 'content'=>$content3,
                 'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=3'])]
             ],
             [
                 'label'=>'<i class="glyphicon glyphicon-chevron-right"></i> Option 2',
                 'encode'=>false,
                 'content'=>$content4,
                 'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=4'])]
             ],
        ],
    ],
];
*/

/* @var $this yii\web\View */
/* @var $searchModel app\models\TaRASKArsipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
function cekAset($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
    $sph = \app\models\TaRASKArsipAset::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID]);
    return $sph['refRek5Aset']['Nm_Rek_5'];
}

$this->title = 'Kapitalisasi Aset Tetap';
$this->params['breadcrumbs'][] = 'Control Aset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-index">
<?php ob_start(); ?>

    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php // Html::a('Create Ta Raskarsip', ['create'], ['class' => 'btn btn-xs btn-success']) ?>
    </p>
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

<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Anggaran '],   
        //'floatHeader'=>true,
        //'floatHeaderOptions'=>['scrollingTop'=>'50'],        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

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
                    return 'Kegiatan :'.$model->taKegiatan->Ket_Kegiatan;
                    //return print_r(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID));
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
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
                    return 'Belanja :'.$model->refRek5->Nm_Rek_5;
                },
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],             
            // 'No_Rinc',
            //'taBelanjaRinc.Keterangan',
            [
                'attribute'=>'No_Rinc', 
                'width'=>'310px',
                'value' => 'taBelanjaRinc.Keterangan',
                /*
                'value' =>function($model){
                    return 'Rincian Belanja :'.$model->taBelanjaRinc->Keterangan;
                },
                */                
                'group'=>true,  // enable grouping,
                'groupedRow'=>true,                    // move grouped column to a single grouped row
                'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],            
            // 'No_ID',
            'taBelanjaRincSub.Keterangan',
            'Keterangan_Rinc',
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
                'value' => function($model){
                    IF(cekAset($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID) == NULL)
                    {
                        IF($model->Kd_Rek_1 == 5 && $model->Kd_Rek_2 == 2 && $model->Kd_Rek_3 <> 3)
                        return
                        Html::a('<span class"fa fa-plus"></span> Kapitalisasi Aset Tetap', ['sph', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], [
                                'class' => 'btn btn-xs btn-default', 
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModalkegiatan",
                                'data-title'=>"Kapitalisasi Aset Untuk Belanja ".$model->Keterangan_Rinc,                        
                            ]); //if utang sudah di klik
                    }ELSE{
                        return 
                        Html::a('<button class="btn btn-xs btn-danger"><i class="fa fa-trash-o bg-white"></i></button>', ['deletesph', 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], ['class' => 'btn btn-xs btn-danger','data' => ['confirm' => 'Yakin hapus status hutang?','method' => 'post',],]).
                        ' Aset: '.cekAset($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID);
                    }
                    
                },
            ],
            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
<?php
$content1 = ob_get_contents();
ob_end_clean();
?>


<?php
echo TabsX::widget([
    'position'=>TabsX::POS_ABOVE,
    'bordered'=>true,
    'encodeLabels'=>false,
    'items' => [
        [
            'label'=>'<i class="glyphicon glyphicon-home"></i> Anggaran',
            'content'=>$content1,
            'active'=>true,
            //'linkOptions'=>['data-url'=>Url::to(['/site/fetch-tab?tab=1'])]
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> Realisasi',
            'content'=>'',
            'linkOptions'=>['data-url'=>Url::to(['/controlaset/belanja/realisasi'])]
        ],
        [
            'label'=>'<i class="glyphicon glyphicon-user"></i> Memo Jurnal',
            'content'=>'This is temporary content',
            'linkOptions'=>['data-url'=>Url::to(['/controlaset/belanja/memo'])]
        ],        
    ],
]);
?>

</div>
<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalkegiatan',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
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