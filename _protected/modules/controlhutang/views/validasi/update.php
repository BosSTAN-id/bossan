<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaValidasiPembayaran */

$this->title = 'Update Ta Validasi Pembayaran: ' . $model->Kd_Bidang;
$this->params['breadcrumbs'][] = ['label' => 'Ta Validasi Pembayarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bidang, 'url' => ['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Validasi' => $model->No_Validasi, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-validasi-pembayaran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
