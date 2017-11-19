<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefRekAset1Search */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Rekening Aset Tetap';
$this->params['breadcrumbs'][] = 'Parameter';
$this->params['breadcrumbs'][] = $this->title;
?>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li id="rek-1-tab" role="presentation" class="active"><a href="#rek-1-content" aria-controls="rek-1-content" role="tab" data-toggle="tab">Kode Aset 1</a></li>
    <li id="rek-2-tab" role="presentation"><a href="#rek-2-content" aria-controls="rek-2-content" role="tab" data-toggle="tab">Kode Aset 2</a></li>
    <li id="rek-3-tab" role="presentation"><a href="#rek-3-content" aria-controls="rek-3-content" role="tab" data-toggle="tab">Kode Aset 3</a></li>
    <li id="rek-4-tab" role="presentation"><a href="#rek-4-content" aria-controls="rek-4-content" role="tab" data-toggle="tab">Kode Aset 4</a></li>
    <li id="rek-5-tab" role="presentation"><a href="#rek-5-content" aria-controls="rek-5-content" role="tab" data-toggle="tab">Kode Aset 5</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="rek-1-content">
        <div class="ref-rek-aset1-index">
            <?= GridView::widget([
                'id' => 'ref-rek-aset1',    
                'dataProvider' => $dataProvider,
                'export' => false, 
                'responsive'=>true,
                'hover'=>true,     
                'resizableColumns'=>true,
                'panel'=>['type'=>'primary', 'heading'=>$this->title],
                'responsiveWrap' => false,        
                'toolbar' => [
                    [
                        // 'content' => Html::a('<i class="fa fa-plus"></i> Tambah', ['create'], [
                        //     'class' => 'btn btn-xs btn-default',
                        //     'title' => 'Tambah',
                        //     'data-toggle'=>"modal",
                        //     'data-target'=>"#myModal",
                        //     'data-title'=> "Lihat",
                        // ]),
                    ],
                ],       
                'pager' => [
                    'firstPageLabel' => 'Awal',
                    'lastPageLabel'  => 'Akhir'
                ],
                'pjax'=>true,
                'pjaxSettings'=>[
                    'options' => ['id' => 'ref-rek-aset1-pjax', 'timeout' => 5000],
                ],        
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'attribute' => 'Kd_Aset1',
                        'width' => '60px',
                    ],
                    'Nm_Aset1',

                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{rek-aset2} ',
                        'noWrap' => true,
                        'vAlign'=>'top',
                        'buttons' => [
                                'rek-aset2' => function($url, $model){
                                    return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 2', ['rek-aset2', 'Kd_Aset1' => $model->Kd_Aset1],
                                    [
                                        'id' => 'rek2-'.$model->Kd_Aset1,
                                        'title' => Yii::t('yii', 'ubah'),
                                        'class' => 'btn btn-xs btn-default',
                                        // 'data-pjax' => 0
                                    ]);
                                },
                                'update' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                    [  
                                        'title' => Yii::t('yii', 'ubah'),
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#myModal",
                                        'data-title'=> "Ubah",                                 
                                        // 'data-confirm' => "Yakin menghapus ini?",
                                        // 'data-method' => 'POST',
                                        // 'data-pjax' => 1
                                    ]);
                                },
                                'view' => function ($url, $model) {
                                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                                    [  
                                        'title' => Yii::t('yii', 'lihat'),
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#myModal",
                                        'data-title'=> "Lihat",
                                    ]);
                                },                        
                        ]
                    ],
                ],
            ]); ?>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="rek-2-content">...</div>
    <div role="tabpanel" class="tab-pane" id="rek-3-content">...</div>
    <div role="tabpanel" class="tab-pane" id="rek-4-content">...</div>
    <div role="tabpanel" class="tab-pane" id="rek-5-content">...</div>
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
$this->registerJs(<<<JS
    $("a[id^='rek2-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#rek-1-tab').removeClass('active');
        $('#rek-2-tab').attr('class', 'active');
        $('#rek-1-content').removeClass('active in');
        $('#rek-2-content').addClass('active in');
        $('#rek-2-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#rek-2-content').html(data);
        });
    })

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
JS
);
?>