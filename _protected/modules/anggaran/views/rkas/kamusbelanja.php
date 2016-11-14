<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="ta-rkas-kegiatan-index">
<h3 class="text-center">Kamus Belanja <?= $Tahun.'-'.($Tahun+1) ?></h3>

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
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Kode Rekening',
                'value' => function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.substr('0'.$model->Kd_Rek_4, -2).'.'.substr('0'.$model->Kd_Rek_5, -2);
                }
            ],
            [
                'label' => 'Jenis',
                'group' => true,
                'value' => function($model){
                    return $model->refRek3->Nm_Rek_3;
                }
            ],
            [
                'label' => 'Kelompok',
                'group' => true,
                'value' => function($model){
                    return $model->refRek4->Nm_Rek_4;
                }
            ],            
            [
                'label' => 'Belanja',
                'attribute' => 'Nm_Rek_5',
                'value' => function($model){
                    return $model->Nm_Rek_5;
                }
            ],
        ],
    ]); ?>
</div>