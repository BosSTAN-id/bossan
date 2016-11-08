<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaRPH */

$this->title = 'Update Ta Rph: ' . $model->Kd_Bidang;
$this->params['breadcrumbs'][] = ['label' => 'Ta Rphs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bidang, 'url' => ['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_RPH' => $model->No_RPH, 'No_SPH' => $model->No_SPH, 'No_SPM' => $model->No_SPM, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-rph-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
