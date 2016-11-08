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


    
        <?php //$model->Kd_Laporan = 3;
            echo $form->field($model, 'Kd_Laporan')->widget(Select2::classname(), [
                'value' => 5, // initial value
                'data' => [
                    // 1 => 'Rekapitulasi Pagu Dana Transfer',
                    // 2 => 'Rekapitulasi Control Anggaran Transfer',
                    3 => 'Posisi Saldo Dana Transfer',
                    4 => 'Rekapitulasi daftar Kontrak Dana Transfer',
                    5 => 'Rekapitulasi Realisasi Pembayaran Kontrak Dana Transfer',
                ],
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih Jenis Laporan ...', 'onchange'=> 'this.form.submit()'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);        
        ?>    


    <?php ActiveForm::end(); ?>
