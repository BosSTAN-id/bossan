<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\parameter\models\RefSekolahSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sekolah-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'nama_sekolah')->textInput(
                ['class' => 'form-control input-sm pull-right','placeholder' => Yii::t('app', 'nama_sekolah')])->label(false) ?>

    <?php ActiveForm::end(); ?>

</div>
