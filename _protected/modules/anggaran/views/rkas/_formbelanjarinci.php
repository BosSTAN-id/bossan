<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rkas-kegiatan-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()
    // , 'layout' => 'horizontal'
    ]); ?>    

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai_rp')->textInput(['id' => 'nilai_rp', 'maxlength' => true]) ?>

    <div class="col-md-6">
    <?= $form->field($model, 'nilai_1')->textInput(['id' => 'nilai_1', 'maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'sat_1')->textInput(['id' => 'sat_1', 'maxlength' => true]) ?>
    </div>


    <div class="col-md-6">
    <?= $form->field($model, 'nilai_2')->textInput(['id' => 'nilai_2', 'maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'sat_2')->textInput(['id' => 'sat_2', 'maxlength' => true]) ?>
    </div>


    <div class="col-md-6">
    <?= $form->field($model, 'nilai_3')->textInput(['id' => 'nilai_3', 'maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'sat_3')->textInput(['id' => 'sat_3', 'maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
    <?= $form->field($model, 'jml_satuan')->textInput(['id' => 'jml_satuan', 'maxlength' => true, 'readonly' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'satuan123')->textInput(['id' => 'satuan123', 'maxlength' => true, 'readonly' => true]) ?>
    </div>    

    <?= $form->field($model, 'total')->textInput(['id' => 'total', 'maxlength' => true, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
//untuk satuan
$this->registerJs("$('#nilai_1, #nilai_2, #nilai_3').keyup(function(){
        var nilai_1 = $('#nilai_1').val(),
            nilai_2 = $('#nilai_2').val(),
            nilai_3 = $('#nilai_3').val(),
            jml_satuan = 0;
            if(nilai_1 == '') { var nilai_1 = 1;}   
            if(nilai_2 == '') { var nilai_2 = 1;}     
            if(nilai_3 == '') { var nilai_3 = 1;}                            
        nilai_1 = nilai_1 - 0;//convert to integer
        nilai_2 = nilai_2 - 0;//convert to integer
        nilai_3 = nilai_3 - 0;//convert to integer
        jml_satuan = nilai_1 * nilai_2 * nilai_3;
        if(isNaN(jml_satuan)) { var jml_satuan = 0;}
        $('#jml_satuan').val(jml_satuan);
});");
//untuk satuan
$this->registerJs("$('#sat_1, #sat_2, #sat_3').keyup(function(){
        var sat_1 = $('#sat_1').val(),
            sat_2 = $('#sat_2').val(),
            sat_3 = $('#sat_3').val(),
            satuan123 = '';
        if(sat_1 != '') { var sat_1 = sat_1;}   
        if(sat_2 != '') { var sat_2 = '/' + sat_2;}   
        if(sat_3 != '') { var sat_3 = '/' + sat_3;}   
        satuan123 = sat_1 + sat_2 + sat_3;
        $('#satuan123').val(satuan123);
});");
//untuk total
$this->registerJs("$('#jml_satuan, #nilai_rp').keyup(function(){
        var jml_satuan = $('#jml_satuan').val(),
            nilai_rp = $('#nilai_rp').val(),
            total = 0;
        nilai_rp = nilai_rp - 0;//convert to integer
        jml_satuan = jml_satuan - 0;//convert to integer
        total = jml_satuan * nilai_rp;
        if(isNaN(total)) { var total = 0;}
        $('#total').val(total);
});");
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
                $("#myModalrinci").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#belanjarinci-pjax{$model->Kd_Rek_3}{$model->Kd_Rek_4}{$model->Kd_Rek_5}'});
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
                $("#myModalrinciubah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#belanjarinci-pjax{$model->Kd_Rek_3}{$model->Kd_Rek_4}{$model->Kd_Rek_5}'});
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