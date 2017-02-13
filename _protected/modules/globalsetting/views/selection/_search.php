<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\globalsetting\models\RefRek5Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek5-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Rek_1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_1')])->label(false) ?>

    <?= $form->field($model, 'Kd_Rek_2')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_2')])->label(false) ?>

    <?= $form->field($model, 'Kd_Rek_3')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_3')])->label(false) ?>

    <?= $form->field($model, 'Kd_Rek_4')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_4')])->label(false) ?>

    <?= $form->field($model, 'Kd_Rek_5')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Rek_5')])->label(false) ?>

    <?php // echo $form->field($model, 'Nm_Rek_5') ?>

    <?php // echo $form->field($model, 'Sekolah') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
