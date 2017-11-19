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
                'content' => Html::a('<i class="fa fa-plus"></i> Tambah', ['rek-aset4-tambah', 'Kd_Aset1' => $model->Kd_Aset1, 'Kd_Aset2' => $model->Kd_Aset2, 'Kd_Aset3' => $model->Kd_Aset3], [
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
            'options' => ['id' => 'ref-rek-aset4-pjax', 'timeout' => 5000],
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
                'template' => '{rek-aset4-update} {rek-aset4-delete} {rek-aset5}',
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
                        'rek-aset4-update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                            [  
                                'title' => Yii::t('yii', 'ubah'),
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=> "Ubah",
                            ]);
                        },  
                        'rek-aset4-delete' => function ($url, $model) {
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
<script>
    $("a[id^='rek5-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#rek-4-tab').removeClass('active');
        $('#rek-5-tab').attr('class', 'active');
        $('#rek-4-content').removeClass('active in');
        $('#rek-5-content').addClass('active in');
        $('#rek-5-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#rek-5-content').html(data);
        });
    });    
</script>