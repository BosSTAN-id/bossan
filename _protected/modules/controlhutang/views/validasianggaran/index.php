<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controlhutang\models\BelanjakontrolSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Validasi Anggaran Hutang';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-raskarsip-hutang-index">


<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        //'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Rekapitulasi Kontrol Utang '],
        'pager' => [
            'firstPageLabel' => 'First',
            'lastPageLabel'  => 'Last'
        ],
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel]),
                'options' => ['class' => 'btn-group-sm col-md-12']
            ],
        ],
        'responsiveWrap' => false,
        'showPageSummary' => true,
        'floatHeader'=>false,
        //'floatHeaderOptions'=>['scrollingTop'=>'50'],        
        'columns' => [
            //['class' => 'kartik\grid\SerialColumn'],

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
                'label' => 'Kegiatan',
                'attribute'=>'kd_keg', 
                'width'=>'310px',
                /*'value'=>function ($model, $key, $index, $widget) { 
                    return $model->renjaKegiatan->sub->Nm_Sub_Unit;
                },*/
                //'value' => 'taKegiatan.Ket_Kegiatan',
                'value' =>function($model){
                    return $model->Kd_Prog.'.'.$model->Kd_Keg.' '.$model->taKegiatan->Ket_Kegiatan;
                    //return print_r(cekSPH($model->Tahun, $model->Kd_Urusan, $model->Kd_Bidang, $model->Kd_Unit, $model->Kd_Sub, $model->Kd_Prog, $model->ID_Prog, $model->Kd_Keg, $model->Kd_Rek_1, $model->Kd_Rek_2, $model->Kd_Rek_3, $model->Kd_Rek_4, $model->Kd_Rek_5, $model->No_Rinc, $model->No_ID));
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
            ],                       
            // 'Kd_Rek_1',
            // 'Kd_Rek_2',
            // 'Kd_Rek_3',
            // 'Kd_Rek_4',
            // 'Kd_Rek_5',
            //'refRek5.Nm_Rek_5',
            // [
            //     'attribute'=>'Kd_Rek_5', 
            //     'width'=>'310px',
            //     //'value' => 'refRek5.Nm_Rek_5',
            //     'value' =>function($model){
            //         return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.' Belanja :'.$model->refRek5->Nm_Rek_5;
            //     },
            //     'group'=>true,  // enable grouping,
            //     'groupedRow'=>true,                    // move grouped column to a single grouped row
            // ],             
            // // 'No_Rinc',
            // //'taBelanjaRinc.Keterangan',
            // [
            //     'attribute'=>'No_Rinc', 
            //     'width'=>'310px',
            //     'value' =>function($model){
            //         return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.'.'.$model->No_Rinc.' '.$model->taBelanjaRinc->Keterangan;
            //     }, 
            //     'group'=>true,  // enable grouping,
            //     'groupedRow'=>true,                    // move grouped column to a single grouped row
            // ],            
            // 'No_ID',
            [
                'label' => 'Kode',
                'value' => function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5
                    //.'.'.$model->No_Rinc.'.'.$model->No_ID
                    ;
                }
            ],
            //'taBelanjaRinc.Keterangan',
            'Keterangan',
            'taSPH.No_SPH',
            // 'Sat_1',
            // 'Nilai_1',
            // 'Sat_2',
            // 'Nilai_2',
            // 'Sat_3',
            // 'Nilai_3',
            // 'Satuan123',
            // 'Jml_Satuan',
            // 'Nilai_Rp',
            [
                'attribute' => 'Total',
                'format' => 'decimal',
                'pageSummary' => true,
            ],
            // 'Keterangan',
            // 'Kd_Ap_Pub',
            // 'Kd_Sumber',
            // 'DateCreate',
            [
                'label' => 'Cek',
                'format' => 'raw',
                'value' => function($model){
                    return  $model->Cek_PPKD == 1 ? 
                    Html::a('<i class="fa fa-check-square-o bg-white"></i>', ['cek', 'cek' => 0, 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID, 'No_SPH' => $model->No_SPH], ['data' => [
                                //'confirm' => "Are you sure you want to delete profile?",
                                'method' => 'post',
                            ],
                        ]) : 
                    Html::a('<i class="fa fa-square-o bg-white"></i>', ['cek', 'cek' => 1, 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Prog' => $model->Kd_Prog, 'ID_Prog' => $model->ID_Prog, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, 'No_Rinc' => $model->No_Rinc, 'No_ID' => $model->No_ID, 'No_SPH' => $model->No_SPH], ['data' => [
                                //'confirm' => "Are you sure you want to delete profile?",
                                'method' => 'post',
                            ],]);
                }
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
