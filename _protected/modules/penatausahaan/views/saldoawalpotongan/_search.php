<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSaldoAwalPotonganSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-saldo-awal-potongan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'kd_potongan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_potongan')])->label(false) ?>

    <?= $form->field($model, 'nilai')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nilai')])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
