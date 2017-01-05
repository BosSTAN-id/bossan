<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pelaporan\models\TaSP2BSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sp2-b-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'no_sp2b')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_sp2b')])->label(false) ?>

    <?= $form->field($model, 'no_sp3b')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_sp3b')])->label(false) ?>

    <?= $form->field($model, 'tgl_sp2b')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tgl_sp2b')])->label(false) ?>

    <?= $form->field($model, 'saldo_awal')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'saldo_awal')])->label(false) ?>

    <?php // echo $form->field($model, 'pendapatan') ?>

    <?php // echo $form->field($model, 'belanja') ?>

    <?php // echo $form->field($model, 'saldo_akhir') ?>

    <?php // echo $form->field($model, 'penandatangan') ?>

    <?php // echo $form->field($model, 'jbt_penandatangan') ?>

    <?php // echo $form->field($model, 'nip_penandatangan') ?>

    <?php // echo $form->field($model, 'jumlah_sekolah') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
