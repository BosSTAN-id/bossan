<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\globalsetting\models\RefPenerimaanSekolah2Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-penerimaan-sekolah2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'kd_penerimaan_1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_penerimaan_1')])->label(false) ?>

    <?= $form->field($model, 'kd_penerimaan_2')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_penerimaan_2')])->label(false) ?>

    <?= $form->field($model, 'uraian')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'uraian')])->label(false) ?>

    <?= $form->field($model, 'abbr')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'abbr')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
