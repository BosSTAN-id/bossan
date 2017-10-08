<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\asettetap\models\TaAsetTetapBaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-aset-tetap-ba-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'no_ba')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_ba')])->label(false) ?>

    <?= $form->field($model, 'tgl_ba')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tgl_ba')])->label(false) ?>

    <?= $form->field($model, 'nm_penandatangan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nm_penandatangan')])->label(false) ?>

    <?php // echo $form->field($model, 'nip_penandatangan') ?>

    <?php // echo $form->field($model, 'jbt_penandatangan') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
