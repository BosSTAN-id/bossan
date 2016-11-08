<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaTransSKPDSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans-skpd-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Tahun') ?>

    <?= $form->field($model, 'Kd_Trans_1') ?>

    <?= $form->field($model, 'Kd_Trans_2') ?>

    <?= $form->field($model, 'Kd_Trans_3') ?>

    <?= $form->field($model, 'Kd_Urusan') ?>

    <?php // echo $form->field($model, 'Kd_Bidang') ?>

    <?php // echo $form->field($model, 'Kd_Unit') ?>

    <?php // echo $form->field($model, 'Kd_Sub') ?>

    <?php // echo $form->field($model, 'Pagu') ?>

    <?php // echo $form->field($model, 'Referensi_Dokumen') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
