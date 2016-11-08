<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaKontrakSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-kontrak-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Tahun') ?>

    <?= $form->field($model, 'No_Kontrak') ?>

    <?= $form->field($model, 'Kd_Urusan') ?>

    <?= $form->field($model, 'Kd_Bidang') ?>

    <?= $form->field($model, 'Kd_Unit') ?>

    <?php // echo $form->field($model, 'Kd_Sub') ?>

    <?php // echo $form->field($model, 'Kd_Prog') ?>

    <?php // echo $form->field($model, 'ID_Prog') ?>

    <?php // echo $form->field($model, 'Kd_Keg') ?>

    <?php // echo $form->field($model, 'Tgl_Kontrak') ?>

    <?php // echo $form->field($model, 'Keperluan') ?>

    <?php // echo $form->field($model, 'Waktu') ?>

    <?php // echo $form->field($model, 'Nilai') ?>

    <?php // echo $form->field($model, 'Nm_Perusahaan') ?>

    <?php // echo $form->field($model, 'Bentuk') ?>

    <?php // echo $form->field($model, 'Alamat') ?>

    <?php // echo $form->field($model, 'Nm_Pemilik') ?>

    <?php // echo $form->field($model, 'NPWP') ?>

    <?php // echo $form->field($model, 'Nm_Bank') ?>

    <?php // echo $form->field($model, 'Nm_Rekening') ?>

    <?php // echo $form->field($model, 'No_Rekening') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
