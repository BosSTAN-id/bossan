<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model app\modules\controltransfer\models\TaTrans3Search */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-12 pull-left">
    <?php 
            echo $form->field($model, 'Kd_Trans_1')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\TaTrans1::find()->where("Tahun = ".$Tahun)->all(),'Kd_Trans_1','Jns_Transfer'),
                'options' => ['placeholder' => 'Pilih Jenis ...', 'onchange'=>'this.form.submit()'],
                'size' => 'sm',
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
    ?>
    </div>

    <?php ActiveForm::end(); ?>
