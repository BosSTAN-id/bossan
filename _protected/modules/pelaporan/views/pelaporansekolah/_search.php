<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\TaProgram;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaRASKArsipSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

<div class="row col-md-12">
    <div class="col-md-4">
        <?php

            $model->Kd_Laporan = isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) ? Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] : '';
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'data' => [
                    '1' => 'BOS-K1 Rencana Anggaran Pendapatan dan Belanja Sekolah',
                    '2' => 'BOS-K2 Rencana Kegiatan dan Anggaran',               
                    '3' => 'BOS-K3 Buku Kas Umum',
                    // '4' => 'BOS-K4 Buku Pembantu Kas Tunai',
                    // '5' => 'BOS-K5 Buku Pembantu Kas Bank',
                    '6' => 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran',
                    '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    // '8' => 'BOS-03 Rencana Penggunaan dana BOS per Periode',                 
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Jenis Laporan ...', 
                // 'onchange'=> 'this.form.submit()'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>
    </div>
    <div class="col-md-3">
        <?php

            $model->Kd_Sumber = isset(Yii::$app->request->queryParams['Laporan']['Kd_Sumber']) ? Yii::$app->request->queryParams['Laporan']['Kd_Sumber'] : '';
            echo $form->field($model, 'Kd_Sumber')->widget(Select2::classname(), [
                'data' => [
                    '0.0' => 'Semua Dana',
                    '3.2' => 'Dana BOS',
                    '4.5' => 'Program Sekolah Gratis Provinsi',               
                    // '3' => 'BOS-K3 Buku Kas Umum',
                    // '4' => 'BOS-K4 Buku Pembantu Kas Tunai',
                    // '5' => 'BOS-K5 Buku Pembantu Kas Bank',
                    // '6' => 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran',
                    // '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    // '8' => 'BOS-03 Rencana Penggunaan dana BOS per Periode',                 
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Sumber Dana ...', 
                // 'onchange'=> 'this.form.submit()'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>
    </div>
    <div class="col-md-3">
        <?php
            if(isset(Yii::$app->request->queryParams['Laporan']['Tgl_1'])){
                $model->Tgl_1 = Yii::$app->request->queryParams['Laporan']['Tgl_1'];
                $model->Tgl_2 = Yii::$app->request->queryParams['Laporan']['Tgl_2'];                
            }

            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'Tgl_1',
                'attribute2' => 'Tgl_2',
                'type' => DatePicker::TYPE_RANGE,
                'options' => ['placeholder' => 'Mulai'],
                'options2' => ['placeholder' => 'Sampai'],                
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd'
                ],
                // 'readonly' => true,
                'layout' => '{input1}{separator}{input2}',
            ]);               
        ?>    
    </div>
    <div class="col-md-2">
        <?php
            if(isset(Yii::$app->request->queryParams['Laporan']['Tgl_Laporan'])){
                $model->Tgl_Laporan = Yii::$app->request->queryParams['Laporan']['Tgl_Laporan'];             
            }

            echo DatePicker::widget([
                'model' => $model,
                'attribute' => 'Tgl_Laporan',
                'type' => DatePicker::TYPE_INPUT,
                'options' => ['placeholder' => 'Tanggal Laporan'],              
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd',
                ],
            ]);               
        ?>    
    </div>    
</div>
<div class="row col-md-12">   
    <div class="col-md-3">
        <?php

            $model->perubahan_id = isset(Yii::$app->request->queryParams['Laporan']['perubahan_id']) ? Yii::$app->request->queryParams['Laporan']['perubahan_id'] : '';
            echo $form->field($model, 'perubahan_id')->widget(Select2::classname(), [
                'data' => [
                    3 => 'Rancangan RKAS/APBS',
                    4 => 'RKAS/APBS Induk',
                    6 => 'RKAS/APBS Perubahan I',               
                    // '3' => 'BOS-K3 Buku Kas Umum',
                    // '4' => 'BOS-K4 Buku Pembantu Kas Tunai',
                    // '5' => 'BOS-K5 Buku Pembantu Kas Bank',
                    // '6' => 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran',
                    // '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    // '8' => 'BOS-03 Rencana Penggunaan dana BOS per Periode',                 
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Riwayat ...', 
                // 'onchange'=> 'this.form.submit()'
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>
    </div>
    <div class="col-md-2 pull-right">
        <?= Html::submitButton( 'Pilih', ['class' => 'btn btn-default']) ?>        
    </div>
</div>

    <?php ActiveForm::end(); ?>
