<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans3-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_1')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_2')->textInput() ?>

    <?= $form->field($model, 'Kd_Trans_3')->textInput() ?>

    <?= $form->field($model, 'Nm_Sub_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_sub_DAK')->textInput() ?>

    <?= $form->field($model, 'Pagu')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
