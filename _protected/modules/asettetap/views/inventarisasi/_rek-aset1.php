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
                'attribute' => 'Kd_Aset1',
                'width' => '60px',
                'value' => function($model){
                    return $model->Kd_Aset1;
                }
            ],
            'Nm_Aset1',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{rek-aset2}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rek-aset2' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 2', ['rek-aset2', 'Kd_Aset1' => $model->Kd_Aset1],
                            [
                                'id' => 'rek2-'.$model->Kd_Aset1,
                                'title' => Yii::t('yii', 'ubah'),
                                'class' => 'btn btn-xs btn-default',
                                // 'data-pjax' => 1
                            ]);
                        },                       
                ]
            ],
        ],
    ]); ?>
</div>
<?php 
$this->registerJs(<<<JS
    $("a[id^='rek2-']").on("click", function(event){
        event.preventDefault();
        var href = $(this).attr("href");
        var modalBody = $("#modalAset .modal-body");
        modalBody.html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href)
        .done(function( data ) {
            modalBody.html(data)
        });
    })
JS
);
?>