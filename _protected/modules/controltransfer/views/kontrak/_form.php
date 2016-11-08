<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaKontrak */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-kontrak-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'No_Kontrak')->textInput() ?>

    <?= $form->field($model, 'Kd_Urusan')->textInput() ?>

    <?= $form->field($model, 'Kd_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_Unit')->textInput() ?>

    <?= $form->field($model, 'Kd_Sub')->textInput() ?>

    <?= $form->field($model, 'Kd_Prog')->textInput() ?>

    <?= $form->field($model, 'ID_Prog')->textInput() ?>

    <?= $form->field($model, 'Kd_Keg')->textInput() ?>

    <?= $form->field($model, 'Tgl_Kontrak')->textInput() ?>

    <?= $form->field($model, 'Keperluan')->textInput() ?>

    <?= $form->field($model, 'Waktu')->textInput() ?>

    <?= $form->field($model, 'Nilai')->textInput() ?>

    <?= $form->field($model, 'Nm_Perusahaan')->textInput() ?>

    <?= $form->field($model, 'Bentuk')->textInput() ?>

    <?= $form->field($model, 'Alamat')->textInput() ?>

    <?= $form->field($model, 'Nm_Pemilik')->textInput() ?>

    <?= $form->field($model, 'NPWP')->textInput() ?>

    <?= $form->field($model, 'Nm_Bank')->textInput() ?>

    <?= $form->field($model, 'Nm_Rekening')->textInput() ?>

    <?= $form->field($model, 'No_Rekening')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
