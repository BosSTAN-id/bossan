<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaTh */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-th-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php
    echo $form->field($model, 'tahun')->textInput(['maxlength' => true]) ;
    IF($model->isNewRecord){
        echo $form->field($model, 'set_2')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_3')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_1')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_7')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_4')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_6')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_5')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_8')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_11')->textInput(['maxlength' => true]) ;
        echo $form->field($model, 'set_12')->textInput(['maxlength' => true]) ;       
    }ELSE{
        echo $form->field($model, 'set_2')->textInput(['maxlength' => true]);
        echo $form->field($model, 'set_3')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_1')->textInput([/*'value' => '',*/ 'maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_7')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_4')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_6')->textInput([ 'maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_5')->textInput([/*'value' => '',*/'maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_8')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_11')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
        echo $form->field($model, 'set_12')->textInput(['maxlength' => true,['placeholder' => 'Kosongkan Bila Tidak Berubah']]) ;
    }
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php IF($model->isNewRecord){

$script = <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#myModal").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#data-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
}ELSE{

$script = <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#myModalubah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#data-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
}
?>