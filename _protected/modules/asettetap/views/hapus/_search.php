<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\asettetap\models\TaAsetTetapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-aset-tetap-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Kd_Aset1')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Keterangan')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
