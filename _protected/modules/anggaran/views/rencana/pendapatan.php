<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;

function totalbelanja($tahun, $sekolah_id, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5){
    $belanja = \app\models\TaRkasPendapatanRinc::find()
                ->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5])
                ->sum('total');
    return  $belanja ? $belanja : 0;
}
/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendapatan';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = ['label' => 'Rencana', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Pendapatan'];
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-12">       

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
        'showPageSummary'=>true,
        'columns' => [
            [
                'label' => 'Sumber Dana',
                'value' => function($model){
                    return $model['penerimaan2']['uraian'];
                }
            ],
            [
                'label' => 'Jenis',
                // 'group' => true,
                'value' => function($model){
                    return $model->refRek3->Nm_Rek_3;
                }
            ],
            [
                'label' => 'Belanja',
                'value' => function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.substr('0'.$model->Kd_Rek_4, -2).'.'.substr('0'.$model->Kd_Rek_5, -2).' '.$model->refRek5->Nm_Rek_5;
                }
            ],
            [
                'label' => 'Total',
                'format' => 'decimal',
                'hAlign' => 'right',
                'pageSummary'=>true,
                'value' => function($model){
                    return totalbelanja($model->tahun, $model->sekolah_id, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5);
                }
            ],            
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{rencanapendapatan} ',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rencanapendapatan' => function ($url, $model) {
                            $return = "";
                            $rencana = \app\models\TaRkasPendapatanRencana::findOne(['tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5]);
                            IF($rencana){
                                $buttonColor = 'btn-success';
                                $totalRencana =  $rencana['januari1'] + $rencana['februari1'] + $rencana['maret1'] + $rencana['april1'] + $rencana['mei1'] + $rencana['juni1'] + $rencana['juli'] + $rencana['agustus'] + $rencana['september'] + $rencana['oktober'] + $rencana['november'] + $rencana['desember'];
                                if(totalbelanja($model->tahun, $model->sekolah_id, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5) != $totalRencana) {
                                    $return .= '<span class="badge" data-toggle="tooltip" data-placement="left" title="Terdapat perbedaan angka rencana dan total belanja pada rkas">?</span>' ;
                                }
                            }else{
                                $buttonColor = 'btn-default';
                            }
                            $return .= Html::a('<span class="fa fa-bar-chart"></span><small>Input Rencana</small>', $url,
                                [
                                    'class' => 'btn btn-xs '.$buttonColor,
                                    'title' => Yii::t('yii', 'Rencana'),
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModal",
                                    'data-title'=> "Rencana ".$model->penerimaan2->uraian,                                 
                                    // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                    // 'data-method' => 'POST',
                                    // 'data-pjax' => 1
                                ]);
                            return $return;
                        },
                ]
            ],           
        ],
    ]); ?>
</div><!--col-->
</div><!--row-->
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
    'id' => 'myModalubah',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();
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

Modal::begin([
    'id' => 'myModalrinci',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModalrinci').on('show.bs.modal', function (event) {
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
    'id' => 'myModalrinciubah',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModalrinciubah').on('show.bs.modal', function (event) {
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