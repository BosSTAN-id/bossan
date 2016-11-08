<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TaSubUnit */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Ta Sub Unit',
]) . $model->Tahun;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ta Sub Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->Tahun, 'url' => ['view', 'Tahun' => $model->Tahun, 'Kd_Urusan' => $model->Kd_Urusan, 'Kd_Bidang' => $model->Kd_Bidang, 'Kd_Unit' => $model->Kd_Unit, 'Kd_Sub' => $model->Kd_Sub]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="ta-sub-unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
