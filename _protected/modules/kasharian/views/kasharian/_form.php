<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaKasHarian */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-kas-harian-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
        //This is for SKPD dropdownlist in search ----@hoaaah
    //'Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Prog', 'ID_Prog', 'Kd_Urusan1', 'Kd_Bidang1'
        $connection = \Yii::$app->db;           
        $skpd = $connection->createCommand('SELECT Kd_Bank, Nm_Bank +\' - \'+ No_Rekening AS No_Rekening FROM Ref_Bank');
        $query = $skpd->queryAll();        
        echo $form->field($model, 'Kd_Bank')->widget(Select2::classname(), [
            'data' => ArrayHelper::map($query,'Kd_Bank','No_Rekening'),
            'options' => ['placeholder' => 'Pilih Bank ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
    ?>     

    <?= $form->field($model, 'Tanggal')->widget(
        DatePicker::className(), [
            // inline too, not bad
             'inline' => false, 
             // modify template for custom rendering
            //'template' => '<div class="well well-sm" style="background-color: #fff; width:250px">{input}</div>',
            'clientOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-m-d'
            ]
    ]);?>    

    <?= $form->field($model, 'Jumlah')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
