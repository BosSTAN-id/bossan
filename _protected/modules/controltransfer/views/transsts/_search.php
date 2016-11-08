<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaTransStsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans-sts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Tahun') ?>

    <?= $form->field($model, 'Kd_Trans_1') ?>

    <?= $form->field($model, 'Kd_Trans_2') ?>

    <?= $form->field($model, 'Kd_Trans_3') ?>

    <?= $form->field($model, 'No_STS') ?>

    <?php // echo $form->field($model, 'Tgl_STS') ?>

    <?php // echo $form->field($model, 'Nilai') ?>

    <?php // echo $form->field($model, 'Rek_Penerima') ?>

    <?php // echo $form->field($model, 'Bank_Penerima') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
