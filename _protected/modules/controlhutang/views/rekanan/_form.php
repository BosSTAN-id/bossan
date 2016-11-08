<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rekanan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rekanan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Nm_Perusahaan')->textInput() ?>

    <?= $form->field($model, 'Alamat')->textInput() ?>

    <?= $form->field($model, 'Nm_Pemilik')->textInput() ?>

    <?= $form->field($model, 'NPWP')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
