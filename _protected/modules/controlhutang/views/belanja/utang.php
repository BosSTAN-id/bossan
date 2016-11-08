<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sph-form">
    <i>Silahkan masukkan SPH Untuk belanja di atas.</i>
    <?php $form = ActiveForm::begin(); ?>   

    <?= $form->field($model, 'No_SPH')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($sph,'No_SPH','Nm_Perusahaan'),
                'options' => ['placeholder' => 'Pilih SPH ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>