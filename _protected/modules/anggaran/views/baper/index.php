<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\bootstrap\Button;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaBaverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Berita Acara Verifikasi';
$this->params['breadcrumbs'][] = 'Anggaran';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-baver-index">

    <p>
        <?= Html::a('Tambah Berita Acara', ['create'], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Berita Acara",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-baver',    
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
        'rowOptions'   => function ($model, $key, $index, $grid) {
            return ['data-id' => $model->tahun.'^'.$model->no_ba.'^abc'];
        },
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ta-baver-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            'tahun',
            'no_ba',
            'tgl_ba',
            // 'verifikatur',
            // 'nip_verifikatur',
            // 'penandatangan',
            // 'jabatan_penandatangan',
            // 'nip_penandatangan',
            // 'status',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function($model){
                    // '<i class="fa fa-refresh fa-spin"></i>' untuk spin loading
                    if($model->status == 1){
                        $status = 'Final';
                    }else{
                        $status = 'Draft';
                    }
                    return Button::widget([
                        'id' => 'status-'.$model->no_ba,
                        'label' => $status,
                        'encodeLabel' => false,
                        'options' => [
                            'class' => 'btn-default btn-xs',
                            'data-url' => Url::to(['baper/status', 'no_ba' => $model->no_ba], true),
                        ],
                    ])
                    // .
                    // '<div class="overlay">
                    //     <i class="fa fa-refresh fa-spin"></i>
                    // </div>'
                    ;
                }
            ],

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{view} {update} {delete} {rincian}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
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
                        'rincian' => function ($url, $model) {
                          return Html::a('Lampiran RKAS <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Daftar RKAS Terlampir'),
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
        var id = $(this).closest('tr').data('id').split('^');
        if(e.target == this)
            location.href = '" . \Yii\helpers\Url::to(['rincian']) . "?tahun=' + id[0] +'&no_ba=' + id[1];
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
?>