<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TaMutasiKas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-mutasi-kas-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php 
    echo $form->field($model, 'kd_mutasi')->widget(Select2::classname(), [
        'data' => [
                1 => 'Bank ke Kas Tunai',
                2 => 'Kas Tunai ke Bank',
            ],
        // 'language' => 'de',
        'options' => ['placeholder' => 'Tipe Mutasi ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);
    ?>

    <?= $form->field($model, 'no_bukti')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tgl_bukti')->widget(\yii\jui\DatePicker::classname(), [
            'language' => 'id',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
        ]) ?> 

    <?= $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai', ['enableClientValidation' => false])->widget(\yii\widgets\MaskedInput::classname(), [
            'clientOptions' => [
                'alias' =>  'decimal',
                // 'groupSeparator' => ',',
                'groupSeparator' => '.',
                'radixPoint'=>',',                
                'autoGroup' => true,
                'removeMaskOnSubmit' => true,
            ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#ta-mutasi-kas-pjax'});
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
                $.pjax.reload({container:'#ta-mutasi-kas-pjax'});
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