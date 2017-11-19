<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\select2\Select2;

return [
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'width' => '20px',
    // ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],  
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'date',
        'attribute'=>'tgl_bukti',
        'group' => true,
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'no_bukti',
    ],
    [
        'label' => 'Kegiatan',
        'hAlign' => 'center',
        'value' => function($model){
            return $model->kd_program.'.'.substr('0'.$model->kd_sub_program, -2).'.'.substr('0'.$model->kd_kegiatan, -2);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'uraian',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'format' => 'decimal',
        'attribute'=>'nilai',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'filter' => Select2::widget([
                    // 'model' => $model,
                    // 'attribute' => 'pembayaran',
                    'name' => 'TaSPJRincSearch[pembayaran]',
                    'data' => [1 => 'Bank', 2 => 'Tunai'],
                    'theme' => Select2::THEME_BOOTSTRAP,
                    'options' => ['placeholder' => 'Metode...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
        'attribute'=>'pembayaran',
        'value' => function($model){
            return $model->pembayaran == 1 ? 'Bank' : 'Tunai';
        }
    ],
    [
        'label' => 'Sumber Dana',
        'value' => function($model){
            $rkasHistory = \app\models\TaRkasHistory::find()
                            ->where(['tahun' => $model->tahun, 'sekolah_id' => $model->sekolah_id, 'kd_program' => $model->kd_program, 'kd_sub_program' => $model->kd_sub_program, 'kd_kegiatan' => $model->kd_kegiatan, 'Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5, ])
                            ->andWhere('perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE tahun = '.$model->tahun.' AND sekolah_id = '.$model->sekolah_id.')')
                            ->one();
            return $rkasHistory['penerimaan2']['uraian'];
        }
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'visibleButtons' => [
            'delete' => function ($model, $key, $index) {
                return $model->no_spj == NULL ? true : false;
             },
             'update' => function ($model, $key, $index) {
                return $model->no_spj == NULL ? true : false;
             }
        ], 
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                // return Url::to([$action,'tahun, $no_bukti, $tgl_bukti'=>$key]);
                return Url::to([$action, 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti]);
        },
        'viewOptions'=>[
            // 'role'=>'modal-remote',
            'title'=>'View',
            // 'data-toggle'=>'tooltip'
        ],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'],
        'buttons' => [
            'update' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                //  'data-toggle'=>"modal",
                                //  'data-target'=>"#myModal",
                                //  'data-title'=> "Ubah",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
        ]
    ],

];