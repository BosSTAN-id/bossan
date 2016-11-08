<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaSPMSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spm-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Tahun') ?>

    <?= $form->field($model, 'No_SPM') ?>

    <?= $form->field($model, 'Kd_Urusan') ?>

    <?= $form->field($model, 'Kd_Bidang') ?>

    <?= $form->field($model, 'Kd_Unit') ?>

    <?php // echo $form->field($model, 'Kd_Sub') ?>

    <?php // echo $form->field($model, 'No_SPP') ?>

    <?php // echo $form->field($model, 'Jn_SPM') ?>

    <?php // echo $form->field($model, 'Tgl_SPM') ?>

    <?php // echo $form->field($model, 'Uraian') ?>

    <?php // echo $form->field($model, 'Nm_Penerima') ?>

    <?php // echo $form->field($model, 'Bank_Penerima') ?>

    <?php // echo $form->field($model, 'Rek_Penerima') ?>

    <?php // echo $form->field($model, 'NPWP') ?>

    <?php // echo $form->field($model, 'Bank_Pembayar') ?>

    <?php // echo $form->field($model, 'Nm_Verifikator') ?>

    <?php // echo $form->field($model, 'Nm_Penandatangan') ?>

    <?php // echo $form->field($model, 'Nip_Penandatangan') ?>

    <?php // echo $form->field($model, 'Jbt_Penandatangan') ?>

    <?php // echo $form->field($model, 'Kd_Edit') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
