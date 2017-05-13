<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Tabs;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\penatausahaan\models\TaSaldoAwalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Saldo Awal';
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-saldo-awal-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php 
    $gridKas = GridView::widget([
        'id' => 'ta-saldo-awal',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>[
            'type'=>'primary', 
            'heading'=> $this->title.
                        Html::a('Tambah Saldo Awal', ['create'], [
                                'class' => 'btn btn-xs btn-danger pull-right',
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=>"Tambah Saldo Awal",
                                ])
        ],
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
            'options' => ['id' => 'ta-saldo-awal-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Klasifikasi',
                'value' => 'penerimaan2.uraian'
            ],
            'keterangan',
            'nilai:decimal',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Lihat",
                              ]);
                        },                        
                ]
            ],
        ],
    ]);

    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Kas',
                'content' => $gridKas,
                'active' => true
            ],
            [
                'label' => 'Potongan',
                // 'url' => '/penatausahaan/saldoawalpotongan',
                'linkOptions'=>['id'=>'linkPotongan', 'data-url' => Url::to(['/penatausahaan/saldoawalpotongan/'], true)],
                'headerOptions' => [
                    // 'class'=>'disabled', 
                    'id' => 'Potongan'
                ]                
            ],
        ],
    ]);
    ?>
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
$tabScript = <<<JS
    $('#linkPotongan').on('click', function (e){
        $('#w1-tab1').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post($(this).attr('data-url')).done(function(data){
            $('#w1-tab1').html(data);
        })
    });
JS;
$this->registerJs($tabScript);
?>