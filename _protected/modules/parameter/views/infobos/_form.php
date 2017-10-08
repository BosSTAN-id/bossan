<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TaInfoBos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-info-bos-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'tahun_ajaran')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'satuan_bos')->textInput(['maxlength' => true]) ?>

    <?php /* $form->field($model, 'satuan_bos', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
        'clientOptions' => [
            'alias' =>  'decimal',
            // 'groupSeparator' => ',',
            'groupSeparator' => '.',
            'radixPoint'=>',',                
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
        ],
    ])*/ ?>

    <?= $form->field($model, 'jumlah_siswa')->textInput() ?>

    <?= $form->field($model, 'jumlah_guru')->textInput() ?>

    <?= $form->field($model, 'jumlah_dana_bos')->textInput() ?>

    <?php /* $form->field($model, 'jumlah_dana_bos', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
        'clientOptions' => [
            'alias' =>  'decimal',
            // 'groupSeparator' => ',',
            'groupSeparator' => '.',
            'radixPoint'=>',',                
            'autoGroup' => true,
            'removeMaskOnSubmit' => true,
        ],
    ]) */ ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php $script = <<<JS
$('#tainfobos-jumlah_siswa').keyup(function(){
        var satuanBos = $('#tainfobos-satuan_bos').val(),
            jumlahSiswa = $(this).val(),
            
        satuanBos = satuanBos - 0;//convert to integer
        jumlahSiswa = jumlahSiswa - 0;//convert to integer
        jumlahDanaBos = satuanBos * jumlahSiswa * 12;
        if(isNaN(jumlahDanaBos)) { var jumlahDanaBos = 0;}
        $('#tainfobos-jumlah_dana_bos').val(jumlahDanaBos);
});

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
                $.pjax.reload({container:'#ta-info-bos-pjax'});
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
?>