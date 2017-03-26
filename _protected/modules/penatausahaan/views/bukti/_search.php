<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSPJRincSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spjrinc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'no_bukti')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_bukti')])->label(false) ?>

    <?= $form->field($model, 'tgl_bukti')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tgl_bukti')])->label(false) ?>

    <?= $form->field($model, 'no_spj')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_spj')])->label(false) ?>

    <?= $form->field($model, 'no_urut')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_urut')])->label(false) ?>

    <?php // echo $form->field($model, 'sekolah_id') ?>

    <?php // echo $form->field($model, 'kd_program') ?>

    <?php // echo $form->field($model, 'kd_sub_program') ?>

    <?php // echo $form->field($model, 'kd_kegiatan') ?>

    <?php // echo $form->field($model, 'Kd_Rek_1') ?>

    <?php // echo $form->field($model, 'Kd_Rek_2') ?>

    <?php // echo $form->field($model, 'Kd_Rek_3') ?>

    <?php // echo $form->field($model, 'Kd_Rek_4') ?>

    <?php // echo $form->field($model, 'Kd_Rek_5') ?>

    <?php // echo $form->field($model, 'komponen_id') ?>

    <?php // echo $form->field($model, 'pembayaran') ?>

    <?php // echo $form->field($model, 'nilai') ?>

    <?php // echo $form->field($model, 'nm_penerima') ?>

    <?php // echo $form->field($model, 'alamat_penerima') ?>

    <?php // echo $form->field($model, 'uraian') ?>

    <?php // echo $form->field($model, 'bank_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
