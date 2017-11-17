<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\RefKegiatanSekolah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-kegiatan-sekolah-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php 
            echo $form->field($model, 'kd_program')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program,\' \',uraian_program) AS uraian_program'])->all(),'kd_program','uraian_program'),
                'options' => ['placeholder' => 'Pilih Program ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>

    <?= $form->field($model, 'kd_sub_program')->textInput() ?>

    <?= $form->field($model, 'uraian_sub_program')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php

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
                $.pjax.reload({container:'#ref-sub-program-sekolah-pjax'});
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