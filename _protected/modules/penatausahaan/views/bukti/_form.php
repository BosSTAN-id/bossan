<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;
use yii\widgets\MaskedInput;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPJRinc */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-spjrinc-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
        
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
            
        </div> <!--col-->

    </div> <!--row-->

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'no_bukti')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'tgl_bukti')->widget(\yii\jui\DatePicker::classname(), [
                'language' => 'id',
                'dateFormat' => 'yyyy-MM-dd',
                'options' => ['class' => 'form-control']
            ]) ?>              
        </div> <!--col-->

    </div> <!--row-->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'uraian')->textArea(['maxlength' => true]) ?>  
        </div>
    </div> <!--row-->

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <?= Html::a('Pilih Belanja', ['list'], [
                'class' => 'btn btn-xs btn-default',
                'data-toggle'=>"modal",
                'data-target'=>"#myModal",
                'data-title'=>"Pilih Belanja",
                ]) ?>    
        </div>    
    </div><!--row-->
    <div class="row">

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'kd_program')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'kd_sub_program')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'kd_kegiatan')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-offset-2 col-sm-offset-2 col-xs-offset-2 col-md-7 col-sm-7 col-xs-7">
            <span id="kegiatan">Kegiatan </span>
        </div> <!--col-->

    </div><!--row-->
    <div class="row">    

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'Kd_Rek_1')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'Kd_Rek_2')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'Kd_Rek_3')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'Kd_Rek_4')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-1 col-sm-1 col-xs-1">
            <?= $form->field($model, 'Kd_Rek_5')->textInput(['readonly' => true, 'class' => 'form-control input-sm'])->label(false) ?>
        </div> <!--col-->

        <div class="col-md-7 col-sm-7 col-xs-7">
            <span id="belanja">Belanja </span>
        </div> <!--col-->

    </div> <!--row-->

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
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
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'pembayaran')->radioList([1 => 'Bank', 2 => 'Tunai'], [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return '<label class="radio-inline">' . Html::radio($name, $checked, ['value'  => $value]) . $label . '</label>';
                }
            ]); ?>
        </div> <!--col-->

    </div> <!--row-->
    

    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'nm_penerima')->textInput(['maxlength' => true]) ?>        
        </div>

        <div class="col-md-6 col-sm-6 col-xs-6">
            <?= $form->field($model, 'alamat_penerima')->textInput(['maxlength' => true]) ?>            
        </div> <!--col-->

    </div> <!--row-->
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
<?php 
Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
    'options' => [
        'tabindex' => false // important for Select2 to work properly
    ], 
    'size' => 'modal-lg',
]);
 
echo '...';
 
Modal::end();
$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
?>