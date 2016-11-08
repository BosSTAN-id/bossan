<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\management\models\TaThSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-th-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm','placeholder' => Yii::t('app', 'Tahun')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
