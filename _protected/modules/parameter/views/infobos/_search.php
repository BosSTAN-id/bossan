<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\TaInfoBosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-info-bos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'id')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'tahun_ajaran')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun_ajaran')])->label(false) ?>

    <?= $form->field($model, 'satuan_bos')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'satuan_bos')])->label(false) ?>

    <?= $form->field($model, 'jumlah_siswa')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'jumlah_siswa')])->label(false) ?>

    <?php // echo $form->field($model, 'jumlah_guru') ?>

    <?php // echo $form->field($model, 'jumlah_dana_bos') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
