<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\RefRek5 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-rek5-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'kd_penerimaan_1')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(\app\models\RefPenerimaanSekolah1::find()->select(['kd_penerimaan_1', "concat(kd_penerimaan_1, '. ', uraian_penerimaan_1) AS uraian_penerimaan_1"])->all(), 'kd_penerimaan_1', 'uraian_penerimaan_1'),
        'options' => ['placeholder' => 'Pilih Akun ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'kd_penerimaan_2')->textInput()->label('Kode Penerimaan 2') ?>

    <?= $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'abbr')->textInput(['maxlength' => true])->label('Singkatan') ?>

    <?= $form->field($model, 'sekolah')->checkbox(); ?>

    <?= $form->field($model, 'pengesahan')->checkbox(); ?>

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
                $.pjax.reload({container:'#ref-rek5-pjax'});
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
                $.pjax.reload({container:'#ref-rek5-pjax'});
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