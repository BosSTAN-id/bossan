<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\TaTransSts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans-sts-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php 
            echo $form->field($model, 'Kd_Trans_1')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\TaTrans1::find()->where("Tahun = ".$Tahun)->all(),'Kd_Trans_1','Jns_Transfer'),
                'options' => ['placeholder' => 'Pilih Jenis ...'],
                'size' => 'sm',
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
    ?>
    <?php  echo $form->field($model, 'Kd_Trans_2')->widget(DepDrop::classname(), [
            'options'=>['id'=>'tatranssts-kd_trans_2', 'class' => 'form-control input-sm'],
            'pluginOptions'=>[
                'depends'=>['tatranssts-kd_trans_1'],
                'placeholder'=>'Pilih Bidang',
                'url'=>Url::to(['bidang'])
            ]
        ])->label(false); ?>
    <?php  echo $form->field($model, 'Kd_Trans_3')->widget(DepDrop::classname(), [
            'options'=>['id'=>'tatranssts-kd_trans_3', 'class' => 'form-control input-sm'],
            'pluginOptions'=>[
                'depends'=>['tatranssts-kd_trans_1', 'tatranssts-kd_trans_2'],
                'placeholder'=>'Pilih Sub Bidang',
                'url'=>Url::to(['subbidang'])
            ]
        ])->label(false); ?>

    <?= $form->field($model, 'No_STS')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'No Lembar Transfer'])->label(false) ?>    

        <?= $form->field($model, 'Tgl_STS')->widget(
            DatePicker::className(), [
                 'inline' => false, 
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-m-d'
                ]
        ])->label(false);?>

    <?= $form->field($model, 'Nilai')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Nilai'])->label(false) ?>
    <?= $form->field($model, 'Bank_Penerima')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'Nama Bank'])->label(false) ?>
    <?= $form->field($model, 'Rek_Penerima')->textInput(['class' => 'form-control input-sm', 'placeholder' => 'No Rekening'])->label(false) ?>                

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#sts-pjax'});
                $.pjax.reload({container:'#posisi-pjax'});
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
                $.pjax.reload({container:'#sts-pjax'});
                $.pjax.reload({container:'#posisi-pjax'});
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