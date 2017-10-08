<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetapBa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-aset-tetap-ba-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'no_ba')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_ba')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'nm_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip_penandatangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jbt_penandatangan')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $script = <<<JS
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
                $.pjax.reload({container:'#ta-aset-tetap-ba-pjax'});
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
?>