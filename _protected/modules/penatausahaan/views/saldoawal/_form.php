<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\TaSaldoAwal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-saldo-awal-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?php 
            $connection = \Yii::$app->db;
            $skpd = $connection->createCommand('SELECT CONCAT(kd_penerimaan_1,".",kd_penerimaan_2) AS kd_penerimaan_2, CONCAT(kd_penerimaan_1,".",kd_penerimaan_2," ",uraian) AS uraian FROM ref_penerimaan_sekolah_2 WHERE /*sekolah = 1 AND*/ kd_penerimaan_1 = 1');
            $data = $skpd->queryAll();
            // $data = \app\models\RefPenerimaanSekolah2::find()
            //         ->select(['CONCAT(kd_penerimaan_1,".",kd_penerimaan_2) AS kd_penerimaan_2', 'CONCAT(kd_penerimaan_1,".",kd_penerimaan_2," ",uraian) AS uraian'])
            //         ->where(['sekolah' => 1])
            //         ->all();     
            echo $form->field($model, 'penerimaan_2')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data, 'kd_penerimaan_2','uraian'),
                // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
                'options' => ['placeholder' => 'Jenis Pendapatan ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>    

    <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nilai', ['enableClientValidation' => false])->widget(\yii\widgets\MaskedInput::classname(), [
            'clientOptions' => [
                'alias' =>  'decimal',
                // 'groupSeparator' => ',',
                'groupSeparator' => '.',
                'radixPoint'=>',',                
                'autoGroup' => true,
                'removeMaskOnSubmit' => true,
            ],
    ]) ?>

    <?= $form->field($model, 'pembayaran')->radioList([1 => 'Bank', 2 => 'Tunai'], [
        'item' => function ($index, $label, $name, $checked, $value) {
            return '<label class="radio-inline">' . Html::radio($name, $checked, ['value'  => $value]) . $label . '</label>';
        }
    ]); ?>      

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
                $.pjax.reload({container:'#ta-saldo-awal-pjax'});
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
                $.pjax.reload({container:'#ta-saldo-awal-pjax'});
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