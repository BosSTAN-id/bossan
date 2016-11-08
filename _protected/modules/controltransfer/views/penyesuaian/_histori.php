<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
?>
<div class="ta-trans-skpd-index">   
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
            'options' => ['id' => 'paguskpd-pjax', 'timeout' => 5000],
        ],               
        'columns' => [
           [
                'attribute' =>'No_Perubahan',
                'width' => '10px',
                'value' => function($model){
                    return $model->No_Perubahan - 1;
                }
            ],         
            [
                'label' => 'Kode',
                'attribute' =>'Kd_Trans_3',
                'width' => '150px',
                'value' => function($model){
                    return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.'.'.$model->Kd_Trans_3;
                }
            ],
            'Pagu:currency',
        ],
    ]); ?>
</div>
