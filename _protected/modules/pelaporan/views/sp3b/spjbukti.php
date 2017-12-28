<?php

use yii\helpers\Html;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;
use yii\bootstrap\Collapse;
use kartik\widgets\ActiveForm;

function cekspj($tahun, $sekolah_id, $no_spj){
    $spj = \app\models\TaSP3BRinc::find()
                ->where(['tahun' => $tahun, 'sekolah_id' => $sekolah_id, 'no_spj' => $no_spj])
                ->one();
    return  $spj;
}
$sp3b = $model->no_sp3b;
switch ($model->status) {
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

$this->title = 'Daftar SPJ Untuk: '.$model->no_sp3b;
$this->params['breadcrumbs'][] = 'Pelaporan';
$this->params['breadcrumbs'][] = ['label' => 'SP3B', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-12">
    <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
            <h3 class="box-title">SP3B No: <?= $model->no_sp3b ?> <small>(klik untuk rincian)</small></h3>
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
                    'label' => 'No SP3B',
                    'value' => $model['no_sp3b'],
                ],
                'tgl_sp3b:date',
                [
                    'label' => 'Status',
                    'value' =>  $status
                ]
            ],
        ]) ?>
        </div><!-- /.box-body -->
    </div>        
    
    <?php
    IF($model->status == 1){
        echo GridView::widget([
            'id' => 'ta-spj',    
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
                'options' => ['id' => 'ta-spj-pjax', 'timeout' => 5000],
            ],             
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],

                'tahun',
                'no_spj',
                'keterangan',
                'tgl_spj',
                'sekolah.nama_sekolah',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Preview',
                    'template' => '{printspj}',
                    'noWrap' => true,
                    'vAlign'=>'top',
                    'buttons' => [
                            'printspj' => function($url, $model){
                                return  Html::a('<i class="glyphicon glyphicon-print bg-white"></i>', $url, ['onClick' => "return !window.open(this.href, 'SPJ', 'width=1024,height=768')"]);
                            },                                             
                    ]
                ],
                [
                    'label' => '[]',
                    'format' => 'raw',
                    'value' => function($model) use ($sp3b, $status) {
                        IF(cekspj($model->tahun, $model->sekolah_id, $model->no_spj) === NULL){
                            return Html::a('<span class="fa fa-square-o"></span>', ['assign', 'kd' => 1, 'tahun' => $model->tahun, 'no_sp3b' => $sp3b,  'no_spj' => $model->no_spj ],
                            [  
                                'title' => Yii::t('yii', 'Tambah SPJ ini'),
                                // 'data-toggle'=>"modal",
                                // 'data-target'=>"#myModalubah",
                                // 'data-title'=> "Ubah SPJ ".$model->no_spj,                                 
                                // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                'data-method' => 'POST',
                                'data-pjax' => 0
                            ]);
                        }ELSE{
                            return Html::a('<span class="fa fa-check-square-o"></span>', ['assign', 'kd' => 0, 'tahun' => $model->tahun, 'no_sp3b' => $sp3b,  'no_spj' => $model->no_spj ],
                            [  
                                'title' => Yii::t('yii', 'Tambah SPJ ini'),
                                // 'data-toggle'=>"modal",
                                // 'data-target'=>"#myModalubah",
                                // 'data-title'=> "Ubah SPJ ".$model->no_spj,                                 
                                // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                'data-method' => 'POST',
                                'data-pjax' => 0
                            ]);
                        }
                    }
                ],
            ],
        ]);
    }ELSE{
        echo GridView::widget([
            'id' => 'ta-spj',    
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
                'options' => ['id' => 'ta-spj-pjax', 'timeout' => 5000],
            ],             
            // 'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],

                'tahun',
                'no_spj',
                'spj.keterangan',
                // 'tgl_spj',
                'sekolah.nama_sekolah',
                [
                    'class' => 'kartik\grid\ActionColumn',
                    'header' => 'Preview',
                    'template' => '{printspj}',
                    'noWrap' => true,
                    'vAlign'=>'top',
                    'buttons' => [
                            'printspj' => function($url, $model){
                                return  Html::a('<i class="glyphicon glyphicon-print bg-white"></i>', $url, ['onClick' => "return !window.open(this.href, 'SPJ', 'width=1024,height=768')"]);
                            },                                             
                    ]
                ],
            ],
        ]);        
    }
    ?>
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