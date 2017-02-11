<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use xj\bootbox\BootboxAsset;
use yii\bootstrap\Modal;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
?>

<div class="ta-trans3-search pull-right">

    <?php $form = ActiveForm::begin([
        'action' => ['index', 'Laporan[Kd_Laporan]' => Yii::$app->request->queryParams['Laporan']['Kd_Laporan'], 'Laporan[Tgl_1]' => Yii::$app->request->queryParams['Laporan']['Tgl_1'], 'Laporan[Tgl_2]' => Yii::$app->request->queryParams['Laporan']['Tgl_2']],
        'method' => 'get',
    ]); ?>
    <div class="col-md-12">
    <?php 
    // $skpd = $connection->createCommand('SELECT CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub) AS kd_skpd, Nm_Sub_Unit FROM Ref_Sub_Unit');
    $skpd = new \app\models\RefSubUnit();
            $skpd->skpd = isset(Yii::$app->request->queryParams['RefSubUnit']['skpd']) ? Yii::$app->request->queryParams['RefSubUnit']['skpd'] : NULL;
            echo $form->field($skpd, 'skpd')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefSubUnit::find()->select(['CONCAT(Kd_Urusan,".",Kd_Bidang,".",Kd_Unit,".",Kd_Sub) AS skpd', 'Nm_Sub_Unit'])->all(),'skpd','Nm_Sub_Unit'),
                'options' => ['placeholder' => 'Pilih SKPD / Sub Unit Organisasi ...', 'onchange'=>'this.form.submit()'],
                'size' => 'sm',
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
    ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>