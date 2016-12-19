<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\MaskedInput;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spjrinc-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName(),
    // 'enableAjaxValidation' => false,
    ]); ?>

    <?= $form->field($model, 'uraian')->textarea(['rows'=>3,'cols'=>5]); ?>    

    <?= $form->field($model, 'no_bukti')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'tgl_bukti')->widget(DatePicker::classname(), [
            'language' => 'id',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
        ]) ?>

     <?php 
            $connection = \Yii::$app->db;
            $sekolah_id = $model->sekolah_id;
            $skpd = $connection->createCommand("
                SELECT
                a.Kd_Rek_3,
                CONCAT(a.Kd_Rek_1, '.', a.Kd_Rek_2, '.', a.Kd_Rek_3
                ,' ', c.Nm_Rek_3
                ) AS Nm_Rek_3
                FROM
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(total) AS total
                    FROM
                        ta_rkas_history
                    WHERE
                        sekolah_id = ".$model->sekolah_id."
                    AND tahun = $Tahun
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND perubahan_id = (SELECT MAX(perubahan_id) FROM ta_rkas_peraturan WHERE sekolah_id = ".$model->sekolah_id." AND tahun = $Tahun AND tgl_peraturan <= NOW()
                    )
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                )a LEFT JOIN
                (
                    SELECT
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5,
                        SUM(nilai) AS nilai
                    FROM
                        ta_spj_rinc
                    WHERE
                        tahun = $Tahun
                    AND kd_program = ".$model->kd_program."
                    AND kd_sub_program = ".$model->kd_sub_program."
                    AND kd_kegiatan = ".$model->kd_kegiatan."
                    AND sekolah_id = ".$model->sekolah_id."
                    AND Kd_Rek_1 = ".$model->Kd_Rek_1."
                    AND Kd_Rek_2 = ".$model->Kd_Rek_2."
                    AND tgl_bukti <= NOW()
                    GROUP BY
                        kd_program,
                        kd_sub_program,
                        kd_kegiatan,
                        Kd_Rek_1,
                        Kd_Rek_2,
                        Kd_Rek_3,
                        Kd_Rek_4,
                        Kd_Rek_5
                ) b ON a.kd_program = b.kd_program AND a.kd_sub_program = b.kd_sub_program AND a.kd_kegiatan = b.kd_kegiatan 
                AND a.Kd_Rek_1 = b.Kd_Rek_1
                AND a.Kd_Rek_2 = b.Kd_Rek_2
                AND a.Kd_Rek_3 = b.Kd_Rek_3
                AND a.Kd_Rek_4 = b.Kd_Rek_4
                AND a.Kd_Rek_5 = b.Kd_Rek_5
                LEFT JOIN ref_rek_3 c ON a.Kd_Rek_1 = c.Kd_Rek_1 AND a.Kd_Rek_2 = c.Kd_Rek_2 AND a.Kd_Rek_3 = c.Kd_Rek_3
                LEFT JOIN ref_rek_4 d ON a.Kd_Rek_1 = d.Kd_Rek_1 AND a.Kd_Rek_2 = d.Kd_Rek_2 AND a.Kd_Rek_3 = d.Kd_Rek_3 AND a.Kd_Rek_4 = d.Kd_Rek_4
                LEFT JOIN ref_rek_5 e ON a.Kd_Rek_1 = e.Kd_Rek_1 AND a.Kd_Rek_2 = e.Kd_Rek_2 AND a.Kd_Rek_3 = e.Kd_Rek_3 AND a.Kd_Rek_4 = e.Kd_Rek_4 AND a.Kd_Rek_5 = e.Kd_Rek_5
                GROUP BY a.Kd_Rek_3
                ");
            $data = $skpd->queryAll();
            echo $form->field($model, 'Kd_Rek_3')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data ,'Kd_Rek_3','Nm_Rek_3'),
                'options' => ['placeholder' => 'Pilih Jenis Belanja ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?> 

    <?php 
            // echo $form->field($model, 'Kd_Rek_3')->widget(Select2::classname(), [
            //     'data' => ArrayHelper::map(
            //         \app\models\RefRek3::find()
            //         ->select(['Kd_Rek_3', 'CONCAT(Kd_Rek_3,\' \',Nm_Rek_3) AS Nm_Rek_3'])
            //         ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2])
            //         ->all()
            //         ,'Kd_Rek_3','Nm_Rek_3'),
            //     'options' => ['placeholder' => 'Pilih Jenis Belanja ...'],
            //     'pluginOptions' => [
            //         'allowClear' => true
            //     ],
            // ]);
    ?>

    <?php
    $Kd_Rek_4 = \app\models\RefRek4::find()
                    ->select(['Kd_Rek_4', 'CONCAT(Kd_Rek_4,\' \',Nm_Rek_4) AS Nm_Rek_4'])
                    ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4])
                    ->one();
    echo $form->field($model, 'Kd_Rek_4')->widget(DepDrop::classname(), [
            'data' => isset($model->Kd_Rek_4) ? [$Kd_Rek_4->Kd_Rek_4 => $Kd_Rek_4->Nm_Rek_4] : [],
            'type'=>DepDrop::TYPE_SELECT2,
            'options'=>['id'=>'taspjrinc-kd_rek_4'],
            'pluginOptions'=>[
                'depends'=>['taspjrinc-kd_rek_3'],
                'placeholder'=>'Pilih Kelompok Belanja ...',
                'url'=>Url::to(['kdrek4'])
            ]
        ]); ?>

    <?php
    $Kd_Rek_5 = \app\models\RefRek5::find()
                    ->select(['Kd_Rek_5', 'CONCAT(Kd_Rek_5,\' \',Nm_Rek_5) AS Nm_Rek_5'])
                    ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2, 'Kd_Rek_3' => $model->Kd_Rek_3, 'Kd_Rek_4' => $model->Kd_Rek_4, 'Kd_Rek_5' => $model->Kd_Rek_5])
                    ->one();
    echo $form->field($model, 'Kd_Rek_5')->widget(DepDrop::classname(), [
            'data' => isset($model->Kd_Rek_5) ? [$Kd_Rek_5->Kd_Rek_5 => $Kd_Rek_5->Nm_Rek_5] : [],
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['taspjrinc-kd_rek_3', 'taspjrinc-kd_rek_4'],
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

    <?= $form->field($model, 'pembayaran')->radioList([1 => 'Bank', 2 => 'Tunai'], [
        'item' => function ($index, $label, $name, $checked, $value) {
            return '<label class="radio-inline">' . Html::radio($name, $checked, ['value'  => $value]) . $label . '</label>';
        }
    ]); ?>                                      
<?php /*
    echo $form->field($model, 'pembayaran')->radioList([1 => 'Bank', 2 => 'Tunai'],[ 'item' => function($index, $label, $name, $checked, $value) {
                                        $return = '<label class="modal-radio">';
                                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" id="'.$value.'" >';
                                        $return .= '<span>  ' . ucwords($label) . '</span>';
                                        $return .= '</label>';
                                        return $return;
                                 }]);
    <div id="container-bank" <?= $model->isNewRecord ? "style='display:none'" : '' ?>>     
        <?= $form->field($model, 'bank_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefBank::find()->where(['tahun' => $Tahun, 'sekolah_id' => $model->sekolah_id])->all(), 'id','keterangan'),
                // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
                'options' => ['placeholder' => 'Sumber Dana ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label('Nama Rekening Bank'); ?>
    </div>
*/ ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
//untuk hide show container bank
$script = <<<JS
$(document).ready(function() {
   $('input[type="radio"]').click(function() {
       if($(this).attr('id') == 1) {
            $('#container-bank').show();           
       }

       else {
            $('#container-bank').hide();   
       }
   });
});

JS;
$this->registerJs($script);
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
                $.pjax.reload({container:'#belanja-pjax'});
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