<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefRekAset1Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek-aset1-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Aset1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Kd_Aset1')])->label(false) ?>

    <?= $form->field($model, 'Nm_Aset1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Nm_Aset1')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
