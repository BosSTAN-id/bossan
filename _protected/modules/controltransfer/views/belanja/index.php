<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
BootboxAsset::register($this);
use kartik\detail\DetailView;
/* @var $this yii\web\View */
/* @var $searchModel app\models\TaRASKArsipSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
function cekTransfer($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
    $sph = \app\models\TaRASKArsipTransfer::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID]);
    return $sph['taTrans3']['Nm_Sub_Bidang'];
}
function cekperubahan($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3) {
    // Fungsi memeriksa adakah perubahan pada pagutransfer;
  $cek = \app\models\TaTransSkpdPerubahan::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3])->select('MAX(No_Perubahan) AS No_Perubahan')->one();

  IF($cek->No_Perubahan > 1){
    $tanggal = \app\models\TaTransSkpdPerubahan::find()->where(['Tahun' => $Tahun, 'Kd_Trans_1' => $Kd_Trans_1, 'Kd_Trans_2' => $Kd_Trans_2, 'Kd_Trans_3' => $Kd_Trans_3, 'No_Perubahan' => $cek->No_Perubahan])->one();
    return '<span class="label label-warning">Diubah '.DATE('d-m-y', $tanggal->updated_at).' <i class="fa fa-warning"></i></span>';
  }ELSE{
    return '<i class="fa fa-check-circle-o"></i>';
  }

}

$this->title = 'Control Anggaran';
$this->title = 'Anggaran';
$this->params['breadcrumbs'][] = 'Dana Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class = "row">
<div class = "col-md-3">
    <?php foreach($realisasi as $realisasi): ?>
    <div class="box">
        <div class="box-header">
        <h3 class="box-title"><?= $realisasi['Jns_Transfer'] ?></h3>
        </div>
        <div class="box-body no-padding">  
            <div class= "text-center">      
            <?php
                $percentage = (($realisasi['Total']*100)/$realisasi['Pagu']); 
                echo softcommerce\knob\Knob::widget([
                        // 'name' => 'animated_knob_with_icon',
                        'value' => intval($percentage),
                        // 'icon' => '<span class="glyphicon glyphicon-flash"></span>',
                        'options' => [
                            'data-min' => '0',
                            'data-max' => '100',
                            'data-width' => '100',
                            'data-height' => '100',
                        ],
                        'knobOptions' => [
                            'readOnly' => true,
                            'thickness' => '.25',
                            'dynamicDraw' => true,
                            'fgColor' => $percentage <= 100 ?  '#9fc569' : '#CC0000',
                        ],
                    ]
                );
            ?>
            </div>      
            <table class="table">
                <tbody>
                    <tr>
                        <td><b>Jenis Transfer</b></td>
                        <td><?= Html::a($realisasi['Nm_Bidang'].' - '.$realisasi['Nm_Sub_Bidang'], ['daftar', 'Kd_Trans_1' => $realisasi['Kd_Trans_1'], 'Kd_Trans_2' => $realisasi['Kd_Trans_2'], 'Kd_Trans_3' => $realisasi['Kd_Trans_3']], [
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModalkegiatan",
                                    'data-title'=>"Daftar Belanja Dana ".$realisasi['Nm_Sub_Bidang'],                       
                                ]) ?></td>
                    </tr>
                    <tr>
                        <td><b>Dianggarkan</b></td>
                        <td>
                        <?= number_format($realisasi['Total'], 0, ',', '.') ?>
                        </td>
                    </tr>                
                    <tr>
                        <td><b>Pagu</b></td>
                        <td>
                        <?= number_format($realisasi['Pagu'], 0, ',', '.').' '.cekperubahan($realisasi['Tahun'], $realisasi['Kd_Trans_1'], $realisasi['Kd_Trans_2'], $realisasi['Kd_Trans_3']) ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2">
                        <?php echo number_format($percentage, '2', ',', '.').'%'  ?>
                        <div class="progress progress-xs progress-striped active">
                        <div class="progress-bar progress-bar-success" style="width: <?= $percentage ?>%"></div>
                        </div>
                        </td>
                    </tr>
                </tbody>
            </table>
           
        </div>
    </div>              
    <?php endforeach;?>
</div><!--md-2-->
<div class = "col-md-9">
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
                'options' => ['id' => 'belanja-pjax', 'timeout' => 5000],
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
                    'value' => function($model){
                        IF(cekTransfer($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID) == NULL)
                        {
                            return
                            Html::a('<span class"fa fa-plus"></span> Dana Transfer', ['sph', 'Tahun' => $model->Tahun, 'Kd_Perubahan' => $model->Kd_Perubahan, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], [
                                    'class' => 'btn btn-xs btn-default', 
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModalkegiatan",
                                    'data-title'=>"Dana Transfer Untuk Belanja ".$model->Keterangan_Rinc,                        
                                ]); //if utang sudah di klik
                        }ELSE{
                            return 
                            Html::a('<button class="btn btn-xs btn-danger"><i class="fa fa-trash-o bg-white"></i></button>', ['deletesph', 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], ['class' => 'btn btn-xs btn-danger','data' => ['confirm' => 'Yakin hapus status hutang?','method' => 'post',],]).
                            ' Dana Transfer: '.cekTransfer($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID);
                        }
                        
                    },
                ],
                //['class' => 'kartik\grid\ActionColumn'],
            ],
        ]); ?>
</div><!--tarask-->
</div><!--col-10-->
</div><!--row-->

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
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

Modal::begin([
    'id' => 'myModalkegiatan',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
]);
 
echo '...';
 
Modal::end();

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


Modal::begin([
    'id' => 'myModalDaftar',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModalDaftar').on('show.bs.modal', function (event) {
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