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
            echo $form->field($model, 'kd_program')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program,\' \',uraian_program) AS uraian_program'])->all(),'kd_program','uraian_program'),
                'options' => ['placeholder' => 'Pilih Program ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>
    <?php  echo $form->field($model, 'kd_sub_program')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'options'=>['id'=>'tarkaskegiatan-kd_sub_program'],
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program'],
                'placeholder'=>'Pilih Sub Program ...',
                'url'=>Url::to(['subprogram'])
            ]
        ]); ?>
    <?php echo $form->field($model, 'kd_kegiatan')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program', 'tarkaskegiatan-kd_sub_program'],
                'placeholder'=>'Pilih Kegiatan ...',
                'url'=>Url::to(['kegiatan'])
            ]
        ]);
    ?>

    <?php 
            echo $form->field($model, 'Kd_Rek_3')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(
                    \app\models\RefRek3::find()
                    ->select(['Kd_Rek_3', 'CONCAT(Kd_Rek_3,\' \',Nm_Rek_3) AS Nm_Rek_3'])
                    ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2])
                    ->all()
                    ,'Kd_Rek_3','Nm_Rek_3'),
                'options' => ['placeholder' => 'Pilih Jenis Belanja ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>

    <?php  echo $form->field($model, 'Kd_Rek_4')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'options'=>['id'=>'tarkasbelanja-kd_rek_4'],
            'pluginOptions'=>[
                'depends'=>['tarkasbelanja-kd_rek_3'],
                'placeholder'=>'Pilih Kelompok Belanja ...',
                'url'=>Url::to(['kdrek4'])
            ]
        ]); ?>

    <?php echo $form->field($model, 'Kd_Rek_5')->widget(DepDrop::classname(), [
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['tarkasbelanja-kd_rek_3', 'tarkasbelanja-kd_rek_4'],
                'placeholder'=>'Pilih Belanja ...',
                'url'=>Url::to(['kdrek5'])
            ]
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

    <?= $form->field($model, 'bank_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(\app\models\RefBank::find()->where(['tahun' => $Tahun, 'sekolah_id' => $model->sekolah_id])->all(), 'id','no_rekening'),
            // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
            'options' => ['placeholder' => 'Sumber Dana ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

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