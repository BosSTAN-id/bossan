<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controltransfer\models\TaTrans3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Kontrak dengan Dana Transfer';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-trans3-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>false,
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'transferkontrak-pjax', 'timeout' => 5000],
        ],             
        'panel'=>['type'=>'primary', 'heading'=>'Kontrak dengan Dana Transfer'],          
        'columns' => [
            //['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandIcon' => '<span class="glyphicon glyphicon-menu-right"></span>',
                'expandTitle' => 'Pelaksana Program',
                'collapseIcon' => '<span class="glyphicon glyphicon-menu-down"></span>',
                'collapseTitle' => 'Tutup',                
                'value' => function ($model, $key, $index, $column) {

                    return GridView::ROW_COLLAPSED;
                },

                'allowBatchToggle'=>true,
               'detail'=>function ($model, $key, $index, $column) {
                //$searchModel = new \app\modules\controltransfer\models\TaTransKontrak();
                $dataProvider = new ActiveDataProvider ([ 
                    'query' => \app\models\TaTransKontrak::find()
                            ->where('Tahun = '.$model->Tahun.' AND Kd_Trans_1 = '.$model->Kd_Trans_1.' AND Kd_Trans_2 = '.$model->Kd_Trans_2.' AND Kd_Trans_3 = '.$model->Kd_Trans_3.' AND Kd_Urusan = '.$model->Kd_Urusan.' AND Kd_Bidang = '.$model->Kd_Bidang.' AND Kd_Unit = '.$model->Kd_Unit.' AND Kd_Sub = '.$model->Kd_Sub)
                            ]);                              
                    return Yii::$app->controller->renderPartial('_paguskpd', [
                        'model'=>$model,
                        //'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        ]);
                },
                'detailOptions'=>[
                    'class'=> 'kv-state-enable',
                ],

            ],        
            [
                'attribute'=>'Kd_Trans_1', 
                'width'=>'310px',
                'value' =>function($model){
                    return $model->Kd_Trans_1.' '.$model->taTrans1->Jns_Transfer;
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'attribute'=>'Kd_Trans_2', 
                'width'=>'310px',
                'value' =>function($model){
                    return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.' '.$model->taTrans2->Nm_Bidang;
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],            
            [
                'attribute' =>'Kd_Trans_3',
                'width' => '50px',
                'value' => function($model){
                    return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.'.'.$model->Kd_Trans_3;
                }
            ],
            'taTrans3.Nm_Sub_Bidang',
            // 'Kd_sub_DAK',
            'Pagu:currency'
        ],
    ]); ?>
</div>

<?php
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalkegiatan',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
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