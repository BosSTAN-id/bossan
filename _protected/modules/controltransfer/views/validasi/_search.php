<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\Url;
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
            $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub) AS kd, Nm_Sub_Unit FROM Ref_Sub_Unit');
            $query = $skpd->queryAll();        
            echo $form->field($model, 'kd_skpd')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($query,'kd','Nm_Sub_Unit'),
                'options' => ['placeholder' => 'Pilih SKPD ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
        ?>    
    </div>
        <?php // echo $form->field($model, 'kd_sub') ?>
    <div class="col-sm-6">
    <?=
            $form->field($model, 'No_SPM')->widget(DepDrop::classname(), [
                'type'=>DepDrop::TYPE_SELECT2,
                'options'=>['id'=>'taspmsearch-No_SPM'],
                'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['taspmsearch-kd_skpd'],
                    'url'=>Url::to(['/controlhutang/validasi/spm']),
                    'placeholder'=>Yii::t('app','Pilih SPM'),
                ]
            ])->label(false);
        ?>

        <?php // echo $form->field($model, 'No_SPM' )->input('Keterangan_Rinc', ['placeholder' => "Cari SPM..."])->label(false); ?>
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
