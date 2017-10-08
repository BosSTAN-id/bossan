<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="ref-rek-aset1-index">
    <?= GridView::widget([
        'id' => 'ref-rek-aset4',    
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
            'options' => ['id' => 'ref-rek-aset2-pjax', 'timeout' => 5000],
        ],
        'columns' => [
            [
                'attribute' => 'Kd_Aset3',
                'width' => '60px',
                'value' => function($model){
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3.'.'.$model->Kd_Aset4;
                }
            ],
            'Nm_Aset4',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{rek-aset5}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rek-aset5' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 5', $url,
                            [
                                'id' => 'rek5-'.$model->Kd_Aset1.$model->Kd_Aset2.$model->Kd_Aset3.$model->Kd_Aset4,
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
    $("a[id^='rek5-']").on("click", function(event){
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