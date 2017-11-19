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
                'content' => Html::a('<i class="fa fa-plus"></i> Tambah', ['rek-aset5-tambah', 'Kd_Aset1' => $model->Kd_Aset1, 'Kd_Aset2' => $model->Kd_Aset2, 'Kd_Aset3' => $model->Kd_Aset3, 'Kd_Aset4' => $model->Kd_Aset4], [
                    'class' => 'btn btn-xs btn-default',
                    'title' => 'Tambah',
                    'data-toggle'=>"modal",
                    'data-target'=>"#myModal",
                    'data-title'=> "Tambah",
                ]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'ref-rek-aset5-pjax', 'timeout' => 5000],
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
                'template' => '{rek-aset5-update} {rek-aset5-delete}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                    'rek-aset5-update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                        [  
                            'title' => Yii::t('yii', 'ubah'),
                            'data-toggle'=>"modal",
                            'data-target'=>"#myModal",
                            'data-title'=> "Ubah",
                        ]);
                    },  
                    'rek-aset5-delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                        [  
                            'title' => Yii::t('yii', 'delete'),                              
                            'data-confirm' => "Yakin menghapus ini?",
                            'data-method' => 'POST',
                            'data-pjax' => 1
                        ]);
                    },                    
                ]
            ],
        ],
    ]); ?>
</div>
<?php
$this->registerJs(<<<JS
    $("a[id^='rek-5-']").on("click", function(event){
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