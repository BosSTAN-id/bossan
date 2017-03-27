<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

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
            'options' => ['id' => 'belanja-pjax', 'timeout' => 5000],
        ],        
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Kode Rekening',
                'value' => function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.substr('0'.$model->Kd_Rek_4, -2).'.'.substr('0'.$model->Kd_Rek_5, -2);
                }
            ],
            [
                'label' => 'Jenis',
                'group' => true,
                'value' => function($model){
                    return $model->refRek3->Nm_Rek_3;
                }
            ],
            [
                'label' => 'Kelompok',
                'group' => true,
                'value' => function($model){
                    return $model->refRek4->Nm_Rek_4;
                }
            ],            
            [
                'label' => 'Belanja',
                'attribute' => 'Nm_Rek_5',
                'value' => function($model){
                    return $model->Nm_Rek_5;
                }
            ],
            [
                'label' => 'Pilih',
                'format' => 'raw',
                'value' => function($model) use ($kd_program, $kd_sub_program, $kd_kegiatan){
                    return Html::a('<i class="glyphicon glyphicon-arrow-right"></i>', 'javascript:;', [
                        'data-pjax' => 0,
                        'class'=>'btn btn-default',
                        'onclick' => '
                                $("#myModal").modal(\'hide\'); //hide modal after submit
                                $("#taspjrinc-kd_program").val('.$kd_program.');
                                $("#taspjrinc-kd_sub_program").val('.$kd_sub_program.');
                                $("#taspjrinc-kd_kegiatan").val('.$kd_kegiatan.');
                                $("#taspjrinc-kd_rek_1").val('.$model->Kd_Rek_1.');
                                $("#taspjrinc-kd_rek_2").val('.$model->Kd_Rek_2.');
                                $("#taspjrinc-kd_rek_3").val('.$model->Kd_Rek_3.');
                                $("#taspjrinc-kd_rek_4").val('.$model->Kd_Rek_4.');
                                $("#taspjrinc-kd_rek_5").val('.$model->Kd_Rek_5.');
                                document.querySelector(\'span#kegiatan\').innerHTML = "<i>'.'Nama Kegiatan dong'.'</i>";
                                document.querySelector(\'span#belanja\').innerHTML = "<i>'.$model->Nm_Rek_5.'</i>";
                                '
                    ]);
                }
            ],          
        ],
    ]); ?>
</div>