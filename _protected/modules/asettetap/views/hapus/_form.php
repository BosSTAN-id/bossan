<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\TaAsetTetap */
/* @var $form yii\widgets\ActiveForm */
// if($model->isNewRecord ? ['create'] : ['update', 'id' => $model->no_register]);
?>

<div class="ta-aset-tetap-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName(), 'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->no_register] ]); ?>

    <?php if($model->isNewRecord): ?>

    <?= $form->field($model, 'Kd_Aset1')->hiddenInput(['value'=> $model->Kd_Aset1])->label(false) ?>
    <div class="row">
        <div class="col-md-4">
            <?php
                echo $form->field($model, 'kode25')->textInput(['placeholder' => 'Jenis Barang', 'readonly' => true])->label(false);
            ?>
        </div>
        <div class="col-md-6">
            <div class="input-group">
            <input type="text" id="taasettetap-nama-jenis" class="form-control" name="TaAsetTetap[nama-jenis]" readonly placeholder="Jenis Barang">
                <span class="input-group-btn">
                    <?= Html::a('<i class="glyphicon glyphicon-search"></i>', ['rek-aset2', 'Kd_Aset1' => $model->Kd_Aset1], [
                        'class' => 'btn btn-default',
                        'title' => 'Rekening 3',
                        'data-toggle'=>"modal",
                        'data-target'=>"#modalAset",
                        'data-title'=> "Klasifikasi Aset Tetap", 
                    ]) ?>
                </span>                
            </div>
        </div>
        <div class="col-md-2">
            <?php
                if($model->isNewRecord) echo $form->field($model, 'jumlahBarang')->textInput(['placeholder' => 'Jumlah Barang' /*, 'value' => 1 */])->label(false);
            ?>
        </div>
    </div>

    <?php endif ?>

    <div class="row">
        <div class="col-md-4">
            <?php 
                echo $form->field($model, 'sumber_perolehan')->widget(Select2::classname(), [
                    'data' => [
                        1 => 'Belanja',
                        2 => 'Hibah',
                    ], 
                    'options' => ['placeholder' => 'Pilih Perolehan ...', 'id' => $model->isNewRecord ? 'perolehan-create' : 'perolehan-update'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-4">
            <?php 
                echo $form->field($model, 'kepemilikan')->widget(Select2::classname(), [
                    'data' => [
                        // 0 => 'Pemerintah Pusat',
                        // 11 => 'Pemerintah Provinsi',
                        12 => 'Sekolah/Pemda',
                        // 13 => 'Pemerintah Provinsi Lain',
                        14 => 'Instansi Lain',
                        15 => 'Pribadi',
                    ], // ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program,\' \',uraian_program) AS uraian_program'])->where('kd_program > 0')->all(),'kd_program','uraian_program'),
                    'options' => ['placeholder' => 'Pilih Kepemilikan ...', 'id' => $model->isNewRecord ? 'kepemilikan-create' : 'kepemilikan-update' ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'referensi_bukti')->textInput(['maxlength' => true, 'readonly' => !$model->sumber_perolehan || $model->sumber_perolehan = 2 ? true : false])->label('Bukti Belanja') ?>
        </div>
    </div>    
    
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'tgl_perolehan')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'id',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'nilai_perolehan', ['enableClientValidation' => false])->widget(MaskedInput::classname(), [
                'clientOptions' => [
                    'alias' =>  'decimal',
                    // 'groupSeparator' => ',',
                    'groupSeparator' => '.',
                    'radixPoint'=>',',                
                    'autoGroup' => true,
                    'removeMaskOnSubmit' => true,
                ],
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'masa_manfaat')->textInput() ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12"> <?= $form->field($model, 'keterangan')->textInput(['maxlength' => true]) ?></div>
    </div>

    <?php
        $attr1 = $attr2 = $attr3 = $attr4 = $attr5 = $attr6 = $attr7 = $attr8 = $attr9 = $attr10 = false;
        $attr1Label = $attr2Label = $attr3Label = $attr4Label = $attr5Label = $attr6Label = $attr7Label = $attr8Label = $attr9Label = $attr10Label = '';
        switch ($model->Kd_Aset1) {
            case 1:
                $attr1 = $attr2 = $attr3 = $attr4 = $attr5 = true;
                $attr1Label = 'Luas';
                $attr2Label = 'Alamat';
                $attr3Label = 'Jenis Hak';
                $attr4Label = 'No Sertifikat';
                $attr5Label = 'Tgl Sertifikat';
                break;
            case 2:
                $attr1 = $attr2 = $attr3 = $attr4 = $attr5 = $attr6 = $attr7 = $attr8 = $attr9 = $attr10 = true;
                $attr1Label = 'Ruang';
                $attr2Label = 'Merk';
                $attr3Label = 'Type';
                $attr4Label = 'CC';
                $attr5Label = 'Bahan';
                $attr6Label = 'No Pabrik';
                $attr7Label = 'No Rangka';
                $attr8Label = 'No Mesin';
                $attr9Label = 'No Polisi';
                $attr10Label = 'No BPKP';
                break;
            case 3:
                $attr1 = $attr2 = $attr3 = $attr4 = true;
                $attr1Label = 'Luas';
                $attr2Label = 'Alamat';
                $attr3Label = 'Bertingkat / Tidak';
                $attr4Label = 'Beton / Tidak';
                break;
            case 4:
                $attr1 = $attr2 = $attr3 = $attr4 = true;
                $attr1Label = 'Luas';
                $attr2Label = 'Konstruksi';
                $attr3Label = 'Dimensi';
                $attr4Label = 'Lokasi';
                break;
            case 5:
                $attr1 = $attr2 = $attr3 = $attr4 = true;
                $attr1Label = 'Judul';
                $attr2Label = 'Pencipta';
                $attr3Label = 'Bahan';
                $attr4Label = 'Ukuran';
                break;
            
            default:
                # code...
                break;
        }
    ?>

    <div class="row">
        <div class="col-md-4">
            <?php if($attr1) echo $form->field($model, 'attr1')->textInput(['placeholder' => $attr1Label])->label($attr1Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr2) echo $form->field($model, 'attr2')->textInput(['placeholder' => $attr2Label])->label($attr2Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr3) echo $form->field($model, 'attr3')->textInput(['placeholder' => $attr3Label])->label($attr3Label); ?>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-4">
            <?php if($attr4) echo $form->field($model, 'attr4')->textInput(['placeholder' => $attr4Label])->label($attr4Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr5) echo $form->field($model, 'attr5')->textInput(['placeholder' => $attr5Label])->label($attr5Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr6) echo $form->field($model, 'attr6')->textInput(['placeholder' => $attr6Label])->label($attr6Label); ?>
        </div>
    </div> 
    
    <div class="row">
        <div class="col-md-4">
            <?php if($attr7) echo $form->field($model, 'attr7')->textInput(['placeholder' => $attr7Label])->label($attr7Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr8) echo $form->field($model, 'attr8')->textInput(['placeholder' => $attr8Label])->label($attr8Label); ?>
        </div>
        <div class="col-md-4">
            <?php if($attr9) echo $form->field($model, 'attr9')->textInput(['placeholder' => $attr9Label])->label($attr9Label); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php if($attr10) echo $form->field($model, 'attr10')->textInput(['placeholder' => $attr10Label])->label($attr10Label); ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php 
$script = <<<JS
$("select[name='TaAsetTetap[sumber_perolehan]']").on("change", function(event){
    console.log("change")
    var sumberPerolehan = $(this).val();
    $("#taasettetap-referensi_bukti").removeAttr("readonly");
    if(sumberPerolehan != 1){
        $("#taasettetap-referensi_bukti").attr("readonly", "readonly");
    }
})

// $('form#{$model->formName()}').on('beforeSubmit',function(e)
// {
//     var \$form = $(this);
//     $.post(
//         \$form.attr("action"), //serialize Yii2 form 
//         \$form.serialize()
//     )
//     .done(function(result){
//         if(result == 1)
//         {
//             $("#myModal").modal('hide'); //hide modal after submit
//             //$(\$form).trigger("reset"); //reset form to reuse it to input
//             $.pjax.reload({container:'#ta-aset-tetap-pjax'});
//         }else
//         {
//             $("#message").html(result);
//         }
//     }).fail(function(){
//         console.log("server error");
//     });
//     return false;
// });

JS;
$this->registerJs($script);
?>