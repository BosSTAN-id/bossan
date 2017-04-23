<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefDesaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-desa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Prov')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Prov')])->label(false) ?>

    <?= $form->field($model, 'Kd_Kab_Kota')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Kab_Kota')])->label(false) ?>

    <?= $form->field($model, 'Kd_Kecamatan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Kecamatan')])->label(false) ?>

    <?= $form->field($model, 'Kd_Desa')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Desa')])->label(false) ?>

    <?= $form->field($model, 'Nm_Desa')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Nm_Desa')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
