<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSetoranPotonganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-setoran-potongan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_setoran')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_setoran')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
