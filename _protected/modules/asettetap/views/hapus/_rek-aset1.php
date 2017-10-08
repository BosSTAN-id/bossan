<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
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
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
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
                'attribute' => 'Kd_Aset2',
                'width' => '60px',
                'value' => function($model){
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2;
                }
            ],
            'Nm_Aset2',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{rek-aset-3}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rek-aset3' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 2', $url,
                            [
                                'id' => 'rek2-'.$model->Kd_Aset1,
                                'title' => Yii::t('yii', 'ubah'),
                                'class' => 'btn btn-xs btn-default',
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
$this->registerJs(<<<JS
    $("a[id^='rek2-']").on("click", function(event){
        event.preventDefault();
        var href = $(this).attr("href");
        console.log(href);
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