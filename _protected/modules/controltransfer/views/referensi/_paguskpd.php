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
            'options' => ['id' => 'paguskpd-pjax'.$model->Kd_Trans_1.$model->Kd_Trans_2.$model->Kd_Trans_3, 'timeout' => 5000],
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
                'template' => '{update} {delete}',//{update}{delete}
                'controller' => 'transskpd',
                
                'buttons' =>[
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalSkpdubah",
                                 'data-title'=> "Ubah Pagu ".$model->subunit->Nm_Sub_Unit,                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },            
                        'delete' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 'data-method' => 'POST',
                                 'data-pjax' => 1
                              ]);
                        } 
                ],               
                               
            ],
        ],
    ]); ?>
</div>
