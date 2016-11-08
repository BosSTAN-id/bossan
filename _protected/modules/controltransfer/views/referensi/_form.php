<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans3-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php IF($model->isNewRecord) : ?>
    
    <?= $form->field($model, 'Tahun')->textInput() ?>


    <?php 
            echo $form->field($model, 'Kd_Trans_1')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\TaTrans1::find()->where("Tahun = ".$model->Tahun)->all(),'Kd_Trans_1','Jns_Transfer'),
                'options' => ['placeholder' => 'Pilih Jenis ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>
    <?php  echo $form->field($model, 'Kd_Trans_2')->widget(DepDrop::classname(), [
            'options'=>['id'=>'tatrans3-kd_trans_2'],
            'pluginOptions'=>[
                'depends'=>['tatrans3-kd_trans_1'],
                'placeholder'=>'Pilih Bidang',
                'url'=>Url::to(['bidang'])
            ]
        ]); ?>

    <?php endif;?>    

    <?= $form->field($model, 'Kd_Trans_3')->textInput() ?>

    <?= $form->field($model, 'Nm_Sub_Bidang')->textInput() ?>

    <?= $form->field($model, 'Kd_sub_DAK')->textInput() ?>

    <?= $form->field($model, 'Pagu')->textInput() ?>

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