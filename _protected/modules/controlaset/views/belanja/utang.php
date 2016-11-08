<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sph-form">
    <i>Silahkan pilih rekening aset untuk kapitalisasi ini.</i>
    <?php $form = ActiveForm::begin(); ?>   

    <?= $form->field($model, 'rekaset5')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'Kd_Rek_5','Nm_Rek_5'),
                'options' => ['placeholder' => 'Pilih Rekening Aset Tetap ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>