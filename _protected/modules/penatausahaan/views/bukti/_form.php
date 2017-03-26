<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spjrinc-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_bukti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_bukti')->textInput() ?>

    <?= $form->field($model, 'no_spj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_urut')->textInput() ?>

    <?= $form->field($model, 'sekolah_id')->textInput() ?>

    <?= $form->field($model, 'kd_program')->textInput() ?>

    <?= $form->field($model, 'kd_sub_program')->textInput() ?>

    <?= $form->field($model, 'kd_kegiatan')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_1')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_2')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_3')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_4')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_5')->textInput() ?>

    <?= $form->field($model, 'komponen_id')->textInput() ?>

    <?= $form->field($model, 'pembayaran')->textInput() ?>

    <?= $form->field($model, 'nilai')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nm_penerima')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_penerima')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bank_id')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
