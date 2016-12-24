<?php

use yii\helpers\Html;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;
use kartik\widgets\ActiveForm;

function totalbelanja($tahun, $sekolah_id, $kd_program, $kd_sub_program, $kd_kegiatan, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5){
    $belanja = \app\models\TaRkasBelanjaRinc::find()
                ->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'kd_program' => $kd_program, 'kd_sub_program' => $kd_sub_program, 'kd_kegiatan' => $kd_kegiatan , 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5])
                ->sum('total');
    return  $belanja ? $belanja : 0;
}
switch ($model->kd_sah) {
    case 1:
        $status = 'Usulan/Draft';
        break;
    case 2:
        $status = 'Terverifikasi';
        break;
    case 3:
        $status = 'Ditolak';
        break;
    default:
        $status = 'Usulan/Draft';
        break;
}
/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bukti SPJ '.$model->no_spj;
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Verifikasi SPJ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-12">
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">SPJ No: <?= $model->no_spj ?> <small>(klik untuk rincian)</small></h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="glyphicon glyphicon-chevron-down"></i>
                </button>
            </div>            
        </div><!-- /.box-header -->
        <div class="box-body">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'No SPJ',
                    'value' => $model['no_spj'],
                ],
                'tgl_spj:date',
                'keterangan',
                [
                    'label' => 'Status',
                    'value' =>  $status
                ]
            ],
        ]) ?>
        </div><!-- /.box-body -->
    </div>        

    <?php
    IF($model->kd_sah == 1){
$form = ActiveForm::begin();
echo TabularForm::widget([
    'form' => $form,
    'dataProvider' => $dataProvider,
    'actionColumn'=>false,
    'checkboxColumn' => false,
    'attributes' => [
        'no_bukti' => ['type' => TabularForm::INPUT_STATIC, 'columnOptions'=>['hAlign'=>GridView::ALIGN_LEFT]],
        'uraian' => ['type' => TabularForm::INPUT_STATIC, 'columnOptions'=>['hAlign'=>GridView::ALIGN_LEFT]],
        'tgl_bukti' => [
                'type' => TabularForm::INPUT_STATIC, 
                'format' => 'date',
                'columnOptions'=>[
                    'hAlign'=>GridView::ALIGN_RIGHT,
                    'noWrap' => true,
                ]
            ],
        'nilai' => [
            'type' => TabularForm::INPUT_STATIC,
            'format' => 'decimal', 
            'columnOptions'=> ['hAlign'=>GridView::ALIGN_RIGHT]
        ],
        // '' => [
        //     'type' => TabularForm::INPUT_STATIC, 
        //     'value' => function($model){
        //         IF($model->no_spj <> null){
        //             return '<i class="glyphicon glyphicon-ok"></i>';
        //         }ELSE{
        //             return '';
        //         }
        //     }, 
        //     'columnOptions'=>['hAlign'=>GridView::ALIGN_LEFT]
        // ],
        
    ],
    'gridSettings' => [
        'id' => 'ta-spjbukti',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,    
        'responsiveWrap' => false,       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'belanja-pjax', 'timeout' => 5000],
        ], 
        'floatHeader' => false,
        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Bukti Untuk SPJ '.$model->no_spj.'</h3>',
            'type' => GridView::TYPE_PRIMARY,
            'after'=> 
                // Html::a(
                //     '<i class="glyphicon glyphicon-plus"></i> Set Bukti SPJ', 
                //     ['assign'], 
                //     ['class'=>'btn btn-xs btn-success']
                // ) . '&nbsp;' . 
                // Html::a(
                //     '<i class="glyphicon glyphicon-remove"></i> Delete', 
                //     $deleteUrl, 
                //     ['class'=>'btn btn-danger']
                // ) . '&nbsp;' .
                Html::submitButton(
                    '<i class="glyphicon glyphicon-floppy-disk"></i> Tambahkan Bukti', 
                    ['class'=>'btn btn-xs btn-success']
                )
        ]
    ]     
]); 
ActiveForm::end();
    }ELSE{
    echo GridView::widget([
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
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'label' => 'Jenis Belanja',
                'value' => function($model){
                    return $model->refRek5->Nm_Rek_5;
                }
            ],
            'no_bukti',
            'tgl_bukti',            
            'uraian',
            'nilai:decimal',
        ],
    ]);
    } ?>
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
?>