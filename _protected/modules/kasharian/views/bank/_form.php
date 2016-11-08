<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefBank */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-bank-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nm_Bank')->textInput() ?>

    <?= $form->field($model, 'No_Rekening')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
