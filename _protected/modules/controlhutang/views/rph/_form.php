<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TaRPH */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rph-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'Tahun')->textInput()->input('tahun', ['placeholder' => $Tahun]) ?>

    <?php
    $sph = \app\models\TaSPH::find(['Kd_Urusan' => Yii::$app->user->identity->Kd_Urusan, 'Kd_Bidang' => Yii::$app->user->identity->Kd_Bidang, 'Kd_Unit' => Yii::$app->user->identity->Kd_Unit, 'Kd_Sub' => Yii::$app->user->identity->Kd_Sub])->andWhere('Saldo > 0')->andWhere('Tahun<='.$Tahun)->select(['No_SPH', 'CONCAT(No_SPH,\' \', Nm_Perusahaan) AS Nm_Perusahaan'])->all();
    echo $form->field($model, 'No_SPH')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($sph,'No_SPH','Nm_Perusahaan'),
                'options' => ['placeholder' => 'Pilih SPH ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>    

    <?= $form->field($model, 'No_RPH')->textInput() ?>    

    <?= $form->field($model, 'Tgl_RPH')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'changeMonth' => true,
            // 'yearRange' => '1996:2099',
            'changeYear' => true,
        ],
    ]) ?> 

    <?= $form->field($model, 'Nm_Kepala_SKPD')->textInput() ?>

    <?= $form->field($model, 'NIP')->textInput() ?>

    <?= $form->field($model, 'Jabatan')->textInput() ?>

    <?= $form->field($model, 'No_Tagihan')->textInput() ?>

    <?= $form->field($model, 'Tgl_Tagihan')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'changeMonth' => true,
            // 'yearRange' => '1996:2099',
            'changeYear' => true,
        ],
    ]) ?>     

    <?= $form->field($model, 'Jatuh_Tempo')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'id',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control'],
        'clientOptions' => [
            'changeMonth' => true,
            // 'yearRange' => '1996:2099',
            'changeYear' => true,
        ],
    ]) ?>         

    <?= $form->field($model, 'Nilai_Bayar')->textInput() ?>

    <?= $form->field($model, 'Rekening_Tujuan')->textInput() ?>

    <?= $form->field($model, 'Bank')->textInput() ?>

    <?= $form->field($model, 'Cabang')->textInput() ?>

    <?= $form->field($model, 'Nama_Rekening')->textInput() ?>

    <?= $form->field($model, 'PPh')->textInput() ?>

    <?= $form->field($model, 'PPn')->textInput() ?>

    <?= $form->field($model, 'Denda')->textInput() ?>

    <?= $form->field($model, 'Lampiran_RPH')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#rph-pjax'});
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
                $.pjax.reload({container:'#rph-pjax'});
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