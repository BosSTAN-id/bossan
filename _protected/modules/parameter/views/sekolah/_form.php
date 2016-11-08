<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\RefSekolah */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-sekolah-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'negeri')->radioList([ 1=>'Negeri',2=>'Swasta'])->label(false); ?>

    <?= $form->field($model, 'jenis_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefJenisSekolah::find()->all(),'id','jenis_sekolah'),
                'options' => ['placeholder' => 'Jenis Sekolah ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?> 

    <?= $form->field($model, 'nama_sekolah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kecamatan_id')->dropDownList(
        ArrayHelper::map(\app\models\RefKecamatan::find()->all(),'Kd_Kecamatan','Nm_Kecamatan'),
        [
            'prompt'=>'Pilih Kecamatan ...',
            'onchange'=>'
                $.post("'.Yii::$app->urlManager->createUrl('/parameter/sekolah/kelurahan?id=').'"+$(this).val(),function(data)
                { $("select#refsekolah-kelurahan_id" ).html(data);
            });'
        ]
    ); ?>

    <?= $form->field($model, 'kelurahan_id')->dropDownList(
        ArrayHelper::map(\app\models\RefDesa::find()->all(),'Kd_Desa','Nm_Desa'),
        [
            'prompt'=>'Pilih Desa/Kelurahan',
        ]
    ) ?>     

    <?= $form->field($model, 'alamat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kepala_sekolah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rekening_sekolah')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama_bank')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'alamat_cabang')->textInput(['maxlength' => true]) ?>   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#sekolah-pjax'});
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
                $.pjax.reload({container:'#sekolah-pjax'});
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