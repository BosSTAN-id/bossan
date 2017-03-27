<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="ta-rkas-kegiatan-index">

    <?= GridView::widget([
        'id' => 'ta-rkas-kegiatan',    
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
            'options' => ['id' => 'kegiatan-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            // 'sekolah_id',        
            [
                'label' => 'Kd Kegiatan',
                'value' => function($model){
                    return $model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2);
                }
            ],
            'refProgram.uraian_program',
            'refSubProgram.uraian_sub_program',
            'refKegiatan.uraian_kegiatan',
            [
                'label' => 'Sumber Dana',
                'value' => function($model){
                    return $model['penerimaan2']['uraian'] ? $model['penerimaan2']['uraian'] : '';
                }
            ],
            'pagu_anggaran:decimal',            
            [
                'label' => 'Pilih',
                'format' => 'raw',
                'value' => function($model){
                    return Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', 
                    ['listbelanja', 'id' => $model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2)], [
                        // 'data-pjax' => 0,
                        'class'=>'btn btn-default',
                        'title' => Yii::t('yii', 'ubah'),
                        // 'data-toggle'=>"modal",
                        // 'data-target'=>"#myModal",
                        // 'data-title'=> "Ubah Bukti",  
                        'onclick' => "
                                function (event) {
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
                                
                                "
                    ]);
                }
            ],
        ],
    ]); ?>
</div>