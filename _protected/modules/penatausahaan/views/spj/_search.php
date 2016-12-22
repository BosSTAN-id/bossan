<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\penatausahaan\models\TaSPJSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spj-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tahun')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tahun')])->label(false) ?>

    <?= $form->field($model, 'no_spj')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_spj')])->label(false) ?>

    <?= $form->field($model, 'sekolah_id')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'sekolah_id')])->label(false) ?>

    <?= $form->field($model, 'tgl_spj')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'tgl_spj')])->label(false) ?>

    <?= $form->field($model, 'no_bku')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'no_bku')])->label(false) ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'kd_sah') ?>

    <?php // echo $form->field($model, 'no_pengesahan') ?>

    <?php // echo $form->field($model, 'disahkan_oleh') ?>

    <?php // echo $form->field($model, 'nip_pengesahan') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'nm_bendahara') ?>

    <?php // echo $form->field($model, 'nip_bendahara') ?>

    <?php // echo $form->field($model, 'jbt_bendahara') ?>

    <?php // echo $form->field($model, 'jbt_pengesahan') ?>

    <?php // echo $form->field($model, 'tgl_pengesahan') ?>

    <?php // echo $form->field($model, 'kd_verifikasi') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
