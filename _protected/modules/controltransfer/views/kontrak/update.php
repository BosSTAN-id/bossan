<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaKontrak */

$this->title = 'Update Ta Kontrak: ' . $model->ID_Prog;
$this->params['breadcrumbs'][] = ['label' => 'Ta Kontraks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ID_Prog, 'url' => ['view', 'ID_Prog' => $model->ID_Prog, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Keg' => $model->Kd_Keg, 'Kd_Prog' => $model->Kd_Prog, 'Kd_Sub' => $model->Kd_Sub, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Urusan' => $model->Kd_Urusan, 'No_Kontrak' => $model->No_Kontrak, 'Tahun' => $model->Tahun]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ta-kontrak-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
