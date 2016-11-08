<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaTransSKPD */

$this->title = 'Update Ta Trans Skpd: ' . $model->Kd_Bidang;
$this->params['breadcrumbs'][] = ['label' => 'Ta Trans Skpds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bidang, 'url' => ['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Trans_1' => $model->Kd_Trans_1, 'Kd_Trans_2' => $model->Kd_Trans_2, 'Kd_Trans_3' => $model->Kd_Trans_3, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-trans-skpd-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
