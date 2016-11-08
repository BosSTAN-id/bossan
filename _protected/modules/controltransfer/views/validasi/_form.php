<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaValidasiPembayaran */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-validasi-pembayaran-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'Kd_Urusan')->textInput() ?>

    <?= $form->field($model, 'Kd_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_Unit')->textInput() ?>

    <?= $form->field($model, 'Kd_Sub')->textInput() ?>

    <?= $form->field($model, 'No_Validasi')->textInput() ?>

    <?= $form->field($model, 'Tgl_Validasi')->textInput() ?>

    <?= $form->field($model, 'No_SPM')->textInput() ?>

    <?= $form->field($model, 'No_RPH')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_1')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_2')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_3')->textInput() ?>

    <?= $form->field($model, 'Nm_Penandatangan')->textInput() ?>

    <?= $form->field($model, 'Jabatan_Penandatangan')->textInput() ?>

    <?= $form->field($model, 'NIP_Penandatangan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
