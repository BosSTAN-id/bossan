<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
?>
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
                        'content' => Html::a('<i class="fa fa-plus"></i> Tambah', ['rek-aset2-tambah', 'Kd_Aset1' => $model->Kd_Aset1], [
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
                    'options' => ['id' => 'ref-rek-aset2-pjax', 'timeout' => 5000],
                ],
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
                        'template' => '{rek-aset2-update} {rek-aset2-delete} {rek-aset3}',
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
                                'rek-aset2-update' => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                                    [  
                                        'title' => Yii::t('yii', 'ubah'),
                                        'data-toggle'=>"modal",
                                        'data-target'=>"#myModal",
                                        'data-title'=> "Ubah",
                                    ]);
                                },  
                                'rek-aset2-delete' => function ($url, $model) {
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

<script>
    $("a[id^='rek3-']").on("click", function(e){
        e.preventDefault()
        var href = $(this).attr('href');
        $('#rek-2-tab').removeClass('active');
        $('#rek-3-tab').attr('class', 'active');
        $('#rek-2-content').removeClass('active in');
        $('#rek-3-content').addClass('active in');
        $('#rek-3-content').html('<i class=\"fa fa-spinner fa-spin\"></i>');
        $.post(href).done(function(data){
            $('#rek-3-content').html(data);
        });
    });    
</script>