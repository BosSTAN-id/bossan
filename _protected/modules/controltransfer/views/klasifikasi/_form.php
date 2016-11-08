<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans2-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php
        echo $form->field($model, 'Kd_Trans_1')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\TaTrans1::find()->where(['Tahun' => $model->Tahun])->all(),'Kd_Trans_1','Jns_Transfer'),
            'options' => ['placeholder' => 'Jenis Transfer Daerah ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ])->label(false);
    ?>    

    <?= $form->field($model, 'Kd_Trans_2')->textInput(['placeholder' => 'Nomor Urut Bidang ...'])->label(false) ?>

    <?= $form->field($model, 'Nm_Bidang')->textInput(['placeholder' => 'Nama Bidang Transfer Daerah ...'])->label(false) ?>

    <?= $form->field($model, 'Kd_Bid_DAK')->textInput(['placeholder' => 'Kode Bidang DAK ...'])->label(false) ?>

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
                $.pjax.reload({container:'#referensi-pjax'});
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
                $.pjax.reload({container:'#referensi-pjax'});
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