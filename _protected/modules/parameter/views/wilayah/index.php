<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\parameter\models\RefKecamatanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wilayah';
$this->params['breadcrumbs'][] = 'Parameter';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ref-kecamatan-index">
    <?php
        $kecamatanContent =  GridView::widget([
            'id' => 'ref-kecamatan',    
            'dataProvider' => $dataProvider,
            'export' => false, 
            'responsive'=>true,
            'hover'=>true,
            'striped' => true,
            'resizableColumns'=>true,
            // 'panel'=>['type'=>'primary', 'heading'=> Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Kecamatan', ['create'], [
            //                                             'class' => 'btn btn-xs btn-success',
            //                                             'data-toggle'=>"modal",
            //                                             'data-target'=>"#myModal",
            //                                             'data-title'=>"Tambah Kecamatan",
            //                                             ])
            // ],
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
                'options' => ['id' => 'ref-kecamatan-pjax', 'timeout' => 5000],
            ],        
            // 'filterModel' => $searchModel,
            'rowOptions'   => function ($model, $key, $index, $grid) {
                return ['data-id' => $model->Kd_Kecamatan];
            },                   
            'columns' => [
                ['class' => 'kartik\grid\SerialColumn'],
                'Kd_Kecamatan',
                'Nm_Kecamatan',

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

    // tab navigation
    echo TabsX::widget([
        'items'=>[
            [
                'label'=>'<i class="glyphicon glyphicon-home"></i> Kecamatan',
                'content'=>Html::a('<i class="glyphicon glyphicon-plus"></i> Tambah Kecamatan', ['create'], [
                                'class' => 'btn btn-xs btn-success',
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=>"Tambah Kecamatan",
                                ]).
                            $kecamatanContent,
                'active'=>true,
                'linkOptions'=>['id'=>'linkKecamatan'],
                'headerOptions' => ['id' => 'kecamatan']
            ],
            [
                'label'=>'<i class="glyphicon glyphicon-tree-deciduous"></i> Desa/Kelurahan',
                'content'=> '....',
                'linkOptions'=>['id'=>'linkKelurahan'],
                // 'linkOptions'=>['data-url'=>\yii\helpers\Url::to(['/site/tabs-data'])]
                'headerOptions' => [
                    // 'class'=>'disabled', 
                    'id' => 'kelurahan'
                ]
            ],            
        ],
        'position'=>TabsX::POS_LEFT,
        'bordered'=>true,
        'sideways'=>true,
        'encodeLabels'=>false
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

//row click link
$this->registerJs("

    $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        if(e.target == this)
            var href = '" . \Yii\helpers\Url::to(['kelurahan']) . "?Kd_Kecamatan=' + id;
            $('#kecamatan').removeClass('active');
            // $('#kecamatan').attr('class', 'disabled');
            $('#kecamatan').html('<a href=\"#w2-tab0\"  data-toggle=\"tab\" role=\"tab\" title=\"Kecamatan\"><i class=\"glyphicon glyphicon-home\"></i> Kecamatan</a>');
            $('#kelurahan').attr('class', 'active');

            $('#linkKecamatan').click();
            $('#w2-tab0').removeClass('active in');
            $('#w2-tab1').addClass('active in');
            $('#w2-tab1').html('<i class=\"fa fa-spinner fa-spin\"></i>');
            $.get(href).done(function(data){
                $('#w2-tab1').html(data);
            });
    });  

");

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