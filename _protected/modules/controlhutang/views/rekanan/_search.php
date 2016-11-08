<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\RekananSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="rekanan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Rekanan') ?>

    <?= $form->field($model, 'Nm_Perusahaan') ?>

    <?= $form->field($model, 'Alamat') ?>

    <?= $form->field($model, 'Nm_Pemilik') ?>

    <?= $form->field($model, 'NPWP') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
