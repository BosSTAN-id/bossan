<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use fedemotta\datatables\DataTables;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="ta-rkas-kegiatan-index">

    <?php
    echo DataTables::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                    // ['listbelanja', 'id' => $model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2)]
                    '#'
                    , [
                        // 'data-pjax' => 0,
                        'class'=>'btn btn-default',
                        'title' => Yii::t('yii', 'ubah'),
                        'data-href' => Url::to(['listbelanja', 'id' => $model['kd_program'].'.'.substr('0'.$model['kd_sub_program'], -2).'.'.substr('0'.$model['kd_kegiatan'], -2)], true),
                        'id' => 'belanja-'.$model->kd_program.'.'.$model->kd_sub_program.'.'.$model->kd_kegiatan,
                    ]);
                }
            ],            
        ],
    ]);
    ?>
</div>
<script>
    $( "a[id^='belanja-']" ).on('click', function(event){
        var button = $(event.relatedTarget);
        var modal = $('#myModal');
        var href = $(this).attr('data-href');
        $.post(href)
        .done(function( data ) {
            modal.find('.modal-body').html(data)
        }); 
    }); 
</script>