<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use dosamigos\ckeditor\CKEditorInline;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaPengumuman */
/* @var $form yii\widgets\ActiveForm */
// First we need to tell CKEDITOR variable where is our external plufin
?>

<div class="ta-pengumuman-form col-md-12">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?php
            echo $form->field($model, 'diumumkan_di')->widget(Select2::classname(), [
                'data' => [
                    1 => 'User SKPD',
                    2 => 'User SKPKD',
                    3 => 'Keduanya'
                ],
                // 'language' => 'de',
                'options' => ['placeholder' => 'Tampilkan Pada Dashboard ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);         
            ?>        
        </div>

        <div class="col-md-3">
        <?php echo $form->field($model, 'sticky')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Sticky',
                'offText' => 'Non-Sticky',
            ]        
        ])->label(false); ?>
        </div>

        <div class="col-md-3">
        <?php $model->published = true;
        echo $form->field($model, 'published')->widget(SwitchInput::classname(), [
            'pluginOptions' => [
                'onText' => 'Published',
                'offText' => 'Archived',
            ]        
        ])->label(false); ?>
        </div>
    </div>

    <?= $form->field($model, 'title')->textInput(['placeholder' => 'Judul ...'])->label(false) ?>

    <?php 
    echo $form->field($model, 'content')->widget(CKEditor::className(), [
            'options' => ['rows' => 6],
            'preset' => 'full', //basic, standard, full
            'clientOptions' => [
                'filebrowserUploadUrl' => 'upload'
            ]
        ])->label(false);
    ?>  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
