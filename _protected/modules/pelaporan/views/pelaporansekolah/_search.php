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
<div class="col-md-12">
    <?php
    $checkParameter = \app\models\RefSekolah::findOne(['id' => Yii::$app->user->identity->sekolah_id]);
    if(!($checkParameter['kelurahan_id'])):
    ?>
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Perhatian!</h4>
        Sepertinya anda belum mengisi parameter Desa/Kelurahan sekolah anda. Isi parameter Desa/Kelurahan terlebih dahulu agar dapat mencetak laporan melalui menu <?= Html::a("<b>Parameter > Data Sekolah </b>", ['/parameter/datasekolah']) ?>
    </div>
    <?php endif;?>
<div class="box box-info">
<div class="box-body">
<div class="row col-md-12">
    <div class="col-md-4">
        <?php

            $model->Kd_Laporan = isset(Yii::$app->request->queryParams['Laporan']['Kd_Laporan']) ? Yii::$app->request->queryParams['Laporan']['Kd_Laporan'] : '';
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'data' => [
                    '1' => 'BOS-K1 Rencana Anggaran Pendapatan dan Belanja Sekolah',
                    '2' => 'BOS-K2 Rencana Kegiatan dan Anggaran',               
                    '3' => 'BOS-K3 Buku Kas Umum',
                    '4' => 'BOS-K4 Buku Pembantu Kas Tunai',
                    '5' => 'BOS-K5 Buku Pembantu Kas Bank',
                    '9' => 'BOS-K6 Buku Pembantu Pajak',   
                    '6' => 'BOS-K7 Realisasi Penggunaan Dana Tiap Jenis Anggaran',
                    '7' => 'BOS-K7A Realisasi Penggunaan Dana Tiap Komponen BOS',
                    '8' => 'BOS-03 Rencana Penggunaan dana BOS per Periode',
                    '10' => 'Form RKA OPD 2.2.1 (Rincian Pendapatan dan Belanja)',              
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
            $dataSumber = ArrayHelper::map(\app\models\RefPenerimaanSekolah2::find()->where(['sekolah' => 1])->andWhere('kd_penerimaan_1 != 1')->all(), 'kode', 'uraian');
            $dataSumber['0.0'] = 'Semua Dana';
            ksort($dataSumber);
            echo $form->field($model, 'Kd_Sumber')->widget(Select2::classname(), [
                'data' => $dataSumber,
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
            }ELSE{
                $model->Tgl_1 = $Tahun.'-01-01';
                $model->Tgl_2 = $Tahun.'-12-31';
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
            }ELSE{
                $model->Tgl_Laporan = $Tahun.'-12-31';
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
</div>
</div>
</div>

    <?php ActiveForm::end(); ?>
