<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use kartik\tabs\TabsX;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */

$this->title = 'Bukti No: '.$model->no_bukti;
$this->params['breadcrumbs'][] = 'Penatausahaan';
$this->params['breadcrumbs'][] = ['label' => 'Belanja', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ta-spjrinc-view">
 
    <?php 
    $buktiContent = DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'enableEditMode' => false,
        'hideIfEmpty' => false, //sembunyikan row ketika kosong
        'panel'=>[
            'heading'=> Html::a('<i class="glyphicon glyphicon-pencil"></i> Ubah Bukti', ['update', 'tahun' => $model->tahun, 'no_bukti' => $model->no_bukti, 'tgl_bukti' => $model->tgl_bukti], [
                                'class' => 'btn btn-xs btn-success pull-right',
                                ]).'<i class="fa fa-tag"></i> '.$this->title.'</h3>',
            'type'=>'primary',
            'headingOptions' => [
                'tag' => 'h3', //tag untuk heading
            ],
        ],
        'buttons1' => '{update}', // tombol mode default, default '{update} {delete}'
        'buttons2' => '{save} {view}', // tombol mode kedua, default '{view} {reset} {save}'
        'viewOptions' => [
            'label' => '<span class="glyphicon glyphicon-remove-circle"></span>',
        ],                
        'attributes' => [
            [ 'attribute' => 'no_bukti', 'displayOnly' => true],
            [ 'attribute' => 'tgl_bukti', 'format'=> 'date', 'displayOnly' => true],
            [ 'attribute' => 'uraian', 'displayOnly' => true],
            [ 
                'attribute' => 'kd_program', 
                'value' => $model->refProgram['uraian_program'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'kd_sub_program', 
                'value' => $model->refSubProgram['uraian_sub_program'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'kd_kegiatan', 
                'value' => $model->refKegiatan['uraian_kegiatan'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'Kd_Rek_3', 
                'value' => $model->refRek3['Nm_Rek_3'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'Kd_Rek_5', 
                'value' => $model->refRek5['Nm_Rek_5'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'komponen_id', 
                'value' => $model->komponen['komponen'],
                'displayOnly' => true
            ],
            [ 
                'attribute' => 'pembayaran', 
                'value' => $model['pembayaran'] == 1 ? 'Bank' : 'Tunai',
                'displayOnly' => true
            ],
            [ 'attribute' => 'nilai', 'format' => 'decimal', 'displayOnly' => true],
            [ 'attribute' => 'nm_penerima', 'displayOnly' => true],
            [ 'attribute' => 'alamat_penerima', 'displayOnly' => true],
        ],
    ]);

    $potonganContent = '
        <div class="panel panel-default">
            <div class="panel-heading">Form Potongan</div>
            <div class="panel-body">
                Ini Form Potongan
            </div>
        </div>    
        <div class="panel panel-default">
            <div class="panel-heading">Grid Potongan</div>
            <div class="panel-body">
                Gridview Poto
            </div>
        </div>            
    ';

    // tab navigation
    echo TabsX::widget([
        'items'=>[
            [
                'label'=>'<i class="glyphicon glyphicon-folder-open"></i> Bukti',
                'content'=> $buktiContent,
                'active'=>true,
                'linkOptions'=>['id'=>'linkKecamatan'],
                'headerOptions' => ['id' => 'kecamatan']
            ],
            [
                'label'=>'<i class="glyphicon glyphicon-align-left"></i> Potongan',
                'content'=> $potonganContent,
                'linkOptions'=>['id'=>'linkKelurahan'],
                'headerOptions' => [
                    // 'class'=>'disabled', 
                    'id' => 'kelurahan'
                ]
            ],            
        ],
        'position'=>TabsX::POS_ABOVE,
        'bordered'=>true,
        'sideways'=>true,
        'encodeLabels'=>false
    ]);         
     ?>

</div>
