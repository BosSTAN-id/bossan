<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasPeraturan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rkas-peraturan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sekolah_id')->textInput() ?>

    <?= $form->field($model, 'perubahan_id')->textInput() ?>

    <?= $form->field($model, 'no_peraturan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_peraturan')->textInput() ?>

    <?= $form->field($model, 'penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'komite_sekolah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jabatan_komite')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'verifikasi')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
