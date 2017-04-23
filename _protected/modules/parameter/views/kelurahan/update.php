<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\RefDesa */

$this->title = 'Update Ref Desa: ' . $model->Kd_Prov;
$this->params['breadcrumbs'][] = ['label' => 'Ref Desas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Kd_Prov, 'url' => ['view', 'Kd_Prov' => $model->Kd_Prov, 'Kd_Kab_Kota' => $model->Kd_Kab_Kota, 'Kd_Kecamatan' => $model->Kd_Kecamatan, 'Kd_Desa' => $model->Kd_Desa]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ref-desa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
