<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\kasharian\models\TaDepositoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-deposito-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Deposito') ?>

    <?= $form->field($model, 'Nm_Bank') ?>

    <?= $form->field($model, 'No_Dokumen') ?>

    <?= $form->field($model, 'Tgl_Penempatan') ?>

    <?= $form->field($model, 'Tgl_Jatuh_Tempo') ?>

    <?php // echo $form->field($model, 'Suku_Bunga') ?>

    <?php // echo $form->field($model, 'Nilai') ?>

    <?php // echo $form->field($model, 'Keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
