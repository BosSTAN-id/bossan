<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\globalsetting\models\RefKomponenBosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-komponen-bos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'komponen')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'komponen')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
