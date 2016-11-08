<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="ta-trans-skpd-index">
<?php
echo Html::a('<span class"fa fa-plus"></span> Pembagian Pagu SKPD', ['skpd', 'Tahun' => $model->Tahun, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3], [
                                'class' => 'btn btn-xs btn-default', 
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModalkegiatan",
                                'data-title'=>"Pagu SKPD ".$model->Nm_Sub_Bidang,                        
                            ]);
?>
<?php Pjax::begin(); ?>    
<?= GridView::widget([
        'id' => 'pagu'.$model->Kd_Trans_1.$model->Kd_Trans_2.$model->Kd_Trans_3,
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'responsiveWrap' => false,              
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'referensi-pjax', 'timeout' => 5000],
        ],  
        'showPageSummary'=>'pagu',               
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'subunit.Nm_Sub_Unit',
            [
                'attribute' => 'Pagu',
                'format' => 'currency',
                'pageSummary'=>true,
                'value' => 'Pagu'
            ],
            'Referensi_Dokumen',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{delete}',//{update}{delete}
                'controller' => 'transskpd',
                /*
                'buttons' =>[
                        'view' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-info-sign"></span>', $url,
                                     ['title' => Yii::t('app', 'View')]);
                        }
                ],
                
                'urlCreator' => function ($action, $model, $key, $index) {
                    if ($action === 'view') {
                        $url ='controller/action?id='.$model->id;
                        return $url;
                    }
                } 
                ['lihatpaguskpd', [
                                    'Tahun' => $model->Tahun, 
                                    'Kd_Trans_1' => $model->Kd_Trans_1, 
                                    'Kd_Trans_2' => $model->Kd_Trans_2, 
                                    'Kd_Trans_3' => $model->Kd_Trans_3,
                                    'Kd_Urusan' => $model->Kd_Urusan,
                                    'Kd_Bidang' => $model->Kd_Bidang,
                                    'Kd_Unit' => $model->Kd_Unit,
                                    'Kd_Sub' => $model->Kd_Sub
                                    ]]                
                */               
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
