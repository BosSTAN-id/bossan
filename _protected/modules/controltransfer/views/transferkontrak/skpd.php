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
            $skpd = $connection->createCommand('SELECT 
                    a.No_Kontrak, 
                    CONCAT(a.No_Kontrak,\' - \', a.Nm_Perusahaan) AS Perusahaan 
                    FROM Ta_Kontrak a 
                    INNER JOIN ta_rask_arsip_transfer b ON a.Tahun = b.Tahun
                        AND a.Kd_Urusan = b.Kd_Urusan
                        AND a.Kd_Bidang = b.Kd_Bidang
                        AND a.Kd_Unit = b.Kd_Unit
                        AND a.Kd_Sub = b.Kd_Sub
                        AND a.Kd_Prog = b.Kd_Prog
                        AND a.ID_Prog = b.ID_Prog
                        AND a.Kd_Keg = b.Kd_Keg
                    WHERE a.Tahun = '.$Tahun.' AND a.Kd_Urusan = '.Yii::$app->user->identity->Kd_Urusan.' AND a.Kd_Bidang = '.Yii::$app->user->identity->Kd_Bidang.' AND a.Kd_Unit = '.Yii::$app->user->identity->Kd_Unit.' AND a.Kd_Sub = '.Yii::$app->user->identity->Kd_Sub.' AND a.No_Kontrak NOT IN (SELECT No_Kontrak FROM ta_trans_kontrak WHERE Tahun = '.$Tahun.' AND Kd_Urusan = '.Yii::$app->user->identity->Kd_Urusan.' AND Kd_Bidang = '.Yii::$app->user->identity->Kd_Bidang.' AND Kd_Unit = '.Yii::$app->user->identity->Kd_Unit.' AND Kd_Sub = '.Yii::$app->user->identity->Kd_Sub.')
                    GROUP BY a.No_Kontrak
                    ');
            $query = $skpd->queryAll();        
            echo $form->field($model, 'No_Kontrak')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'No_Kontrak','Perusahaan'),
                'options' => ['placeholder' => 'Pilih Kontrak ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>  

    <?php // echo $form->field($model, 'Pagu')->textInput() ?>

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
                $("#myModal").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#paguskpd-pjax{$Kd_Trans_1}{$Kd_Trans_2}{$Kd_Trans_3}'});
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
                $.pjax.reload({container:'#paguskpd-pjax'});
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