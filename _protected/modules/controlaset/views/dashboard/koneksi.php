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
      <h3 class="box-title">Koneksi</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
      </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'adi')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'SQLVersion'])->label(false) ?>

        <?= $form->field($model, 'erzo')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'ServerName'])->label(false) ?>          

        <?= $form->field($model, 'isbandi')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Username'])->label(false) ?>

        <?= $form->field($model, 'bram')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Password'])->label(false) ?>


        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>  
</div>
