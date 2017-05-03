<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSetoranPotonganRincSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-setoran-potongan-rinc-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'no_setoran')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_setoran')])->label(false) ?>

    <?= $form->field($model, 'kd_potongan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'kd_potongan')])->label(false) ?>

    <?= $form->field($model, 'nilai')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nilai')])->label(false) ?>

    <?php // echo $form->field($model, 'pembayaran') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
