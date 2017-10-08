<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="ref-rek-aset1-index">
    <?= GridView::widget([
        'id' => 'ref-rek-aset2',    
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
        // 'pjax'=>true,
        // 'pjaxSettings'=>[
        //     'options' => ['id' => 'ref-rek-aset2-pjax', 'timeout' => 5000],
        // ],
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
                'template' => '{rek-aset3}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rek-aset3' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 3', $url,
                            [
                                'id' => 'rek3-'.$model->Kd_Aset1.$model->Kd_Aset2,
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
    $("a[id^='rek3-']").on("click", function(event){
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