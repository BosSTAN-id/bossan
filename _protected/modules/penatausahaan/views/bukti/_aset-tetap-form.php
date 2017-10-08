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

    <?php $form = ActiveForm::begin(['id' => $model->formName(), 'action' => $model->isNewRecord ? ['/asettetap/inventarisasi/create'] : ['update', 'id' => $model->no_register] ]); ?>

    <?php if($model->isNewRecord): ?>

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
                    <?= Html::a('<i class="glyphicon glyphicon-search"></i>', ['/asettetap/inventarisasi/rek-aset1'], [
                        'class' => 'btn btn-default',
                        'title' => 'Rekening 1',
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
                $model->sumber_perolehan = 1;
                echo $form->field($model, 'sumber_perolehan')->widget(Select2::classname(), [
                    'data' => [
                        1 => 'Belanja',
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
                $model->kepemilikan = 12;
                $model->referensi_bukti = $bukti->no_bukti;
                $model->tgl_perolehan = $bukti->tgl_bukti;
                $model->nilai_perolehan = $bukti->nilai;
                $model->keterangan = $bukti->uraian;
                echo $form->field($model, 'kepemilikan')->widget(Select2::classname(), [
                    'data' => [
                        12 => 'Sekolah/Pemda',
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
        $attr1 = $attr2 = $attr3 = $attr4 = $attr5 = $attr6 = $attr7 = $attr8 = $attr9 = $attr10 = true;
        $attr1Label = 'Luas/Ruang/Judul Buku';
        $attr2Label = 'Alamat/Merk/Pencipta Buku';
        $attr3Label = 'Type/Dimensi';
        $attr4Label = 'CC/Ukuran';
        $attr5Label = 'Bahan';
        $attr6Label = 'No Pabrik';
        $attr7Label = 'No Rangka';
        $attr8Label = 'No Mesin';
        $attr9Label = 'No Polisi';
        $attr10Label = 'No BPKP';

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
$("input[name='TaAsetTetap[kode25]']").on("change", function(event){
    var kode25 = $(this).val();
    var kode25s = kode25.split('.');
    var rek1 = kode25s[0];
    $("input[name='TaAsetTetap[Kd_Aset1]']").val(rek1);
});

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