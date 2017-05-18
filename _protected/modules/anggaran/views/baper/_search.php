<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\anggaran\models\TaBaverSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-baver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_ba')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_ba')])->label(false) ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php ActiveForm::end(); ?>

</div>
