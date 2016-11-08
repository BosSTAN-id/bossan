<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\RefKomponenBos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-komponen-bos-form">

    <?php
    echo DetailView::widget([
        'model'=>$komponen,
        'attributes'=>[
            'komponen',
            // ['attribute'=>'publish_date', 'type'=>DetailView::INPUT_DATE],
        ]
    ]);
    ?>

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php 
            echo $form->field($model, 'Kd_Rek_3')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefRek1::find()->select(['Kd_Rek_1', 'CONCAT(Kd_Rek_1,\' \',Nm_Rek_1) AS uraian_program'])->all(),'kd_program','uraian_program'),
                'options' => ['placeholder' => 'Pilih Akun ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>
    <?php  echo $form->field($model, 'kd_sub_program')->widget(DepDrop::classname(), [
            'options'=>['id'=>'tarkaskegiatan-kd_sub_program'],
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program'],
                'placeholder'=>'Pilih Sub Program ...',
                'url'=>Url::to(['subprogram'])
            ]
        ]); ?>
    <?php echo $form->field($model, 'kd_kegiatan')->widget(DepDrop::classname(), [
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program', 'tarkaskegiatan-kd_sub_program'],
                'placeholder'=>'Pilih Kegiatan ...',
                'url'=>Url::to(['kegiatan'])
            ]
        ]);
    ?>     

    <?= $form->field($model, 'Kd_Rek_1')->textInput() ?>
    
    <?= $form->field($model, 'Kd_Rek_2')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_3')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_4')->textInput() ?>

    <?= $form->field($model, 'Kd_Rek_5')->textInput() ?>

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
                $.pjax.reload({container:'#ref-komponen-bos-pjax'});
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
                $.pjax.reload({container:'#ref-komponen-bos-pjax'});
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