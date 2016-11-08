<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaTransSKPD */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans-skpd-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

        <?php
            //This is for SKPD dropdownlist in search ----@hoaaah
        //'Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Prog', 'ID_Prog', 'Kd_Urusan1', 'Kd_Bidang1'
            $connection = \Yii::$app->db;           
            $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub) AS kd, Nm_Sub_Unit FROM Ref_Sub_Unit');
            $query = $skpd->queryAll();        
            echo $form->field($model, 'kd_skpd')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'kd','Nm_Sub_Unit'),
                'options' => ['placeholder' => 'Pilih SKPD ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>  

    <?= $form->field($model, 'Pagu')->textInput() ?>

    <?= $form->field($model, 'Referensi_Dokumen')->textInput() ?>

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
                $("#myModalkegiatan").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#paguskpd-pjax{$trans3->Kd_Trans_1}{$trans3->Kd_Trans_2}{$trans3->Kd_Trans_3}'});
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
                $("#myModalSkpdubah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#paguskpd-pjax{$model->Kd_Trans_1}{$model->Kd_Trans_2}{$model->Kd_Trans_3}'});
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