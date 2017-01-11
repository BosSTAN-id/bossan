<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaSP3B */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sp3-b-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_sp3b')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_sp3b')->textInput() ?>

    <?= $form->field($model, 'saldo_awal')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pendapatan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'belanja')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'saldo_akhir')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jbt_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jumlah_sekolah')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#ta-sp3-b-pjax'});
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
                $.pjax.reload({container:'#ta-sp3-b-pjax'});
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