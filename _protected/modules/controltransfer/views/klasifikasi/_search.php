<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaTrans3Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans3-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Tahun') ?>

    <?= $form->field($model, 'Kd_Trans_1') ?>

    <?= $form->field($model, 'Kd_Trans_2') ?>

    <?= $form->field($model, 'Kd_Trans_3') ?>

    <?= $form->field($model, 'Nm_Sub_Bidang') ?>

    <?php // echo $form->field($model, 'Kd_sub_DAK') ?>

    <?php // echo $form->field($model, 'Pagu') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
