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
    <div id="message"></div>
    <?= Html::a('Kamus Belanja', ['kamusbelanja'], [
                                                'class' => 'btn btn-xs btn-info',
                                                'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                                                ]) ?>
    <?php $form = ActiveForm::begin(['id' => $model->formName()
    // , 'layout' => 'horizontal'
    ]); ?>

    <?php 
            $connection = \Yii::$app->db;
            $skpd = $connection->createCommand('SELECT CONCAT(kd_penerimaan_1,".",kd_penerimaan_2) AS kd_penerimaan_2, CONCAT(kd_penerimaan_1,".",kd_penerimaan_2," ",uraian) AS uraian FROM ref_penerimaan_sekolah_2 WHERE sekolah = 1 AND kd_penerimaan_1 > 1');
            $data = $skpd->queryAll();    
            echo $form->field($model, 'penerimaan_2')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data, 'kd_penerimaan_2','uraian'),
                // 'value' => $model->kd_penerimaan_1.'.'.$model->kd_penerimaan_2,
                'options' => ['placeholder' => 'Sumber Dana ...'],
                'disabled' => true,
                'pluginOptions' => [
                    'allowClear' => true
                ],
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

    <?php 
            echo $form->field($model, 'komponen_id')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(
                    \app\models\RefKomponenBos::find()
                    ->select(['id', 'CONCAT(id,\' \',komponen) AS komponen'])
                    ->where(['bos_id' => 1])
                    // ->where(['Kd_Rek_1' => $model->Kd_Rek_1, 'Kd_Rek_2' => $model->Kd_Rek_2])
                    ->all()
                    ,'id','komponen'),
                'options' => ['placeholder' => 'Pilih Komponen BOS ...'],
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
            $("#message").html("server error");
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
            $("#message").html("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
}
?>