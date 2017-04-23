<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\RefDesa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-desa-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'Kd_Desa')->textInput() ?>

    <?= $form->field($model, 'Nm_Desa')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$url = \Yii\helpers\Url::to(['/parameter/wilayah/kelurahan']);
IF($model->isNewRecord){
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
                var href = '$url?Kd_Kecamatan=' + $Kd_Kecamatan;
                $("#myModal").modal('hide'); //hide modal after submit
                $('#w2-tab1').html('<i class=\"fa fa-spinner fa-spin\"></i>');
                $.get(href).done(function(data){
                    $('#w2-tab1').html(data);
                    console.log('voila kelurahan');
                });
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
                var href = '$url?Kd_Kecamatan=' + $Kd_Kecamatan;
                $("#myModalubah").modal('hide'); //hide modal after submit
                $('#w2-tab1').html('<i class=\"fa fa-spinner fa-spin\"></i>');
                $.get(href).done(function(data){
                    $('#w2-tab1').html(data);
                    console.log('voila kelurahan');
                });
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