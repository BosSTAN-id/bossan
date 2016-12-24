<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSaldoAwalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-saldo-awal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'keterangan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'keterangan')])->label(false) ?>

    <?= $form->field($model, 'nilai')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nilai')])->label(false) ?>

    <?= $form->field($model, 'Kd_Rek_1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_1')])->label(false) ?>

    <?php // echo $form->field($model, 'Kd_Rek_2') ?>

    <?php // echo $form->field($model, 'Kd_Rek_3') ?>

    <?php // echo $form->field($model, 'Kd_Rek_4') ?>

    <?php // echo $form->field($model, 'Kd_Rek_5') ?>

    <?php // echo $form->field($model, 'kd_penerimaan_1') ?>

    <?php // echo $form->field($model, 'kd_penerimaan_2') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
