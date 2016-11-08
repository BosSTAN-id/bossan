<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\RefPenerimaanSekolah2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ref-penerimaan-sekolah2-form">

    <?php
    echo DetailView::widget([
        'model'=>$komponen,
        'attributes'=>[
            [
                'label' => 'Kode',
                'value' => $komponen->kd_penerimaan_1.'.'.$komponen->kd_penerimaan_2,
            ],
            'uraian'
            // ['attribute'=>'publish_date', 'type'=>DetailView::INPUT_DATE],
        ]
    ]);
    ?>

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php $data = \app\models\RefRek5::find()
                    ->select(['CONCAT(Kd_Rek_1,\'.\',Kd_Rek_2,\'.\',Kd_Rek_3,\'.\',Kd_Rek_4,\'.\',Kd_Rek_5) AS Kd_Rek_5', 'CONCAT(Kd_Rek_1,\'.\',Kd_Rek_2,\'.\',Kd_Rek_3,\'.\',Kd_Rek_4,\'.\',Kd_Rek_5,\' \', Nm_Rek_5) AS Nm_Rek_5'])
                    ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Sekolah' => 1])
                    ->all();
            echo $form->field($model, 'rekening5')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data,
                'Kd_Rek_5','Nm_Rek_5'),
                'options' => ['placeholder' => 'Pilih Akun ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
            // echo $form->field($model, 'rekening5')->dropDownList(
            //                                 ArrayHelper::map($data, 'Kd_Rek_5','Nm_Rek_5'), 
            //                                 ['prompt'=>'Select...']);
    ?>

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
                $.pjax.reload({container:'#ref-penerimaan-sekolah2-pjax'});
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
                $.pjax.reload({container:'#ref-penerimaan-sekolah2-pjax'});
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