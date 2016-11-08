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
        //This is for SKPD dropdownlist in search ----@hoaaah
        //'Tahun', 'Kd_Urusan', 'Kd_Bidang', 'Kd_Unit', 'Kd_Sub', 'Kd_Prog', 'ID_Prog', 'Kd_Urusan1', 'Kd_Bidang1'
            // $connection = \Yii::$app->db;           
            // $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub,".",Kd_Prog,".",Id_Prog) AS kd, Ket_Program FROM Ta_Program WHERE Kd_Urusan='.Yii::$app->user->identity->Kd_Urusan.' AND Kd_Bidang='.Yii::$app->user->identity->Kd_Bidang.' AND Kd_Unit='.Yii::$app->user->identity->Kd_Unit.' AND Kd_Sub='.Yii::$app->user->identity->Kd_Sub);
            // $query = $skpd->queryAll();        
            // echo $form->field($model, 'program')->widget(Select2::classname(), [
            //     'data' => ArrayHelper::map($query,'kd','Ket_Program'),
            //     'options' => ['placeholder' => 'Pilih Program ...', 'class' => 'col-md-12'],
            //     'pluginOptions' => [
            //         'allowClear' => true
            //     ],
            // ])->label(false);
            $connection = \Yii::$app->db;           
            $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub) AS kd, Nm_Sub_Unit FROM Ref_Sub_Unit');
            $query = $skpd->queryAll();        
            echo $form->field($model, 'kd_skpd')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'kd','Nm_Sub_Unit'),
                'options' => ['class' =>'form-control input-sm' ,'placeholder' => 'Pilih SKPD ...', 'onchange'=> 'this.form.submit()'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);        
        ?>    


    <?php ActiveForm::end(); ?>
