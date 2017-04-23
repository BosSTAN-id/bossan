<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefKecamatanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-kecamatan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'Nm_Kecamatan')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'Nm_Kecamatan')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
