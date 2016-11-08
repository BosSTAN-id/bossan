<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use dosamigos\datepicker\DatePicker;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-sph-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php echo $form->field($model, 'Tahun')->textInput()->input('tahun', ['placeholder' => Yii::$app->session->get('tahun')]) ?>

    <?= $form->field($model, 'No_SPH')->textInput() ?>

    <?= $form->field($model, 'Tgl_SPH')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>

    <?= $form->field($model, 'Nm_Kepala_SKPD')->textInput() ?>

    <?= $form->field($model, 'NIP')->textInput() ?>

    <?= $form->field($model, 'Jabatan')->textInput() ?>

    <?= $form->field($model, 'Alamat')->textInput() ?>

    <?= $form->field($model, 'Kd_Rekanan')->textInput() ?>

    <?= $form->field($model, 'Nm_Rekanan')->textInput() ?>

    <?= $form->field($model, 'Jab_Rekanan')->textInput() ?>

    <?= $form->field($model, 'Alamat_Rekanan')->textInput() ?>

    <?= $form->field($model, 'Nilai')->textInput() ?>

    <?= $form->field($model, 'Saldo')->textInput() ?>

    <?= $form->field($model, 'Pekerjaan')->textInput() ?>

    <?= $form->field($model, 'No_Kontrak')->textInput() ?>

    <?= $form->field($model, 'Tgl_Kontrak')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control']
    ]) ?>   

    <?= $form->field($model, 'Nm_Perusahaan')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
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
                $("#myModal").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#sphawal-pjax'});
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
                $("#myModalUbah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#sphawal-pjax'});
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