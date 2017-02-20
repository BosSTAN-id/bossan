<?php
use app\rbac\models\AuthItem;
use kartik\password\PasswordInput;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $user app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="user-form">

    <?php $form = ActiveForm::begin(['id' => 'form-user']); ?>
    <div class="row">
        <div class="col-md-12">
            <?= $form->field($user, 'passwordlama')->widget(PasswordInput::classname(), 
                    [
                        'options' => ['placeholder' => Yii::t('app', 'Password lama')],
                        'pluginOptions' => ['showMeter' => false]
                    ])->label(false) ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($user, 'password')->widget(PasswordInput::classname(), 
                    [
                        'options' => ['placeholder' => Yii::t('app', 'Password baru')],
                        'pluginOptions' => ['showMeter' => false]
                    ])->label(false) ?>
        </div>
    </div>

    <div class="form-group">     
        <?= Html::submitButton($user->isNewRecord ? Yii::t('app', 'Simpan') 
            : Yii::t('app', 'Ubah'), ['class' => $user->isNewRecord 
            ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
 
</div>
