<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model app\models\TaTrans3 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-trans2-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'Kd_Trans_1')->textInput(['placeholder' => 'Nomor Urut Jenis ...'])->label(false) ?>

    <?= $form->field($model, 'Jns_Transfer')->textInput(['placeholder' => 'Nama Jenis Transfer Daerah ...'])->label(false) ?>

    <?= $form->field($model, 'SK_Transfer')->textInput(['placeholder' => 'SK Transfer Daerah ...'])->label(false) ?>

    <?= $form->field($model, 'Kd_Jns_DAK')->textInput(['placeholder' => 'Kode Jenis DAK ...'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?= GridView::widget([
        'id' => 'referensi',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                //'content' => $this->render('_search', ['model' => $searchModel]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'jenis-pjax', 'timeout' => 5000],
        ],             
        'columns' => [ 
            'Kd_Trans_1',
            'Jns_Transfer',
            'SK_Transfer',
            'Kd_Jns_DAK'
        ],
    ]); ?> 
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
                //$("#myModaljenis").modal('hide'); //hide modal after submit
                $(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#jenis-pjax'});
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
                //$("#myModalubah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#referensi-pjax'});
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