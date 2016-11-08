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

<div class="ta-raskarsip-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
    <div class="col-sm-6">
        <?php
            //This is for SKPD dropdownlist in search ----@hoaaah
        //'Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Prog', 'ID_Prog', 'Kd_Urusan1', 'Kd_Bidang1'
            $connection = \Yii::$app->db;           
            $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub,".",Kd_Prog,".",Id_Prog) AS kd, Ket_Program FROM Ta_Program WHERE Kd_Urusan='.Yii::$app->user->identity->Kd_Urusan.' AND Kd_Bidang='.Yii::$app->user->identity->Kd_Bidang.' AND Kd_Unit='.Yii::$app->user->identity->Kd_Unit.' AND Kd_Sub='.Yii::$app->user->identity->Kd_Sub);
            $query = $skpd->queryAll();        
            echo $form->field($model, 'program')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'kd','Ket_Program'),
                'options' => ['placeholder' => 'Pilih Program ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>    
    </div>
        <?php // echo $form->field($model, 'kd_sub') ?>
    <div class="col-sm-6">
        <?php  echo $form->field($model, 'Keterangan_Rinc' )->input('Keterangan_Rinc', ['placeholder' => "Cari Kegiatan..."])->label(false); ?>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-sm btn-default']) ?>
        </div>
    </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
