<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rkas-belanja-form">
    <?= Html::a('Kamus Belanja', ['kamusbelanja'], [
                                                'class' => 'btn btn-xs btn-info',
                                                'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                                                ]) ?>
    <?php $form = ActiveForm::begin(['id' => $model->formName()
    // , 'layout' => 'horizontal'
    ]); ?>

    <?php 
            $connection = \Yii::$app->db;
            $skpd = $connection->createCommand('SELECT CONCAT(a.kd_penerimaan_1,".",a.kd_penerimaan_2) AS kd_penerimaan_2, CONCAT(a.kd_penerimaan_1,".",a.kd_penerimaan_2," ", b.uraian_penerimaan_1,", ", a.uraian) AS uraian FROM ref_penerimaan_sekolah_2 a INNER JOIN ref_penerimaan_sekolah_1 b ON a.kd_penerimaan_1 = b.kd_penerimaan_1 WHERE a.sekolah = 1 AND a.kd_penerimaan_1 > 1');
            $data = $skpd->queryAll();    
            echo $form->field($model, 'penerimaan_2')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data, 'kd_penerimaan_2','uraian'),
                // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
                'options' => ['placeholder' => 'Pendapatan ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>     

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
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
}
?>