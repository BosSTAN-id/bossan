<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spjrinc-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName(),
    // 'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->field($model, 'no_bukti')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tgl_bukti')->widget(\yii\jui\DatePicker::classname(), [
            'language' => 'id',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
        ]) ?>   

     <?php 
            $connection = \Yii::$app->db;
            $sekolah_id = $model->sekolah_id;
            $skpd = $connection->createCommand("
                    SELECT
                        CONCAT(a.Kd_Rek_1, '.',
                        a.Kd_Rek_2, '.',
                        a.Kd_Rek_3, '.',
                        a.Kd_Rek_4, '.',
                        a.Kd_Rek_5
                        ) AS rek5,
                        CONCAT(a.Kd_Rek_1, '.',
                        a.Kd_Rek_2, '.',
                        a.Kd_Rek_3, '.',
                        a.Kd_Rek_4, '.',
                        a.Kd_Rek_5, ' ', Nm_Rek_5
                        ) AS Nm_Rek_5
                    FROM
                        ta_rkas_history AS a
                    INNER JOIN ref_rek_2 AS b ON a.Kd_Rek_1 = b.Kd_Rek_1
                    AND a.Kd_Rek_2 = b.Kd_Rek_2
                    INNER JOIN ref_rek_5 AS c ON a.Kd_Rek_1 = c.Kd_Rek_1
                    AND a.Kd_Rek_2 = c.Kd_Rek_2
                    AND a.Kd_Rek_3 = c.Kd_Rek_3
                    AND a.Kd_Rek_4 = c.Kd_Rek_4
                    AND a.Kd_Rek_5 = c.Kd_Rek_5
                    WHERE
                        (a.Kd_Rek_1 = 4 OR (a.Kd_Rek_1 = 6 AND a.Kd_Rek_2 = 1))
                    AND a.sekolah_id = $sekolah_id
                    AND a.perubahan_id = (
                        SELECT
                            MAX(perubahan_id)
                        FROM
                            ta_rkas_peraturan
                        WHERE
                            sekolah_id = $sekolah_id
                    )
                ");
            $data = $skpd->queryAll();
            $model->rek5 = $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.$model->Kd_Rek_4.'.'.$model->Kd_Rek_5;
            echo $form->field($model, 'rek5')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data, 'rek5','Nm_Rek_5'),
                // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
                'options' => ['placeholder' => 'Sumber Dana ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>   

    <?= $form->field($model, 'nilai', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
            'clientOptions' => [
                'alias' =>  'decimal',
                // 'groupSeparator' => ',',
                'groupSeparator' => '.',
                'radixPoint'=>',',                
                'autoGroup' => true,
                'removeMaskOnSubmit' => true,
            ],
    ]) ?>

    <?= $form->field($model, 'uraian')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
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
                $.pjax.reload({container:'#penerimaan-pjax'});
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