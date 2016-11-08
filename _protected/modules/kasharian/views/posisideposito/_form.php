<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaDeposito */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-deposito-form">
<div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Deposito</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'Nm_Bank')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Nama Bank'])->label(false) ?>

        <?= $form->field($model, 'No_Dokumen')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Nomor Dokumen'])->label(false) ?>

        <?= $form->field($model, 'Tgl_Penempatan')->widget(
            DatePicker::className(), [
                 'inline' => false, 
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
        ]);?>

        <?= $form->field($model, 'Tgl_Jatuh_Tempo')->widget(
            DatePicker::className(), [
                 'inline' => false, 
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
        ]);?>            

        <?= $form->field($model, 'Suku_Bunga')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Suku Bunga'])->label(false) ?>

        <?= $form->field($model, 'Nilai')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Nilai'])->label(false) ?>

        <?= $form->field($model, 'Keterangan')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Keterangan'])->label(false) ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>  
</div>
