<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSPH */

$this->title = 'Ubah SPH: ' . $model->No_SPH;
$this->params['breadcrumbs'][] = 'Control Hutang';
$this->params['breadcrumbs'][] = ['label' => 'Surat Pengakuan Hutang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Bidang, 'url' => ['view', 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_SPH' => $model->No_SPH, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="ta-sph-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
