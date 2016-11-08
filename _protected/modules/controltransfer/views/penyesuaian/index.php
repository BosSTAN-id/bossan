<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\web\Controller;

function cekpembagian($Tahun, $Kd_Trans_1, $Kd_Trans_2, $Kd_Trans_3){

}
/* @var $this yii\web\View */
/* @var $searchModel app\modules\controltransfer\models\TaTrans3Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Penyesuaian Dana Transfer';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = 'Dana Transfer';
$this->params['breadcrumbs'][] = $this->title;
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
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
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
            'options' => ['id' => 'referensi-pjax', 'timeout' => 5000],
        ],             
        'columns' => [
            //['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {

                    return GridView::ROW_COLLAPSED;
                },
                'expandIcon' => '<span class="glyphicon glyphicon-menu-right"></span>',
                'expandTitle' => 'Sejarah',
                'collapseIcon' => '<span class="glyphicon glyphicon-menu-down"></span>',
                'collapseTitle' => 'Tutup',
                'allowBatchToggle'=>true,
                'detail'=>function ($model, $key, $index, $column) {
                $searchModel = new \app\modules\controltransfer\models\TaTrans3PerubahanSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                $dataProvider->query->where('No_Perubahan <> 1 AND Tahun = '.$model->Tahun.' AND Kd_Trans_1 = '.$model->Kd_Trans_1.' AND Kd_Trans_2 = '.$model->Kd_Trans_2.' AND Kd_Trans_3 = '.$model->Kd_Trans_3);                              
                    return Yii::$app->controller->renderPartial('_histori', [
                        'model'=>$model,
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        ]);
                },
                'detailOptions'=>[
                    'class'=> 'kv-state-enable',
                ],

            ],        
            [
                'label' => 'Jenis',
                'attribute'=>'Kd_Trans_1', 
                'width'=>'150px',
                'value' =>function($model){
                    return $model->Kd_Trans_1.' '.$model->taTrans1->Jns_Transfer;
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],
            [
                'label' => 'Bidang',
                'attribute'=>'Kd_Trans_2', 
                'width'=>'150px',
                'value' =>function($model){
                    return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.' '.$model->taTrans2->Nm_Bidang;
                },
                // 'group'=>true,  // enable grouping,
                // 'groupedRow'=>true,                    // move grouped column to a single grouped row
                // 'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
                // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
            ],            
            [
                'label' => 'Kode',
                'attribute' =>'Kd_Trans_3',
                'width' => '150px',
                'value' => function($model){
                    return $model->Kd_Trans_1.'.'.$model->Kd_Trans_2.'.'.$model->Kd_Trans_3;
                }
            ],
            'Nm_Sub_Bidang',
            // 'Kd_sub_DAK',
            'Pagu:currency',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update}',//{view}{update}{delete}
                //'controller' => 'indikator',
                'buttons' =>[
                        'update' => function ($url, $model) {
                          return Html::a('<span class="label label-danger"><i class="glyphicon glyphicon-pencil"></i> Ubah</span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Update'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Penyesuaian Pagu Dana Transfer",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },                       
                ],                              
            ],
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
    'id' => 'myModalubah',
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
    $('#myModalubah').on('show.bs.modal', function (event) {
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