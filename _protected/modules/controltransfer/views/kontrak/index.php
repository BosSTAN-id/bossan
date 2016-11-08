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
function cekTransfer($Tahun, $Kd_Urusan, $Kd_Bidang, $Kd_Unit, $Kd_Sub, $Kd_Prog, $ID_Prog, $Kd_Keg, $Kd_Rek_1, $Kd_Rek_2, $Kd_Rek_3, $Kd_Rek_4, $Kd_Rek_5, $No_Rinc, $No_ID){
    $sph = \app\models\TaRASKArsipTransfer::findOne(['Tahun' => $Tahun, 'Kd_Urusan' => $Kd_Urusan, 'Kd_Bidang' => $Kd_Bidang, 'Kd_Unit' => $Kd_Unit, 'Kd_Sub' => $Kd_Sub, 'Kd_Prog' => $Kd_Prog, 'ID_Prog' => $ID_Prog, 'Kd_Keg' => $Kd_Keg, 'Kd_Rek_1' => $Kd_Rek_1, 'Kd_Rek_2' => $Kd_Rek_2, 'Kd_Rek_3' => $Kd_Rek_3, 'Kd_Rek_4' => $Kd_Rek_4, 'Kd_Rek_5' => $Kd_Rek_5, 'No_Rinc' => $No_Rinc, 'No_ID' => $No_ID]);
    return $sph['taTrans3']['Nm_Sub_Bidang'];
}

$this->title = 'Daftar Kontrak';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-kontrak-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ta Kontrak', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'responsive'=>true,
        'responsiveWrap' => false,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Daftar Anggaran '],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],              
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'No_Kontrak',
            'Tgl_Kontrak:date',
            // 'Kd_Prog',
            // 'ID_Prog',
            [
                'attribute' => 'Kd_Kegiatan',
                //'width' => '50px',
                'noWrap' => false, 
                'contentOptions' => ['style'=>'max-width: 300px; overflow: hidden; word-wrap: break-word;'],             
                'value' => 'taKegiatan.Ket_Kegiatan',
            ],
            // 'Keperluan',
            // 'Waktu',
            'Nm_Perusahaan',
            'Nilai:currency',
            // 'Bentuk',
            // 'Alamat',
            // 'Nm_Pemilik',
            // 'NPWP',
            // 'Nm_Bank',
            // 'Nm_Rekening',
            // 'No_Rekening',
            [
                'label' => 'Aksi',
                'format'=>'raw',
                'value' => function($model){
                    /*
                    IF(cekTransfer($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID) == NULL)
                    {*/
                        return
                        Html::a('<i class"fa fa-plus"></i> Angg.Trf', ['sph', 'Tahun' => $model->Tahun, 'No_Kontrak' => $model->No_Kontrak, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg], [
                                'class' => 'btn btn-xs btn-default', 
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModalkegiatan",
                                'data-title'=>"Sub Belanja Untuk Kontrak ".$model->No_Kontrak,                        
                            ]); //if utang sudah di klik
                    /*
                    }ELSE{
                        return 
                        Html::a('<button class="btn btn-xs btn-danger"><i class="fa fa-trash-o bg-white"></i></button>', ['deletesph', 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog'=> $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID], ['class' => 'btn btn-xs btn-danger','data' => ['confirm' => 'Yakin hapus status hutang?','method' => 'post',],]).
                        ' Dana Transfer: '.cekTransfer($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID);
                    }*/
                    
                },
            ],
            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

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