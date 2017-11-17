<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefPotonganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-potongan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kd_potongan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_potongan')])->label(false) ?>

    <?= $form->field($model, 'nm_potongan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nm_potongan')])->label(false) ?>

    <?= $form->field($model, 'kd_map')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_map')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
