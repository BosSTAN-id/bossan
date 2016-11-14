<?php

use yii\helpers\Html;
use kartik\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="ta-rkas-kegiatan-index">
<h3 class="text-center">Kamus Kegiatan <?= $Tahun.'-'.($Tahun+1) ?></h3>
<!-- <h3 class="text-center"><?= Yii::$app->user->identity->refSekolah->nama_sekolah ?></h3> -->

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
            'options' => ['id' => 'kegiatan-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            // 'sekolah_id',        
            [
                'label' => 'Kd Kegiatan',
                'value' => function($model){
                    return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
                }
            ],
            'refProgram.uraian_program',
            'refSubProgram.uraian_sub_program',
            'uraian_kegiatan',       
        ],
    ]); ?>
</div>