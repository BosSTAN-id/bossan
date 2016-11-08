<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\management\models\TaThSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Data Management');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-th-index">

    <p>
        <?= Html::a(Yii::t('app', 'Tambah Tahun'), ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Tahun Data",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-th',    
        'dataProvider' => $dataProvider,
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
            'options' => ['id' => 'data-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'tahun',
            [
                'attribute' => 'set_2',
                'format' => 'raw',
                'value' => function($model){
                    IF($model->set_2){
                        return \app\models\TaTh::dokudoku('bulat', $model->set_2).' '.
                        Html::a('<i class="glyphicon glyphicon-refresh"></i> Cek', ['cek', 'id' => $model->id, 'data' => 1], [
                                                        'class' => 'btn btn-xs btn-success pull-right',
                                                        'data-toggle'=>"modal",
                                                        'data-target'=>"#myModaldata",
                                                        'data-title'=>"Data Management Keuangan".$model->tahun,
                                                        ]);
                    }
                }
            ],
            [
                'attribute' => 'set_7',
                'value' => function($model){
                    return \app\models\TaTh::dokudoku('bulat', $model->set_7);
                }
            ],
            [
                'attribute' => 'set_4',
                'value' => function($model){
                    return \app\models\TaTh::dokudoku('bulat', $model->set_4);
                }
            ],
            [
                'attribute' => 'set_8',
                'value' => function($model){
                    return \app\models\TaTh::dokudoku('bulat', $model->set_8);
                }
            ],                           
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Data Management",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                ]
            ],
        ],
    ]); ?>
</div>
<?php Modal::begin([
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
Modal::begin([
    'id' => 'myModaldata',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModaldata').on('show.bs.modal', function (event) {
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