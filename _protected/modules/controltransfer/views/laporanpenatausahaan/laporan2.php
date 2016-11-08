<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $data,
        //'filterModel' => $searchModel,
        // 'export' => true, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'panel'=>['type'=>'primary', 'heading'=>'Rekapitulasi Kontrol Anggaran Utang'],
        'responsiveWrap' => false,        
        'toolbar' => [
            '{export}',
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'laporan1-pjax', 'timeout' => 5000],
        ],
        'showPageSummary'=>true,         
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],            
            [
                'label' => 'Kegiatan',
                'width'=>'15%',
                'value' =>function($model){
                    return $model->Kd_Prog.'.'.$model->Kd_Keg.' '.$model->taKegiatan->Ket_Kegiatan;
                },
                'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Rekening 5',
                'width'=>'15%',
                'value' =>function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5.' '.$model->refRek5->Nm_Rek_5;
                },
                'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Rincian Belanja', 
                'width'=>'15%',
                'value' => 'Keterangan_Rinc',               
                'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Sub Rincian', 
                'width'=>'20%',
                'value' => 'Keterangan',
            ],
            [
                'attribute'=>'Total',
                'width'=>'5%',
                'noWrap' => true,
                'hAlign'=>'right',
                'format'=>['decimal', 0],
                'pageSummary'=>true
            ],
            [
                'label' => 'Dana Transfer',
                'value' => function($model){
                    return $model->taTrans2->Nm_Bidang.' - '.$model->taTrans3->Nm_Sub_Bidang;
                },                
                'width'=>'20%',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>
