<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
<div class="ref-rek-aset1-index">
    <?= GridView::widget([
        'id' => 'ref-rek-aset3',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                'content' => Html::a('<i class="fa fa-plus"></i> Tambah', ['rek-aset3-tambah', 'Kd_Aset1' => $model->Kd_Aset1, 'Kd_Aset2' => $model->Kd_Aset2], [
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
            'options' => ['id' => 'ref-rek-aset3-pjax', 'timeout' => 5000],
        ],
        'columns' => [
            [
                'attribute' => 'Kd_Aset3',
                'width' => '60px',
                'value' => function($model){
                    return $model->Kd_Aset1.'.'.$model->Kd_Aset2.'.'.$model->Kd_Aset3;
                }
            ],
            'Nm_Aset3',
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{rek-aset3-update} {rek-aset3-delete} {rek-aset4}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'rek-aset4' => function($url, $model){
                            return Html::a('<span class="glyphicon glyphicon-forward"></span> Rek 4', $url,
                            [
                                'id' => 'rek4-'.$model->Kd_Aset1.$model->Kd_Aset2.$model->Kd_Aset3,
                                'title' => Yii::t('yii', 'ubah'),
                                'class' => 'btn btn-xs btn-default rek4',
                                // 'data-pjax' => 1
                            ]);
                        },
                        'rek-aset3-update' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                            [  
                                'title' => Yii::t('yii', 'ubah'),
                                'data-toggle'=>"modal",
                                'data-target'=>"#myModal",
                                'data-title'=> "Ubah",
                            ]);
                        },  
                        'rek-aset3-delete' => function ($url, $model) {
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
    $("a[id^='rek4-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#rek-3-tab').removeClass('active');
        $('#rek-4-tab').attr('class', 'active');
        $('#rek-3-content').removeClass('active in');
        $('#rek-4-content').addClass('active in');
        $('#rek-4-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#rek-4-content').html(data);
        });
    });    
</script>