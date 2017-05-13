<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwalPotongan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-saldo-awal-potongan-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'kd_potongan')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(
                \app\models\RefPotongan::find()->all()
                ,'kd_potongan','nm_potongan'),
            'options' => ['placeholder' => 'Pilih Jenis Potongan ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?= $form->field($model, 'nilai', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
                'clientOptions' => [
                    'alias' =>  'decimal',
                    'groupSeparator' => '.',
                    'radixPoint'=>',',                
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                ],
        ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#ta-saldo-awal-potongan-pjax'});
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