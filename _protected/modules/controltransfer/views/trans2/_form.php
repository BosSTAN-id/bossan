<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans2-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_1')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_2')->textInput() ?>

    <?= $form->field($model, 'Nm_Bidang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'Kd_Bid_DAK')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
