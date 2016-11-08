<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPM */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spm-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'No_SPM')->textInput() ?>

    <?= $form->field($model, 'Kd_Urusan')->textInput() ?>

    <?= $form->field($model, 'Kd_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_Unit')->textInput() ?>

    <?= $form->field($model, 'Kd_Sub')->textInput() ?>

    <?= $form->field($model, 'No_SPP')->textInput() ?>

    <?= $form->field($model, 'Jn_SPM')->textInput() ?>

    <?= $form->field($model, 'Tgl_SPM')->textInput() ?>

    <?= $form->field($model, 'Uraian')->textInput() ?>

    <?= $form->field($model, 'Nm_Penerima')->textInput() ?>

    <?= $form->field($model, 'Bank_Penerima')->textInput() ?>

    <?= $form->field($model, 'Rek_Penerima')->textInput() ?>

    <?= $form->field($model, 'NPWP')->textInput() ?>

    <?= $form->field($model, 'Bank_Pembayar')->textInput() ?>

    <?= $form->field($model, 'Nm_Verifikator')->textInput() ?>

    <?= $form->field($model, 'Nm_Penandatangan')->textInput() ?>

    <?= $form->field($model, 'Nip_Penandatangan')->textInput() ?>

    <?= $form->field($model, 'Jbt_Penandatangan')->textInput() ?>

    <?= $form->field($model, 'Kd_Edit')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
