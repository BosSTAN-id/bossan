<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="ref-rek-aset1-index">
    <?= GridView::widget([
        'id' => 'ref-rek-aset5',    
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
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3.'.'.$model->Kd_Aset4.'.'.$model->Kd_Aset5;
                }
            ],
            'Nm_Aset5',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{chooserek}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'chooserek' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 5', $url,
                            [
                                'id' => 'rek5-'.$model->Kd_Aset1.$model->Kd_Aset2.$model->Kd_Aset3.$model->Kd_Aset4.$model->Kd_Aset5,
                                'title' => Yii::t('yii', 'ubah'),
                                'class' => 'btn btn-xs btn-default',
                                'data-kode25' => $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3.'.'.$model->Kd_Aset4.'.'.$model->Kd_Aset5,
                                'data-nama-jenis' => $model->Nm_Aset5
                                // 'data-pjax' => 0
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
        var modal = $("#modalAset");
        var kode25 = $(this).attr("data-kode25");
        var namaJenis = $(this).attr("data-nama-jenis");
        // modalBody.html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href)
        .done(function( data ) {
            $("#taasettetap-kode25").val(kode25)
            $("#taasettetap-nama-jenis").val(namaJenis)
            // modal.hide();
            modal.modal('hide');
        });
    })
JS
);
?>