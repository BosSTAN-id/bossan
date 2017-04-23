<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefKecamatan */

$this->title = 'Update Ref Kecamatan: ' . $model->Kd_Prov;
$this->params['breadcrumbs'][] = ['label' => 'Ref Kecamatans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Prov, 'url' => ['view', 'Kd_Prov' => $model->Kd_Prov, 'Kd_Kab_Kota' => $model->Kd_Kab_Kota, 'Kd_Kecamatan' => $model->Kd_Kecamatan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-kecamatan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
