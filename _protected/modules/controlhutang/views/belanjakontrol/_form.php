<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaRASKArsipHutang */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-raskarsip-hutang-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'Tahun')->textInput() ?>

    <?= $form->field($model, 'Kd_Urusan')->textInput() ?>

    <?= $form->field($model, 'Kd_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_Unit')->textInput() ?>

    <?= $form->field($model, 'Kd_Sub')->textInput() ?>

    <?= $form->field($model, 'Kd_Prog')->textInput() ?>

    <?= $form->field($model, 'ID_Prog')->textInput() ?>

    <?= $form->field($model, 'Kd_Keg')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_1')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_2')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_3')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_4')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_5')->textInput() ?>

    <?= $form->field($model, 'No_Rinc')->textInput() ?>

    <?= $form->field($model, 'No_ID')->textInput() ?>

    <?= $form->field($model, 'Keterangan_Rinc')->textInput() ?>

    <?= $form->field($model, 'Sat_1')->textInput() ?>

    <?= $form->field($model, 'Nilai_1')->textInput() ?>

    <?= $form->field($model, 'Sat_2')->textInput() ?>

    <?= $form->field($model, 'Nilai_2')->textInput() ?>

    <?= $form->field($model, 'Sat_3')->textInput() ?>

    <?= $form->field($model, 'Nilai_3')->textInput() ?>

    <?= $form->field($model, 'Satuan123')->textInput() ?>

    <?= $form->field($model, 'Jml_Satuan')->textInput() ?>

    <?= $form->field($model, 'Nilai_Rp')->textInput() ?>

    <?= $form->field($model, 'Total')->textInput() ?>

    <?= $form->field($model, 'Keterangan')->textInput() ?>

    <?= $form->field($model, 'Kd_Ap_Pub')->textInput() ?>

    <?= $form->field($model, 'Kd_Sumber')->textInput() ?>

    <?= $form->field($model, 'Kd_Status_Belanja')->textInput() ?>

    <?= $form->field($model, 'No_SPH')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
