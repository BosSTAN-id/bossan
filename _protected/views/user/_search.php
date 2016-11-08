<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaTransSKPDSearch */
/* @var $form yii\widgets\ActiveForm */
?>



    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'username')])->label(false) ?>

    <?php ActiveForm::end(); ?>

