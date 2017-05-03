<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

?>
<div class="ta-setoran-potongan-rinc-index">

    <p>
        <?= Html::a('Tambah Item Potongan', ['potonganrinc/create', 'tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'no_setoran' => $model->no_setoran], [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'data-toggle'=>"modal",
                                                    'data-target'=>"#myModal",
                                                    'data-title'=>"Tambah Item Potongan",
                                                    ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-setoran-potongan-rinc',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=> 'Item Setoran Potongan '.$this->title],
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
            'options' => ['id' => 'ta-setoran-potongan-rinc-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            'kdPotongan.nm_potongan',
            [
                'attribute' => 'pembayaran',
                'format' => 'raw',
                'value' => function($model){
                    switch ($model->pembayaran) {
                        case 1:
                            return '<i class="fa fa-bank"></i> Bank';
                            break;
                        case 2:
                            return '<i class="fa fa-money"></i> Tunai';
                            break;   
                        default:
                            # code...
                            break;
                    }
                }
            ],
            'keterangan',
            'nilai:decimal',

            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{update} {delete}',
                'controller' => 'potonganrinc',
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