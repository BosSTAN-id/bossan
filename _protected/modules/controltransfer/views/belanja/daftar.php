<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\web\Controller;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controltransfer\models\TaTrans3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'Judul Po';
// $this->title = 'Anggaran';
// $this->params['breadcrumbs'][] = 'Dana Transfer';
// $this->params['breadcrumbs'][] = 'Control Anggaran';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans3-index">
    <?= GridView::widget([
        'id' => 'referensi',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
            'options' => ['id' => 'referensi-pjax', 'timeout' => 5000],
        ],
        'showPageSummary'=>'Total',                  
        'columns' => [       
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
	            [
	                'attribute' => 'Total',
	                'format' => 'decimal',
	                'pageSummary'=>true,
	                'value' => 'Total'
	            ],                
                // 'Keterangan',
                // 'Kd_Ap_Pub',
                // 'Kd_Sumber',
                // 'DateCreate',
        ],
    ]); ?>
</div>