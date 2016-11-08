<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use app\models\TaProgram;

/* @var $this yii\web\View */
/* @var $model app\modules\controlhutang\models\TaRASKArsipSearch */
/* @var $form yii\widgets\ActiveForm */
?>

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    
        <?php        
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'data' => [
                    '1' => 'Rekapitulasi Data Saldo SPH dan Sebaran Utang',
                    '2' => 'Rekapitulasi Kontrol Anggaran Utang'
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Jenis Laporan ...', 'onchange'=> 'this.form.submit()'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);        
        ?>    


    <?php ActiveForm::end(); ?>
