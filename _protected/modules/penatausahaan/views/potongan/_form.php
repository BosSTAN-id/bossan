<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaSetoranPotongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-setoran-potongan-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'tgl_setoran')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'id',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>
        </div>

        <div class="col-md-6 col-sm-12">
            <?= $form->field($model, 'no_setoran')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">
            <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-sm-12">    
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Save', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
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
                $.pjax.reload({container:'#ta-setoran-potongan-pjax'});
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