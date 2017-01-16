<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\penatausahaan\models\TaSPJSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Surat Permintaan Persetujuan Pendapatan dan Belanja (SP3B)';
$this->params['breadcrumbs'][] = 'Pelaporan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spj-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Buat SP3B', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Surat Pertanggungjawaban",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-spj',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
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
            'options' => ['id' => 'ta-spj-pjax', 'timeout' => 5000],
        ],
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->tahun.'~'.$model->no_sp3b];
        },             
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tahun',
            'no_sp3b',
            'keterangan',
            'tgl_sp3b',
            'pendapatan:decimal',
            'belanja:decimal',
            'status',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{print} {view} {update} {delete} {spjbukti}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'print' => function($url, $model){
                            return  Html::a('<i class="glyphicon glyphicon-print bg-white"></i>', $url, ['onClick' => "return !window.open(this.href, 'SPJ', 'width=1024,height=768')"]);
                        },
                        'update' => function ($url, $model) {
                          IF($model->status == 1 ){
                              return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                [  
                                    'title' => Yii::t('yii', 'ubah'),
                                    'data-toggle'=>"modal",
                                    'data-target'=>"#myModalubah",
                                    'data-title'=> "Ubah SPJ ".$model->no_sp3b,                                 
                                    // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                    // 'data-method' => 'POST',
                                    // 'data-pjax' => 1
                                ]);
                          }
                        },
                        'view' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'lihat'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "SPJ ".$model->no_sp3b,
                              ]);
                        },
                        'spjbukti' => function ($url, $model) {
                          return Html::a('Daftar SPJ <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Rincian SP3B'),
                                 'class'=>"btn btn-xs btn-default",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 'data-pjax' => 0
                              ]);
                        },                                               
                ]
            ],
        ],
    ]); ?>
</div>
<?php
//row click link
$this->registerJs("

    $('td').click(function (e) {
        var id = $(this).closest('tr').data('id').split('~');
        if(e.target == this)
            location.href = '" . \Yii\helpers\Url::to(['spjbukti']) . "?tahun=' + id[0] +'&no_spj=' + id[1];
    });

");
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