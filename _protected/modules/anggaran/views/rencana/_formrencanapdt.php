<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rkas-kegiatan-form">
    <?php
    $detaildata = $anggaran->one();
    $sumdata = $anggaran->sum('total');
    $rata = ($sumdata/12);
    echo DetailView::widget([
        'model' => $detaildata,
        'attributes' => [
            [
                'label' => 'Sumber Dana',
                'value' =>  $detaildata->penerimaan2->uraian,
            ],
            [
                'label' => 'Rekening',
                'value' => $detaildata->Kd_Rek_1.'.'.$detaildata->Kd_Rek_2.'.'.$detaildata->Kd_Rek_3.'.'.substr('0'.$detaildata->Kd_Rek_4, -2).'.'.substr('0'.$detaildata->Kd_Rek_5, -2).' '.$detaildata->refRek5->Nm_Rek_5,
            ],
            [
                'label' => 'Dianggarkan',
                'format' => 'decimal',
                'value' => $anggaran->sum('total')
            ],
        ],
    ]) ?>

    <p style="margin-top: 10px;" class="text-muted well well-sm no-shadow">
        Juli-Desember pada tahun berkenaan, Januari-Juni pada tahun berikutnya. (Satu tahun ajaran berada pada bulan Juli tahun H-Juni tahun H+1). Tekan bagi rata untuk otomatis bagi rata setiap bulannya.
        <?=
        Html::button('Bagi Rata!', [ 'class' => 'btn btn-xs btn-default', 'onclick' => '(function ( $event ) { 
                    $(\'#juli\').val('.$rata.');
                    $(\'#agustus\').val('.$rata.');
                    $(\'#september\').val('.$rata.');
                    $(\'#oktober\').val('.$rata.');
                    $(\'#november\').val('.$rata.');
                    $(\'#desember\').val('.$rata.');
                    $(\'#januari1\').val('.$rata.');
                    $(\'#februari1\').val('.$rata.');
                    $(\'#maret1\').val('.$rata.');
                    $(\'#april1\').val('.$rata.');
                    $(\'#mei1\').val('.$rata.');
                    $(\'#juni1\').val('.$rata.');
                })();' ])
        ?>        
    </p>
    <?php $form = ActiveForm::begin(['id' => $model->formName()
    // , 'layout' => 'horizontal'
    ]); ?>

    <div class="col-md-6">
    <?= $form->field($model, 'juli')->textInput(['id' => 'juli', 'maxlength' => true]) ?>
    <?= $form->field($model, 'agustus')->textInput(['id' => 'agustus', 'maxlength' => true]) ?>
    <?= $form->field($model, 'september')->textInput(['id' => 'september', 'maxlength' => true]) ?>
    <?= $form->field($model, 'oktober')->textInput(['id' => 'oktober', 'maxlength' => true]) ?>
    <?= $form->field($model, 'november')->textInput(['id' => 'november', 'maxlength' => true]) ?>
    <?= $form->field($model, 'desember')->textInput(['id' => 'desember', 'maxlength' => true]) ?>
    </div>
    <div class="col-md-6">
    <?= $form->field($model, 'januari1')->textInput(['id' => 'januari1', 'maxlength' => true]) ?>
    <?= $form->field($model, 'februari1')->textInput(['id' => 'februari1', 'maxlength' => true]) ?>
    <?= $form->field($model, 'maret1')->textInput(['id' => 'maret1', 'maxlength' => true]) ?>
    <?= $form->field($model, 'april1')->textInput(['id' => 'april1', 'maxlength' => true]) ?>
    <?= $form->field($model, 'mei1')->textInput(['id' => 'mei1', 'maxlength' => true]) ?>
    <?= $form->field($model, 'juni1')->textInput(['id' => 'juni1', 'maxlength' => true]) ?>
    </div>



    <div class="form-group">
        <?= Html::submitButton('Simpan' , ['class' => 'btn btn-sm btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    Sisa: <input id="total" class="form-control" type="text" readonly="" name="TaRkasPendapatanRencana[juli]">
</div>
<?php
//untuk satuan
$this->registerJs("$('#juli, #agustus, #september, #oktober, #november, #desember, #januari1, #februari1, #maret1, #april1, #mei1, #juni1').keyup(function(){
        var juli = $('#juli').val(),
            agustus = $('#agustus').val(),
            september = $('#september').val(),
            oktober = $('#oktober').val(),
            november = $('#november').val(),
            desember = $('#desember').val(),
            januari1 = $('#januari1').val(),
            februari1 = $('#februari1').val(),
            maret1 = $('#maret1').val(),
            april1 = $('#april1').val(),
            mei1 = $('#mei1').val(),
            juni1 = $('#juni1').val(),
            total = {$sumdata};                            
        juli = juli - 0;//convert to integer
        agustus = agustus - 0;//convert to integer
        september = september - 0;//convert to integer
        oktober = oktober - 0;//convert to integer
        november = november - 0;//convert to integer
        desember = desember - 0;//convert to integer
        januari1 = januari1 - 0;//convert to integer
        februari1 = februari1 - 0;//convert to integer
        maret1 = maret1 - 0;//convert to integer
        april1 = april1 - 0;//convert to integer
        mei1 = mei1 - 0;//convert to integer
        juni1 = juni1 - 0;//convert to integer
        total = total - (juli + agustus + september + oktober + november + desember + januari1 + februari1 + maret1 + april1 + mei1 + juni1);
        if(isNaN(total)) { var total = 0;}
        $('#total').val(total);
});");

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
                $.pjax.reload({container:'#belanja-pjax{$model->Kd_Rek_3}{$model->Kd_Rek_4}{$model->Kd_Rek_5}'});
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