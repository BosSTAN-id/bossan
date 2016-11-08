<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;
use yii\web\JsExpression;
use yii\web\Controller;
BootboxAsset::register($this);
use kartik\tabs\TabsX;
use yii\helpers\Url;

?>
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'panel'=>['type'=>'primary', 'heading'=>'Realisasi '],   
        //'floatHeader'=>true,
        //'floatHeaderOptions'=>['scrollingTop'=>'50'],        
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'Ket_Kegiatan',
            'Keterangan_Rinc',
            'No_SP2D',
            'Tgl_SP2D:date',
            'Nilai:decimal',
            'Total:decimal',
            [
                'label' => 'Aksi',
                'format'=>'raw',
                'value' => function($model){
                        return 
                        Html::a('<button class="btn btn-xs btn-info"><i class="fa fa-tag bg-white"></i></button>', ['Buat Memo Jurnal', 'Tahun' => $model['Tahun'], 'Kd_Urusan' => $model['Kd_Urusan'], 'Kd_Bidang' => $model['Kd_Bidang'], 'Kd_Unit' => $model['Kd_Unit'], 'Kd_Sub' => $model['Kd_Sub'], 'Kd_Prog'=> $model['Kd_Prog'], 'ID_Prog' => $model['ID_Prog'], 'Kd_Keg' => $model['Kd_Keg'], 'Kd_Rek_1' => $model['Kd_Rek_1'], 'Kd_Rek_2' => $model['Kd_Rek_2'], 'Kd_Rek_3' => $model['Kd_Rek_3'], 'Kd_Rek_4' => $model['Kd_Rek_4'], 'Kd_Rek_5' => $model['Kd_Rek_5'], 'No_Rinc' => $model['No_Rinc'], 'No_ID' => $model['No_ID']], ['class' => 'btn btn-xs btn-info','data' => ['confirm' => 'Yakin hapus status hutang?','method' => 'post',],]) .
                        ' Buat Memo';
                    
                },
            ],
            //['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>